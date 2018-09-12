<?php
namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class ArticleController
{

    /**
    * @Route("/")
    */
    public function homepage()
    {
        return new Response('sdgsdgsdg');
    }

    /**
    * @Route("/news/{article}")
    */
    public function show($article)
    {
        return new Response(sprintf("chosen article: ". $article));
    }
}
