<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Panier;
use App\Entity\Article;
use App\Entity\Commande;
use App\Form\PanierType;
use App\Form\CommentType;
use App\Form\CheckoutType;
use App\Entity\CommandeDetails;
use App\Form\CommandeDetailsType;
use App\Service\Cart\CartService;
use App\Repository\PanierRepository;
use Doctrine\ORM\EntityManagerInterface;
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
    public function index(): Response
    {

        $total = 0;
        $panier = $this->getDoctrine()->getRepository(Panier::class)->findAll();


        return $this->render('panier/index.html.twig', [
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
    /**
     * @Route("/panier/checkout", name="panier_check")
     */
    public function check(EntityManagerInterface $manager, Request $request): Response
    {
        //commande 


        // $commandeDetails = new CommandeDetails();
        // $manager = $this->getDoctrine()->getManager();

        // $commandeDetails->setName($user->getId());
        // $manager->persist($commandeDetails);
        // $manager->flush();

        
        $commandeDetails = new CommandeDetails();
        $formDetails = $this->createForm(CommandeDetailsType::class, $commandeDetails);

        $formDetails->handleRequest($request);
        if ($formDetails->isSubmitted() && $formDetails->isValid()) {

            //dd($commandeDetails);
            $manager->persist($commandeDetails);
            $manager->flush();
            
            $this->addFlash('success','Your Order has been successfully !');
        }

        //$commandes = $manager->getRepository(CommandeDetails::class)->findAll();

        return $this->render('panier/checkout.html.twig', [
            'commande' => $formDetails->createView(),
        ]);
    }
}
