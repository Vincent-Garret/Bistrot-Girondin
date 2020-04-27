<?php


namespace App\Controller\Admin;

// pour pouvoir utiliser cette classe dans mon code
use App\Entity\Type;
use App\Form\TypeType;
use phpDocumentor\Reflection\Types\This;
use App\Entity\Food;
use App\Repository\FoodRepository;
use App\Repository\TypeRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class TypeController extends AbstractController
{
    /**
     * @Route("/admin/typelist", name="admin_type_list")
     * @param TypeRepository $typeRepository
     * @return Response
     */
    public function type(TypeRepository $typeRepository)
    {
        $types = $typeRepository->findAll();

        return $this->render('Admin/Food/types.html.twig', [
            'types' => $types
        ]);
    }

    /**
     * @Route("admin/insert/type", name="admin_insert_type")
     */
    public function insertType(
        Request $request,
        EntityManagerInterface $entityManager,
        SluggerInterface $slugger
    )
    {
        //je cree un nouveau type pour le liéer a mon formulaire
        $type = new Type();

        // je créé mon formulaire, et je le lie à mon nouveau type
        $typeForm = $this->createForm(TypeType::class, $type);

        // je demande à mon formulaire $typeForm de gérer les données
        // de la requête POST
        $typeForm->handleRequest($request);

        // si le formulaire a été envoyé, et que les données sont valides
        if ($typeForm->isSubmitted() && $typeForm->isValid()) {
            // récupère la valeur de l'input cover, donc le fichier uploadé
            // je persiste le book
            $entityManager->persist($type);
            $entityManager->flush();
            // j'ajoute un message "flash"
            $this->addFlash('success', 'Votre type a été créé !');
            return $this->redirectToRoute('admin_type_list');
        }
        return $this->render('Admin/Food/insertForm.html.twig', [
            'typeForm' => $typeForm->createView()
        ]);

    }

    /**
     * @Route("admin/type/delete/{id}", name="admin_type_delete")
     * @param TypeRepository $typeRepository
     * @param EntityManagerInterface $entityManager
     * @param $id
     * @return Response
     */
    public function deleteType(TypeRepository $typeRepository,
                                EntityManagerInterface $entityManager,
                                $id){
        $type = $typeRepository->find($id);

        $entityManager->remove($type);
        $entityManager->flush();

        return new Response('Le type à bien été supprimé');
    }
    /**
     * @Route("admin/type/update/{id}", name="admin_type_update")
     */
    public function updateType(TypeRepository $typeRepository,
                                EntityManagerInterface $entityManager,
                                Request $request,
                                $id){
        $type = $typeRepository->find($id);
        $formType = $this->createForm(TypeType::class, $type);
        $formType->handleRequest($request);

        if($formType->isSubmitted() && $formType->isValid()){
            //je persist le type
            $entityManager->persist($type);
            $entityManager->flush();

            //message flash
            $this->addFlash('success', 'votre type a été modifié');
        }


        $entityManager->persist($type);
        $entityManager->flush();
        return $this->render('Admin/Food/insertForm.html.twig',[
            'formType' => $formType->createView()
        ]);

    }

}