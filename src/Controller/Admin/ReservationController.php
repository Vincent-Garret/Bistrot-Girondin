<?php


namespace App\Controller\Admin;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\ReservationRepository;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends AbstractController
{
    /**
     * @Route("/admin/reservation", name="admin_reservation_list")
     */
    public function reservationList(ReservationRepository $reservationRepository){

        $reservations = $reservationRepository->findAll();

        return $this->render('Admin/Reservation/reservations.html.twig', [
            'reservations' => $reservations
            ]);
    }

    /**
     * @Route("/admin/delete/reservation/{id}", name="admin_reservation_delete")
     */
    public function deleteReservation(ReservationRepository $reservationRepository,
                                        EntityManagerInterface $entityManager
                                        ,$id){
        $reservation = $reservationRepository->find($id);

        $entityManager->remove($reservation);
        $entityManager->flush();

        $this->addFlash('success', 'Votre reservation a bien été supprimée' );
        return $this->redirectToRoute('admin_reservation_list');
    }

    /**
     * @Route("/admin/active/reservation", name="admin_active_reservation")
     */
    public function getActiveReservation(ReservationRepository $reservationRepository){
        $reservation = $reservationRepository->getActiveReservation();
        return $this->render('Admin/Reservation/activeReservation.html.twig', [
              'reservations' => $reservation
            ]);
    }

    /**
     * @Route("/admin/nonactive/reservation", name="admin_non_active_reservation")
     */
    public function getNonActiveReservation(ReservationRepository $reservationRepository){
        $reservation = $reservationRepository->getNonActiveReservation();
        return $this->render('Admin/Reservation/nonActiveReservation.html.twig', [
            'reservations' => $reservation
        ]);
    }

}