<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Service\Counter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function list(ArticleRepository $articleRepository, Counter $counter): Response
    {
        $articles = $articleRepository->findBy(array(), array('updatedAt' => 'DESC'));

        foreach ($articles as $article) {
            if (!empty($article->getText())) {
                $article->setReadingTime(
                    $counter->countReadingTime(
                        $article->getText()
                    )
                );
            }
        }

        return $this->render('pages/index.html.twig', [
            'articles' => $articles
        ]);
    }
}
