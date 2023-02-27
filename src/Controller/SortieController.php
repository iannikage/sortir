<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Entity\Sortie;
use App\Repository\SortieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sortie", name="app_sortie_")
 */
class SortieController extends AbstractController
{
    /**
     * @Route("/create", name="create")
     */
    public function createSortie(): Response
    {
        return $this->render('sortie/create.html.twig', [
            'controller_name' => 'SortieController',
        ]);
    }
    /**
     * @Route("/afficher/{id}", name="afficher")
     */

    public function afficherSortie(int $id, SortieRepository $sortieRepository): Response
    {
        $sortie = $sortieRepository->find($id);
        return $this->render('sortie/afficher.html.twig', [
            "sortie"=>$sortie
        ]);
    }

    /**
     * @Route("/annuler", name="annuler")
     */
    public function annulerSortie(): Response
    {
        return $this->render('sortie/annuler.html.twig', [
            'controller_name' => 'SortieController',
        ]);
    }


}
