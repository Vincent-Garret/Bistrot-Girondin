<?php


namespace App\Controller\Admin;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\ReservationRepository;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends AbstractController
{
    /**
     * @Route("/admin/reservation", name="amin_reservation_list")
     */
    public function reservationList(ReservationRepository $reservationRepository){

        $reservations = $reservationRepository->findAll();

        return $this->render('Admin/Reservation/reservations.html.twig', [
            'reservations' => $reservations
            ]);
    }
}