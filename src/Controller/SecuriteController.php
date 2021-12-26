<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SecuriteController extends AbstractController
{
    /**
     * @Route("/register", name="securite_register")
     */
    public function register(Request $request, ManagerRegistry $managerRegistry)
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $managerRegistry->getManager();
            $em->persist($user);
            $em->flush();
        }


        return $this->render('securite/register.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
