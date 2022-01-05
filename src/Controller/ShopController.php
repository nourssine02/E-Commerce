<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\Favoris;
use App\Form\PanierType;
use App\Entity\Categorie;
use App\Form\CommentType;
use App\Form\SearchBarType;
use App\Service\Cart\CartService;
use App\Repository\ArticleRepository;
use App\Repository\FavorisRepository;
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
    public function index(Request $request, ArticleRepository $articleRepository): Response
    {



        $total = 0;

        $categories = $this->getDoctrine()->getRepository(Categorie::class)->findAll();
        $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();
        $panier = $this->getDoctrine()->getRepository(Panier::class)->findAll();



        //Search  
        $form = $this->createForm(SearchBarType::class);
        $search = $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //on recherche correspondant aux mots cles
            $articles = $articleRepository->search($search->get('mots')
                ->getData());
        }

        return $this->render('shop/index.html.twig', [
            'articles' => $articles,
            'categories' => $categories,
            'panier' => $panier,
            'total' => $total,
            'form' => $form->createView(),


        ]);
    }

    /**
     * @Route("/shop/detail/{id}", name="shop_detail")
     */
    public function detail(Article $article, CartService $cartService, Request $request, EntityManagerInterface $manager): Response
    {

        $total = 0;


        //Order
        $panier = new Panier();


        $formP = $this->createForm(PanierType::class, $panier);
        $formP->handleRequest($request);

        if ($formP->isSubmitted() && $formP->isValid()) {
            $manager = $this->getDoctrine()->getManager();

            $user = $this->getUser();
            // if ($user) {
                $panier->setUserId($user->getId())
                    ->setArticleId($article->getId())
                    ->setArticleName($article->getName())
                    ->setPrixArticle($article->getPrix())
                    ->setImageArticle($article->getImage());


                $manager->persist($panier);
                $manager->flush();

                return $this->redirectToRoute("panier_index");
            // } else {
            //     return $this->redirectToRoute("securite_login");
            // }
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
        $paniers = $this->getDoctrine()->getRepository(Panier::class)->findAll();



        return $this->render('shop/detail.html.twig', [
            'article' => $article,
            'articles' => $articles,
            'items' => $cartService->getFullCart(),
            'total' => $total,
            'commentForm' => $form->createView(),
            'comment' => $comment,
            'form' => $formP->createView(),
            'panier' => $paniers

        ]);
    }

    /**
     * @Route("/shop/{id}/favoris", name="shop_favoris")
     */
    public function favoris(Article $article, EntityManagerInterface $manager, FavorisRepository $favorisRepository): Response
    {
        $user = $this->getUser();
        if (!$user) return $this->json([
            'code' => 403,
            'message' => 'Unauthorized'
        ], 403);
        if ($article->isLikedByUser($user)) {
            $favoris = $favorisRepository->findOneBy([
                'article' => $article,
                'user' => $user
            ]);
            $manager->remove($favoris);
            $manager->flush();
            return $this->json([
                'code' => 200,
                'message' => 'Favoris well remove',
                'favoris' => $favorisRepository->count(['article' => $article])
            ], 200);
        }
        $favoris = new Favoris();
        $favoris->setArticle($article)
            ->setUser($user);
        $manager->persist($favoris);
        $manager->flush();

        return $this->json([
            'code' => 200,
            'message' => 'Favoris well add',
            'favoris' => $favorisRepository->count(['article' => $article])
        ], 200);
    }
}
