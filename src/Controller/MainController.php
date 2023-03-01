<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Form\SearchFormType;
use App\Repository\SortieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Sortie;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main_accueil")
     */
    public function list(SortieRepository $sortieRepository, Request $request): Response
    {
        /** @var Sortie $sorties */
        $data = new SearchData();
        $form = $this->createForm(SearchFormType::class, $data);
        $form->handleRequest($request);
        $sorties = $sortieRepository->findSearch($data);
        //$sorties = $sortieRepository->findBy([]);

        return $this->render('main/accueil.html.twig', [
           'liste_sortie'=>$sorties,
            'form' => $form->createView()
        ]);
    }
}
