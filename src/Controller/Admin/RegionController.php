<?php


namespace App\Controller\Admin;

use App\Entity\Appellation;
use App\Entity\Region;
use App\Form\AppellationType;
use App\Form\RegionType;
use App\Repository\RegionRepository;
use App\Repository\WineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class RegionController extends AbstractController
{
    /**
     * @Route("/admin/regions", name ="admin_region_list")
     */
    public function regionList(RegionRepository $regionRepository)
    {
        $regions = $regionRepository->findAll();
        return $this->render('Admin/Wine/regions.html.twig', [
            'regions' => $regions
        ]);
    }
    /**
     * @Route("/admin/insert/region", name="admin_region_insert")
     */
    public function insertRegion(EntityManagerInterface $entityManager,
                                Request $request){
        $region = new Region();
        $regionForm = $this->createForm(RegionType::class, $region);
        $regionForm->handleRequest($request);

        if ($regionForm->isSubmitted() && $regionForm->isValid()){
            // récupère la valeur de l'input cover, donc le fichier uploadé
            // je persiste le book
            $entityManager->persist($region);
            $entityManager->flush();
            $this->addFlash('success', 'Votre region a bien été enregistré' );
        }
        return $this->render('Admin/Wine/insertRegion.html.twig',[
            'regionForm' => $regionForm->createView()
        ]);
    }
    /**
     * @Route("/admin/delete/region/{id}", name="admin_delete_region")
     */
    public function deleteRegion(RegionRepository $regionRepository,
                                EntityManagerInterface $entityManager,
                                $id){
        $region = $regionRepository->find($id);

        $entityManager->remove($region);
        $entityManager->flush();

        $this->addFlash('success', 'Votre region a bien été supprimé' );
        return $this->redirectToRoute('admin_region_list');
    }
    /**
     * @Route("/admin/update/region/{id}", name="admin_update_region")
     */
    public function updateRegion(RegionRepository $regionRepository,
                                    EntityManagerInterface $entityManager,
                                    Request $request,
                                    $id){
        $region = $regionRepository->find($id);
        $regionForm = $this->createForm(RegionType::class, $region);
        $regionForm->handleRequest($request);

        if ($regionForm->isSubmitted() && $regionForm->isValid()) {
            //je persist le type
            $entityManager->persist($region);
            $entityManager->flush();

            //message flash
            $this->addFlash('success', 'votre region a été modifié');
        }
        return $this->render('Admin/Wine/insertRegion.html.twig', [
            'regionForm' => $regionForm->createView()
        ]);
    }

}