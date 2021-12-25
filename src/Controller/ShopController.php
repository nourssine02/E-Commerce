<?php

namespace App\Controller;

use App\Entity\Article;
use App\Service\Cart\CartService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ShopController extends AbstractController
{
    /**
     * @Route("/shop", name="shop")
     */
    public function index(CartService $cartService): Response
    {

        //$panierWithData = $cartService->getFullCart();
        //$total = $cartService->getTotal();

        $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();
        return $this->render('shop/index.html.twig', [
            'articles' => $articles,
            'items' => $cartService->getFullCart(),
            'total' => $cartService->getTotal(),

        ]);
    }

    /**
     * @Route("/shop/detail/{id}", name="shop_detail")
     */
    public function detail(Article $article , CartService $cartService): Response
    {
        $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();

        return $this->render('shop/detail.html.twig', [
            'article' => $article,
            'articles' => $articles,
            'items' => $cartService->getFullCart(),
            'total' => $cartService->getTotal(),
        ]);
    }
}
