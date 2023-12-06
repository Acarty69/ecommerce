<?php

namespace App\Controller;

use App\Entity\Adresse;
use App\Entity\OderItem;
use App\Entity\Order;
use App\Entity\Product;
use App\Repository\AdresseRepository;
use App\Service\CartService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    #[Route('/order', name: 'app_order')]
    public function order(EntityManagerInterface $manager): Response
    {

        $orderRepository = $manager->getRepository(Order::class);
        $order = $orderRepository->findAll();


        return $this->render('order/index.html.twig', [
            'controller_name' => 'ProductController',
            'orders' => $order,
        ]);

    }

    #[Route('/order/delete/{id}', name: 'delete_order')]
    public function delete(Order $order, EntityManagerInterface $manager, CartService $cartService): Response
    {
        $orderItems = $order->getOderItems();

        foreach ($orderItems as $orderItem) {
            $manager->remove($orderItem);
        }

        $manager->remove($order);

        $manager->flush();

        return $this->redirectToRoute('app_order');
    }


    #[Route('/order/billing/{id}', name: 'app_order_billing')]
    #[Route('/order/billing/', name: 'app_order_select_billing')]
    public function billing(Adresse $billingAdresse = null): Response
    {
        if($billingAdresse){
            return $this->redirectToRoute('app_order_select_shipping',['id' => $billingAdresse->getId()]);
        }

        return $this->render('order/billing.html.twig', [
            'controller_name' => 'OrderController',
        ]);
    }

    #[Route('/order/billing/{id}/shipping/{idShipping}', name: 'app_order_shipping')]
    #[Route('/order/billing/{id}/shipping/', name: 'app_order_select_shipping')]
    public function shipping(Adresse $billingAdresse = null, AdresseRepository $adresseRepository,$idShipping = null): Response
    {
        if($idShipping){
            $shippingAdresse = $adresseRepository->find($idShipping);
            if($shippingAdresse){
                return $this->redirectToRoute('app_payment', ['id'=>$billingAdresse->getId(), 'idShipping'=>$shippingAdresse->getId()]);
            }
        }


        return $this->render('order/shipping.html.twig', [ 'billingAddress'=>$billingAdresse
        ]);
    }

    #[Route('/order/payment/billing/{id}/shipping/{idShipping}', name:'app_payment')]
    public function payment(Adresse $billingAddress, AdresseRepository $addressRepository, $idShipping)
    {
        $shippingAddress = $addressRepository->find($idShipping);


        return $this->render('order/payment.html.twig', [ 'billingAddress'=>$billingAddress, "shippingAddress"=> $shippingAddress
        ]);
    }
    #[Route('/order/makeorder/billing/{id}/shipping/{idShipping}', name:'app_makeorder')]
    public function makeOrder(Adresse $billingAddress, AdresseRepository $addressRepository, $idShipping, CartService $cartService, EntityManagerInterface $manager)
    {
        $shippingAddress = $addressRepository->find($idShipping);

        $order = new Order();
        $order->setCreatedAt(new \DateTime());
        $order->setTotal($cartService->getTotal());
        $order->setFromUser($this->getUser()->getProfile());
        $order->setBillingAdresse($billingAddress);
        $order->setShippingAdresse($shippingAddress);
        $manager->persist($order);

        foreach($cartService->getCart() as $item)
        {
            $orderItem = new OderItem();
            $orderItem->setProduct($item['product']);
            $orderItem->setQuantity($item['quantity']);
            $orderItem->setOfOrder($order);
            $manager->persist($orderItem);
        }


        $manager->flush();


        return $this->redirectToRoute('app_profile');
    }


}
