<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Panier;
use App\Entity\Article;
use App\Entity\Commande;
use App\Form\PanierType;
use App\Service\Cart\CartService;
use App\Repository\PanierRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PanierController extends AbstractController
{
    /**
     * @Route("/panier", name="panier_index")
     */
    public function index(SessionInterface $session, PanierRepository $panierRepository): Response
    {

        $panier = $this->getDoctrine()->getRepository(Panier::class)->findAll();

 
      $total =0;


        return $this->render('panier/index.html.twig', [
            //'panierWithData' => $panierWithData,
            'total' => $total,
            'panier' => $panier,



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
    public function remove(Panier $panier)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($panier);
        $em->flush();
        return $this->redirectToRoute("panier_index");
    }
}
