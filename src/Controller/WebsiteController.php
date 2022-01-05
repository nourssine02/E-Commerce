<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Panier;
use App\Entity\Article;
use App\Entity\Favoris;
use App\Entity\Categorie;
use App\Form\SearchBarType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WebsiteController extends AbstractController
{
    /**
     * @Route("/", name="website")
     */
    public function index(Request $request, ArticleRepository $articleRepository): Response
    {
        $total =0;
        $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();
        $categories = $this->getDoctrine()->getRepository(Categorie::class)->findAll();
        $panier = $this->getDoctrine()->getRepository(Panier::class)->findAll();



        //Search  
        $form = $this->createForm(SearchBarType::class);
        $search = $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //on recherche correspondant aux mots cles
            $articles = $articleRepository->search($search->get('mots')
                ->getData());
        }

        return $this->render('website/index.html.twig', [
            'articles' => $articles,
            'categories' => $categories,
            'panier' => $panier,
            'total' => $total,
            'form' => $form->createView(),
           

        ]);
    }
}
