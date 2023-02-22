<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Repository\ParticipantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ParticipantController extends AbstractController
{
    /**
     * @Route("/monprofil", name="monprofil")
     */
    public function afficherProfil(ParticipantRepository $participantRepository): Response
    {
        /** @var Participant $participant */
        $participant = $this->getUser();
        return $this->render('participant/monprofil.html.twig',[
            'participant' => $participant,
        ]);

    }

}
