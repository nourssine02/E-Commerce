<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecuriteController extends AbstractController
{
    /**
     * @Route("/register", name="securite_register")
     */
    public function register(Request $request, ManagerRegistry $managerRegistry, UserPasswordHasherInterface $passwordHasher)
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $hash = $passwordHasher->hashPassword($user, $user->getPassword());
            $user->setPassword($hash);

            $em = $managerRegistry->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('securite_login');
        }


        return $this->render('securite/register.html.twig', [
            'form' => $form->createView()
        ]);
    }



    /**
     * @Route("/login", name="securite_login")
     */
    public function login()
    {

        return $this->render('securite/login.html.twig', []);
        return $this->redirectToRoute('website');
    }



    /**
     * @Route("logout", name="securite_logout")
     */
    public function logout()
    {
    }
}
