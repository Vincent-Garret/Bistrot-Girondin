<?php


namespace App\Controller\Admin;

use App\Entity\Appellation;
use App\Entity\Region;
use App\Entity\Wine;
use App\Form\AppellationType;
use App\Form\RegionType;
use App\Form\WineType;
use App\Repository\AppellationRepository;
use App\Repository\ColorRepository;
use App\Repository\RegionRepository;
use App\Repository\WineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class WineController extends AbstractController
{
    /**
     * @route("/admin/wine", name="admin_wine_list")
     */

    public function wineList(WineRepository $wineRepository,
                            RegionRepository $regionRepository,
                            ColorRepository $colorRepository,
                            AppellationRepository $appellationRepository){
        $wines = $wineRepository->findAll();
        $regions = $regionRepository->findAll();
        $colors = $colorRepository->findAll();
        $appellations = $appellationRepository->findAll();

        return $this->render('Admin/Wine/wines.html.twig',[
            'wines' => $wines,
            'regions' => $regions,
            'colors' => $colors,
            'appellations' => $appellations
        ]);
    }

    /**
     * @Route("/admin/insert/wine", name="admin_insert_wine")
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @return Response
     */
    public function insertWine(EntityManagerInterface $entityManager,
                                Request $request){
        $wine = new Wine();

        $wineForm = $this->createForm(WineType::class, $wine);
        $wineForm->handleRequest($request);

        if ($wineForm->isSubmitted() && $wineForm->isValid()) {
            // je persiste le wine
            $entityManager->persist($wine);
            $entityManager->flush();
            $this->addFlash('success', 'Votre vin a bien été ajouté !');
        }
        return $this->render('Admin/Wine/insertWine.html.twig',[
            'wineForm' => $wineForm->createView()
        ]);
    }
}