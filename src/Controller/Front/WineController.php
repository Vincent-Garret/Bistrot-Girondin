<?php


namespace App\Controller\Front;
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
     * @route("/wines", name="wine_list")
     */

    public function wineList(WineRepository $wineRepository,
                             RegionRepository $regionRepository,
                             ColorRepository $colorRepository,
                             AppellationRepository $appellationRepository){
        $wines = $wineRepository->findAll();
        $regions = $regionRepository->findAll();
        $colors = $colorRepository->findAll();
        $appellations = $appellationRepository->findAll();
        return $this->render('Front/wines.html.twig',[
            'wines' => $wines,
            'regions' => $regions,
            'colors' => $colors,
            'appellations' => $appellations
        ]);
    }

}