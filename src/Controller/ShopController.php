<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Panier;
use App\Entity\Search;
use App\Entity\Article;
use App\Entity\Categorie;
use App\Entity\Comment;
use App\Entity\Commande;
use App\Form\PanierType;
use App\Form\SearchType;
use App\Entity\SearchBar;
use App\Form\CommentType;
use App\Form\SearchBarType;
use App\Service\Cart\CartService;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ShopController extends AbstractController
{
    /**
     * @Route("/shop", name="shop")
     */
    public function index(CartService $cartService, Request $request): Response
    {

        $Search = new SearchBar();
        $formS = $this->createForm(SearchBarType::class, $Search);
        $formS->handleRequest($request);


        $categories = $this->getDoctrine()->getRepository(Categorie::class)->findAll();
        $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();
        return $this->render('shop/index.html.twig', [
            'articles' => $articles,
            'categories' => $categories,
            'items' => $cartService->getFullCart(),
            'total' => $cartService->getTotal(),
            'formS' => $formS->createView()

        ]);
    }

    /**
     * @Route("/shop/detail/{id}", name="shop_detail")
     */
    public function detail(Article $article, CartService $cartService, Request $request, EntityManagerInterface $manager): Response
    {

        //Order
        $panier = new Panier();


        $formP = $this->createForm(PanierType::class, $panier);
        $formP->handleRequest($request);

        if ($formP->isSubmitted() && $formP->isValid()) {
            $manager = $this->getDoctrine()->getManager();

            $user = $this->getUser();
            $panier->setUserId($user->getId())
                ->setArticleId($article->getId())
                ->setArticle($article->getName())
                ->setPrixArticle($article->getPrix())
                ->setImageArticle($article->getImage());


            $manager->persist($panier);
            $manager->flush();



            return $this->redirectToRoute("panier_index");
        }


        //Commenter 
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            //dd($comment);
            $comment->setCreatedAt(new \DateTime())->setArticle($article);
            $manager->persist($comment);
            $manager->flush();

            return $this->redirectToRoute('shop_detail', ['id' => $article->getId()]);
        }

        $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();


        return $this->render('shop/detail.html.twig', [
            'article' => $article,
            'articles' => $articles,
            'items' => $cartService->getFullCart(),
            'total' => $cartService->getTotal(),
            'commentForm' => $form->createView(),
            'comment' => $comment,
            'form' => $formP->createView(),

        ]);
    }
}
