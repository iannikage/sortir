<?php

namespace App\Controller;

use App\Repository\SortieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Sortie;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main_accueil")
     */
    public function list(SortieRepository $sortieRepository): Response
    {
        /** @var Sortie $sorties */
        $sorties = $sortieRepository->findAll();

        return $this->render('main/accueil.html.twig', [
           'liste_sortie'=>$sorties
        ]);
    }
}
