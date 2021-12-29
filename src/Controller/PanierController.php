<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Panier;
use App\Entity\Article;
use App\Entity\Commande;
use App\Form\PanierType;
use App\Service\Cart\CartService;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PanierController extends AbstractController
{
    /**
     * @Route("/panier", name="panier_index")
     */
    public function index(CartService $cartService): Response
    {
        $panierWithData = $cartService->getFullCart();

        $panier = $this->getDoctrine()->getRepository(Panier::class)->findAll();
        $total = $cartService->getTotal();

    


        return $this->render('panier/index.html.twig', [
            'items' => $panierWithData,
            'total' => $total,
            'panier' => $panier,
            'articles' => $cartService->getFullCart(),


        ]);
    }

    /**
     * @Route("/panier/add/{id}", name="panier_add")
     */
    public function add($id, CartService $cartService)
    {

        $cartService->add($id);

        return $this->redirectToRoute("panier_index");
    }


    /**
     * @Route("/panier/remove/{id}", name="panier_remove")
     */
    public function remove($id, CartService $cartService)
    {
        $cartService->remove($id);
        return $this->redirectToRoute("panier_index");
    }
}
