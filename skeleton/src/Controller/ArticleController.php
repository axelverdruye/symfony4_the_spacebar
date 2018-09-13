<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Psr\Log\LoggerInterface;
use App\Service\MarkdownHelper;
use App\Service\SlackClient;
use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;

class ArticleController extends AbstractController
{
    private $isDebug;

    public function __construct(bool $isDebug)
    {
        $this->isDebug = $isDebug;
    }

    /**
    * @Route("/", name="app_homepage")
    */
    public function homepage()
    {
        return $this->render('article/homepage.html.twig');
    }

    /**
    * @Route("/news/{slug}", name="article_show")
    */
    public function show($slug, SlackClient $slack, EntityManagerInterface $em)
    {
        if ($slug === 'khaaaaaan') {
            $slack->sendMessage('Kahn', 'ah, ksdjgkdsjgkdsgjkg');
        }

        $repository = $em->getRepository(Article::class);
        $article  = $repository->findOneBy(['slug' => $slug]);

        if (!$article) {
            throw $this->createNotFoundException(sprintf('No article for slug "%s"', $slug));
        }

        $comments = [
          'first comment',
          'second comment',
          'third comment'
        ];

        return $this->render('article/show.html.twig', [
          'comments' => $comments,
          'article' => $article
        ]);
    }

    /**
    * @Route("/news/{article}/like", name="article_like", methods={"POST"})
    */
    public function toggleArticleHeart($article, LoggerInterface $logger)
    {
        // TODO - actually heart/unheart the article!
        $logger->info('Article is being hearted!');

        return $this->json(['hearts' => rand(5, 100)]);
    }
}
