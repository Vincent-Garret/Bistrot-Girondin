<?php


namespace App\Controller\Front;


use App\Entity\Appellation;
use App\Entity\Region;
use App\Entity\Wine;
use App\Entity\Reservation;
use App\Form\AppellationType;
use App\Form\RegionType;
use App\Form\WineType;
use App\Form\ReservationType;
use App\Repository\AppellationRepository;
use App\Repository\ColorRepository;
use App\Repository\RegionRepository;
use App\Repository\WineRepository;
use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
class ReservationController extends AbstractController
{
    /**
     * @Route("/Reservation", name="Reservation")
     */
    public function reservation(Request $request,
                                EntityManagerInterface $entityManager,
                                ReservationRepository $reservationRepository
                                ){

        $reservation = new Reservation();

        $reservationForm = $this->createForm(ReservationType::class, $reservation);
        $reservationForm->handleRequest($request);

        if ($reservationForm->isSubmitted() && $reservationForm->isValid()) {
            // je persiste
            $entityManager->persist($reservation);
            $entityManager->flush();
            

            $this->addFlash('success', 'Votre vin a bien été enregistré !');
        }
        return $this->render('Front/Reservation.html.twig',[
            'reservationForm' => $reservationForm->createView()
        ]);
    }
}