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

    /**
     * @Route("/admin/delete/wine/{id}", name="admin_delete_wine")
     */
    public function deleteWine(WineRepository $wineRepository,
                               EntityManagerInterface $entityManager,
                                $id){

        $wine = $wineRepository->find($id);

        $entityManager->remove($wine);
        $entityManager->flush();

        $this->addFlash('success', 'Votre vin à bien été effacé');
        return $this->redirectToRoute('admin_wine_list');
    }
    /**
     * @Route("/admin/updtate/wine/{id}", name="admin_update_wine")
     */
    public function updateWine(WineRepository $wineRepository,
                                EntityManagerInterface $entityManager,
                                Request $request,
                                $id){
        $wine = $wineRepository->find($id);
        $wineForm = $this->createForm(WineType::class, $wine);
        $wineForm->handleRequest($request);

        if ($wineForm->isSubmitted() && $wineForm->isValid()) {
            //je persist le type
            $entityManager->persist($wine);
            $entityManager->flush();

            //message flash
            $this->addFlash('success', 'votre vin a été modifié');
        }
        return $this->render('Admin/Wine/insertWine.html.twig', [
            'wineForm' => $wineForm->createView()
        ]);
    }
}