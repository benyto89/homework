<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EditController extends AbstractController
{
    #[Route('/article/{id}/edit', name: 'article_edit')]
    public function edit(Article $article, Request $request, ArticleRepository $articles): Response
    {
        // Using a dirty cloning, but I have not found a better way to get the original object's state after submitting the form...
        $copy = clone $article;

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            if (
                $copy->getTitle() !== $data->getTitle() ||
                $copy->getText() !== $data->getText() ||
                $copy->getImage() !== $data->getImage()
            ) {
                $data->setUpdatedAt(new \DateTime());
                $articles->save($data, true);
            }

            return $this->redirectToRoute('home');
        }

        return $this->renderForm('pages/edit.html.twig', [
            'form' => $form,
            'article' => $article
        ]);
    }
}
