<?php

namespace App\Service;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class CartService
{

    private $productRepo;
    private $session;

    public function __construct(ProductRepository $productRepo, RequestStack $requestStack){
        $this->productRepo = $productRepo;
        $this->session = $requestStack->getSession();
}

    public function getCart():array
    {

        $cart = $this->session->get('sessionCart', []);
        $objectsCart = [];

        foreach ($cart as $productId => $quantity) {
            $item = [
                'product' => $this->productRepo->find($productId),
                'quantity' => $quantity
            ];
            $objectsCart[] = $item;
        }

        return $objectsCart;
    }



        public function addProduct(Product $product, $quantity){

    $cart = $this->session->get('sessionCart', []);

    if(isset($cart[$product->getId()])){
        $cart[$product->getId()] += $quantity;
    }
    else{
        $cart[$product->getId()] = $quantity;

    }
    $this->session->set('sessionCart', $cart);
}

public function getTotal():int
    {
        $total = 0;


        foreach ($this->getCart() as $item)
        {

            $total += $item['product']->getPrix() * $item['quantity'];
        }

        return $total;
    }

    public function count(): int
    {
        $count = 0;

        foreach ($this->session->get('sessionCart', []) as $quantity)
        {
            $count+=$quantity;
        }

        return $count;
    }



}