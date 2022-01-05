<?php

namespace App\Service\Cart;

use App\Repository\PanierRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService
{

    protected $session;

    protected $papanierRepositorynier;

    public function __construct(SessionInterface $session, PanierRepository $panierRepository)
    {
        $this->session = $session;
        $this->panierRepository = $panierRepository;
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
        foreach ($panier as $id ) {
            $panierWithData[] = [
                'panier' => $this->panierRepository->find($id)

            ];
        }

        return $panierWithData;
    }

//     public function getTotal(): float
//     {

//         $total = 0;
//         $panierWithData = $this->getFullCart();
//         foreach ($panierWithData as $item) {

//             $totalItem = $item['article']->getPrix() * $item['quantite'];
//             $total += $totalItem;
//         }
//         return $total;
//     }

}
