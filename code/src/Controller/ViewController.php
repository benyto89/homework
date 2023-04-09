<?php

namespace App\Controller;

use App\Entity\Article;
use App\Service\Counter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ViewController extends AbstractController
{
    #[Route('/article/{id}', name: 'article_view')]
    public function view(Article $article, Counter $counter): Response
    {
        if (!empty($article->getText()))
            $article->setReadingTime(
                $counter->countReadingTime(
                    $article->getText()
                )
            );

        return $this->render('pages/view.html.twig', [
            'article' => $article,
        ]);
    }
}
