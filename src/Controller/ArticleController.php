<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController 
{
    /**
     * @Route("/")
     */
    public function homepage()
    {
        return new Response('OMG My first !');
    }

    /**
     * @Route("/news/{slug}")
     */
    public function show($slug)
    {
        return new Response(sprintf(
            'futur page to show one space article "%s"',
            $slug
        ));
    }
}