<?php

namespace App\Controller;

use App\Service\Mail;
use App\Entity\Reservation;
use App\Repository\ReservationRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CheckingController extends AbstractController
{
    /**
     * @Route("/consultation-reservations", name="checking_index")
     */
    public function index(ReservationRepository $repository)
    {
        $mail = $this->get('session')->get('mail');

        $reservations = $repository->findBy(['mail' => $mail]);

        return $this->render('checking/index.html.twig', [
            'reservations' => $reservations
        ]);
    }

    /**
     * show a reservation using its slug
     *
     * @Route("/reservation_{slug}", name="checking_show")
     */
    public function show(Reservation $reservation, Mail $mailService, \Swift_Mailer $mailer) // mailservice se fera depuis autre route appelée par le bouton
    {
        $mail = $this->get('session')->get('mail');

        return $this->render("checking/show.html.twig", [
            'reservation' => $reservation,
            'mail' => $mail,
            'mailer' => $mailer,
            'mailService' => $mailService
        ]);
    }

    public function resendMail()
    {
        
    }
}
