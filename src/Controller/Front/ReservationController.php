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
     * @Route("/reservation", name="Reservation")
     */
    public function reservation(Request $request,
                                EntityManagerInterface $entityManager,
                                ReservationRepository $reservationRepository,
                                \Swift_Mailer $mailer){

        $reservation = new Reservation();

        $reservationForm = $this->createForm(ReservationType::class, $reservation);
        $reservationForm->handleRequest($request);

        if ($reservationForm->isSubmitted() && $reservationForm->isValid()) {
            // je persiste et je flush
            $entityManager->persist($reservation);
            $entityManager->flush();
            $mail = $reservationForm['mail']->getData();
            $lastName = $reservationForm['lastName']->getData();
            $name = $reservationForm['name']->getData();
            $number = $reservationForm['number']->getData();
            $time = $reservationForm['time']->getData();
            $commentary = $reservationForm['commentary']->getData();
            //mailer
            $message = (new \Swift_Message('Votre réservation'))
                ->setFrom('bistrotgirondin33@gmail.com')
                ->setTo($mail)
                ->setSubject('Votre réservation')
                ->setBody($this->renderView('Mail/frontMail.html.twig',
                    ['lastName' => $lastName,
                    'number' => $number,
                    'name' => $name,
                    'time' => $time
                ]));

            $autoMessage =( new \Swift_Message('Nouvelle réservation'))
                ->setFrom('bistrotgirondin@gmail.com')
                ->setTo('bistrotgirondin@gmail.com')
                ->setSubject('Nouvelle réservation')
                ->setBody($this->renderView('Mail/adminMail.html.twig',
                    ['lastName' => $lastName,
                        'number' => $number,
                        'time' => $time,
                        'commentary' => $commentary
                    ]));

            $this->addFlash('success', 'Votre réservation a bien été enregistrée !');
            $mailer->send($message);
            $mailer->send($autoMessage);

        }
        return $this->render('Front/Reservation.html.twig',[
            'reservationForm' => $reservationForm->createView(),
        ]);
    }
}