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
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

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
    public function homepage(ArticleRepository $repository)
    {
        $articles = $repository->findAllPublishedOrderedByNewest();

        return $this->render('article/homepage.html.twig', [
          'articles' => $articles
        ]);
    }

    /**
    * @Route("/news/{slug}", name="article_show")
    */
    public function show(Article $article, SlackClient $slack)
    {
        if ($article->getSlug() === 'khaaaaaan') {
            $slack->sendMessage('Kahn', 'ah, ksdjgkdsjgkdsgjkg');
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
    * @Route("/news/{slug}/like", name="article_like", methods={"POST"})
    */
    public function toggleArticleHeart(Article $article, LoggerInterface $logger, EntityManagerInterface $em)
    {
        $article->incrementHeartCount();
        $em->flush();

        // TODO - actually heart/unheart the article!
        $logger->info('Article is being hearted!');
        return new JsonResponse(['hearts' => $article->getHeartCount()]);
    }
}
