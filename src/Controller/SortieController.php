<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Etat;
use App\Entity\Participant;
use App\Entity\Sortie;
use App\Form\ModificationType;
use App\Form\SearchFormType;
use App\Repository\EtatRepository;
use App\Repository\ParticipantRepository;
use App\Repository\SortieRepository;
use App\Form\AnnulationType;
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
     * @Route("/modifier/{id}", name="modifier")
     */
    public function modifierSortie(int $id, SortieRepository $sortieRepository, EtatRepository $etatRepository, Request $request, EntityManagerInterface $entityManager ): Response
    {

        $sortie = $sortieRepository->find($id);

        $modificationForm = $this->createForm(ModificationType::class, $sortie);
        $modificationForm->handleRequest($request);

        if ($modificationForm->isSubmitted() && $modificationForm->isValid()) {

            $entityManager->persist($sortie);
            $entityManager->flush();

            $this->addFlash('success','Sortie modifiée avec succès');
            return $this->redirectToRoute('main_accueil');
        }

        return $this->render('sortie/modifier.html.twig', [
            'modificationForm' => $modificationForm->createView(),
        ]);
    }

    /**
     * @Route("/annuler/{id}", name="annuler")
     */
    public function annulerSortie(int $id, SortieRepository $sortieRepository, EtatRepository $etatRepository, Request $request, EntityManagerInterface $entityManager ): Response
    {

        $sortie = $sortieRepository->find($id);

        $annulationForm = $this->createForm(AnnulationType::class, $sortie);
        $annulationForm->handleRequest($request);

        if ($annulationForm->isSubmitted() && $annulationForm->isValid()) {
            $etat = $etatRepository->findOneBy(['libelle' => "Annulée"]);
            $sortie->setEtat($etat);
            $entityManager->persist($sortie);
            $entityManager->flush();

            $this->addFlash('success','Sortie annulée avec succès');
            return $this->redirectToRoute('main_accueil');
    }

        return $this->render('sortie/annuler.html.twig', [
            'annulationForm' => $annulationForm->createView(),
        ]);
    }


    /**
     * @Route("/inscrire/{id}", name="inscrire")
     */
    public function inscrire (EntityManagerInterface $entityManager, ?Sortie $sortie):Response
    {
        if (!$sortie) {
            throw $this->createNotFoundException('Sortie inconnue');
        }
        $sortie->addParticipant($this->getUser());
        $entityManager->persist($sortie);
        $entityManager->flush();

        $this->addFlash('success', 'Inscription effectuée avec succès');
        return $this->redirectToRoute('main_accueil');
    }

    /**
     * @Route("/desister/{id}", name="desister")
     */

    public function desister (EntityManagerInterface $entityManager, ?Sortie $sortie) :Response
    {
        if (!$sortie) {
            throw $this->createNotFoundException('Sortie inconnue');
        }

        $sortie->removeParticipant($this->getUser());
        $entityManager->persist($sortie);
        $entityManager->flush();

        $this->addFlash('success', 'Désistement effectué avec succès');
        return $this->redirectToRoute('main_accueil');

    }

    /**
     * @Route("/profilorga/{id}", name="profilorga")
     */
    public function profilOrga(int $id, ParticipantRepository $participantRepository): Response
    {
        $organisateur = $participantRepository->find($id);
        return $this->render('sortie/profilorga.html.twig', [
            "organisateur"=>$organisateur
        ]);
    }

}