<?php

namespace App\Controller;

use App\Entity\Like;
use App\Entity\Product;
use App\Entity\Profile;
use App\Repository\LikeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LikeController extends AbstractController
{
    #[Route('/like', name: 'app_like')]
    public function index(): Response
    {
        return $this->render('like/index.html.twig', [
            'controller_name' => 'LikeController',
        ]);
    }


    #[Route('/like/{id}', name: 'like_product')]
    public function like(Product $product, LikeRepository $repository, EntityManagerInterface $manager): Response
    {
        $profile = $this->getUser()->getProfile();

        if($product->isLikedBy($profile)){
            $like = $repository->findOneBy([
                'author'=>$profile,
                'product'=>$product
            ]);
            $manager->remove($like);
            $isLike=false;
        }else{
            $like = new Like();
            $like->setProduct($product);
            $like->setAuthor($profile);
            $manager->persist($like);
            $isLike = true;}


        $manager->flush();
        $data = [
            'liked' => $isLike,
            'count' => $repository->count(['product'=>$product])
        ];


        return $this->json($data, 201);
    }
}
