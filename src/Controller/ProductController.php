<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Product;
use App\Entity\ProductImage;
use App\Form\DropImageType;
use App\Form\ImageType;
use App\Form\ProdcutType;
use App\Form\ProductImageType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;


class ProductController extends AbstractController
{

    #[Route('/product', name: 'app_product')]
    public function index(EntityManagerInterface $manager): Response
    {
        $productRepository = $manager->getRepository(Product::class);
        $products = $productRepository->findAll();

        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
            'products' => $products,
        ]);
    }

    #[Route('/product/create', name: 'create_product')]
    public function create(EntityManagerInterface $manager, Request $request): Response
    {
        $user = $this->getUser();

        if(!$user){
            return $this->redirectToRoute('app_product');
        }

        $product = new Product();

        $form = $this->createForm(ProdcutType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $product->setAuthor($user);
            $manager->persist($product);
            $manager->flush();
            return $this->redirectToRoute('app_product');

        }

        return $this->render('product/create.html.twig', [
            'controller_name' => 'ProductController',
            'form' => $form,
        ]);
    }

    #[Route('/product/update/{id}', name: 'update_product')]
    public function update(Product $product,EntityManagerInterface $manager, Request $request): Response
    {
        $user = $this->getUser();

        if(!$user || !$product || $user != $product->getAuthor()){
            return $this->redirectToRoute('app_product');
        }

        $form = $this->createForm(ProdcutType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $product->setAuthor($user);
            $manager->persist($product);
            $manager->flush();
            return $this->redirectToRoute('app_product');

        }

        return $this->render('product/create.html.twig', [
            'controller_name' => 'ProductController',
            'form' => $form,
        ]);
    }



    #[Route('/product/show/{id}', name: 'show_product')]
    public function show(Product $product): Response
    {

        $imageForm = $this->createForm(DropImageType::class);


        return $this->render('product/show.html.twig', [
            'controller_name' => 'ProductController',
            'product' => $product,
            'form'=>$imageForm
        ]);
    }

    #[Route('/product/delete/{id}', name: 'delete_product')]
    public function delete(Product $product, EntityManagerInterface $manager): Response
    {

        $user = $this->getUser();

        if(!$user || !$product || $user != $product->getAuthor()){
            return $this->redirectToRoute('app_product');
        }

        $manager->remove($product);
        $manager->flush();

        return $this->redirectToRoute('app_product');
    }



}

