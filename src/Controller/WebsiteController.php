<?php

namespace App\Controller;

use App\Entity\Article;
use App\Service\Cart\CartService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WebsiteController extends AbstractController
{
    /**
     * @Route("/", name="website")
     */
    public function index(CartService $cartService): Response
    {
        $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();
        return $this->render('website/index.html.twig', [
            'articles' => $articles,
            'items' => $cartService->getFullCart(),
            'total' => $cartService->getTotal(),

        ]);
    }
}
