<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\Participant;
use App\Entity\Sortie;
use App\Repository\SortieRepository;
use App\Repository\EtatRepository;
use App\Form\RegistrationFormType;
use App\Form\SortieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function createSortie(
        Request $request,
        EntityManagerInterface $entityManager,
        EtatRepository $etatRepository
    ): Response
    {
        $sortie = new Sortie();
        $sortie->setOrganisateur($this->getUser());

        $etat=$etatRepository->findOneBy(['libelle' =>'ouverte']);
        $sortie->setEtat($etat);

        $sortieForm = $this->createForm(SortieType::class, $sortie);
        $sortieForm->handleRequest($request);

        if ($sortieForm->isSubmitted() && $sortieForm->isValid()){
            $entityManager->persist($sortie);
            $entityManager->flush();

            $this->addFlash('success','Sortie créée avec succès');
            return $this->redirectToRoute('main_accueil');
        }

        return $this->render('sortie/create.html.twig', [
            'sortieForm' => $sortieForm->createView(),
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
        ]);
    }


}
