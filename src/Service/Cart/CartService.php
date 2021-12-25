<?php

namespace App\Service\Cart;

use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService
{

    protected $session;

    protected $articleRepository;

    public function __construct(SessionInterface $session, ArticleRepository $articleRepository)
    {
        $this->session = $session;
        $this->articleRepository = $articleRepository;
    }


    //add article
    public function add(int $id)
    {

        $panier =  $this->session->get('panier', []);

        if (!empty($panier[$id])) {

            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }
        $this->session->set('panier', $panier);
    }


    //remove article
    public function remove(int $id)
    {

        $panier = $this->session->get('panier', []);

        if (!empty($panier[$id])) {
            unset($panier[$id]);
        }

        $this->session->set('panier', $panier);
    }

    //getFullCart

    public function getFullCart(): array
    {

        $panier = $this->session->get('panier', []);

        $panierWithData = [];
        foreach ($panier as $id => $qteStock) {
            $panierWithData[] = [
                'article' => $this->articleRepository->find($id),
                'qteStock' => $qteStock
            ];
        }

        return $panierWithData;
    }

     public function getTotal(): float {

        $total = 0;
        $panierWithData = $this->getFullCart();
        foreach ($panierWithData as $item) {
            
            $totalItem = $item['article']->getPrix() * $item['qteStock'];
            $total += $totalItem;
        }
        return $total;
     }


}
