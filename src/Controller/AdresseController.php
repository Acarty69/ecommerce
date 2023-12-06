<?php

namespace App\Controller;

use App\Entity\Adresse;
use App\Entity\Profile;
use App\Form\AdresseType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdresseController extends AbstractController
{
    #[Route('/adresse', name: 'app_adresse')]
    public function index(): Response
    {
        return $this->render('adresse/index.html.twig', [
            'controller_name' => 'AdresseController',
        ]);
    }

    #[Route('/adresse/new', name: 'add_addresse')]
    public function new(Request $request,EntityManagerInterface $manager): Response
    {
        $profile = $this->getUser()->getProfile();
        $adresse = new Adresse();
        $form = $this->createForm(AdresseType::class,$adresse);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $adresse->setProfile($profile);
            $manager->persist($adresse);
            $manager->flush();
            return $this->redirectToRoute('app_profile');

        }
        return $this->render('adresse/index.html.twig', [
            'controller_name' => 'AdresseController',
            'form' => $form
        ]);
    }

    #[Route('/adresse/update/{id}', name: 'update_adresse')]
    public function update(Adresse $adresse,Request $request,EntityManagerInterface $manager): Response
    {
        $profile = $this->getUser()->getProfile();
        $form = $this->createForm(AdresseType::class,$adresse);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $adresse->setProfile($profile);
            $manager->persist($adresse);
            $manager->flush();
            return $this->redirectToRoute('app_profile');

        }
        return $this->render('adresse/index.html.twig', [
            'controller_name' => 'AdresseController',
            'form' => $form
        ]);
    }

    #[Route('/adresse/delete/{id}', name: 'delete_adresse')]
    public function delete(Adresse $adresse,Request $request,EntityManagerInterface $manager): Response
    {
            $manager->remove($adresse);
            $manager->flush();
            return $this->redirectToRoute('app_profile');

    }

}
