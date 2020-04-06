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
    public function appellationList(RegionRepository $regionRepository)
    {
        $regions = $regionRepository->findAll();
        return $this->render('Admin/Wine/regions.html.twig', [
            'regions' => $regions
        ]);
    }
    /**
     * @Route("/admin/insert/region", name="admin_region_insert")
     */
    public function insertRegion(RegionRepository $regionRepository,
                                EntityManagerInterface $entityManager,
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

}