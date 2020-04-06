<?php


namespace App\Controller\Admin;


use App\Entity\Appellation;
use App\Form\AppellationType;
use App\Repository\AppellationRepository;
use App\Repository\WineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class AppelationController extends AbstractController
{
    /**
     * @route("/admin/appellations", name="admin_appellation_list")
     */
    public function appellationList(AppellationRepository $appellationRepository){
        $appellations = $appellationRepository->findAll();
        return $this->render('Admin/Wine/appellations.html.twig',[
            'appellations' => $appellations
        ]);
    }
    /**
     * @Route("/admin/insert/appellation", name="admin_insert_appellation")
     */
    public function insertAppellation(AppellationRepository $appellationRepository,
                                        Request $request,
                                        EntityManagerInterface $entityManager){
        $appellation = new Appellation();
        $appellationForm = $this->createForm(AppellationType::class, $appellation);
        // je demande à mon formulaire $formType de gérer les données
        // de la requête POST
        $appellationForm->handleRequest($request);
        if ($appellationForm->isSubmitted() && $appellationForm->isValid()) {
            // récupère la valeur de l'input cover, donc le fichier uploadé
            // je persiste le book
            $entityManager->persist($appellation);
            $entityManager->flush();
            $this->addFlash('success', 'Votre appellation a bien été enregistré' );
        }
        return $this->render('Admin/Wine/insertAppellation.html.twig',[
            'appellationForm' => $appellationForm->createView()
        ]);
    }
    /**
     * @Route("/admin/update/appellation/{id}", name="admin_update_appellation")
     */
    public function updateAppellation(EntityManagerInterface $entityManager,
                                        AppellationRepository $appellationRepository,
                                        Request $request,
                                        $id){
        $appellation = $appellationRepository->find($id);
        $appellationForm = $this->createForm(AppellationType::class, $appellation);
        $appellationForm->handleRequest($request);

        if ($appellationForm->isSubmitted() && $appellationForm->isValid()) {
            //je persist le type
            $entityManager->persist($appellation);
            $entityManager->flush();

            //message flash
            $this->addFlash('success', 'votre plat a été modifié');
        }
        return $this->render('Admin/Wine/insertAppellation.html.twig', [
            'appellationForm' => $appellationForm->createView(),
        ]);
    }
    /**
     * @Route("/admin/delete/{id}", name="admin_delete_appellation")
     */
    public function deleteAppellation(EntityManagerInterface $entityManager,
                                      AppellationRepository $appellationRepository,
                                      $id){
        $appellation = $appellationRepository->find($id);

        $entityManager->remove($appellation);
        $entityManager->flush();

        $this->addFlash('success', 'Votre appellation à bien été supprimée');
        return $this->redirectToRoute('admin_appellation_list');
    }

}