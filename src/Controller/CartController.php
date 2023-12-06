<?php

namespace App\Controller;

use App\Entity\Product;
use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function index(CartService $cartService): Response
    {


        return $this->render('cart/index.html.twig', [
            'cart' => $cartService->getCart(),
            'total' => $cartService->getTotal(),
        ]);
    }


    #[Route('/cart/add/{id}/{quantity}', name: 'add_cart')]
    public function addProduct(Product $product,$quantity,CartService $cartService): Response
    {

        if(!$product){return $this->redirectToRoute('app_cart');}

        $cartService->addProduct($product,$quantity);

        return $this->redirectToRoute('app_cart');

    }
}
