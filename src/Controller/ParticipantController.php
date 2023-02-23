<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\ProfilFormType;
use App\Repository\ParticipantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ParticipantController extends AbstractController
{
    /**
     * @Route("/monprofil", name="monprofil")
     */
    public function modifierProfil(ParticipantRepository $participantRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        /** @var Participant $participant */
        $participant = $this->getUser();
        $profilForm = $this->createForm(ProfilFormType::class, $participant);
        $profilForm->handleRequest($request);

        if ($profilForm->isSubmitted() && $profilForm->isValid()) {
            $entityManager->persist($participant);
            $entityManager->flush();


            $this->addFlash('success','Profil modifié avec succès');
            return $this->redirectToRoute('monprofil');
        }



        return $this->render('participant/monprofil.html.twig', [
            'ProfilFormType' => $profilForm->createView()
        ]);

}

}
