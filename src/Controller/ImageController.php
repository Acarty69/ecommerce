<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Product;
use App\Form\DropImageType;
use App\Form\ImageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/image/')]

class ImageController extends AbstractController
{
    #[Route('addtoproduct/{id}', name: 'image_addToProduct')]
    public function addToProduct(Product $product,EntityManagerInterface $manager, Request $request): Response
    {

        $image = new Image();
        $form = $this->createForm(DropImageType::class);

        $imageObj = $request->files->get('drop_image');
        $imageFile = $imageObj['dropZoneFile'];


            $image->setProduct($product);
            $image->setImageFile($imageFile);
            $manager->persist($image);
            $manager->flush();
        return $this->redirectToRoute('show_product',['id' => $product->getId()]);



    }

    #[Route('removefromproduct/{id}', name: 'image_removeFromProduct')]
    public function removeFromProduct(Image $image,EntityManagerInterface $manager): Response
    {

            $product = $image->getProduct();
            $manager->remove($image);
            $manager->flush();
            return $this->redirectToRoute('show_product',['id' => $product->getId()]);
            //return $this->redirectToRoute('app_product');


    }
}
