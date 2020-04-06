<?php


namespace App\Controller\Admin;
use App\Form\FoodType;
use App\Entity\Food;
use App\Repository\FoodRepository;
use App\Repository\TypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;


class FoodController extends AbstractController
{
    /**
     * @Route("/admin/foods", name="admin_food_list")
     * @param FoodRepository $foodRepository
     * @return Response
     */
    public function foodList(FoodRepository $foodRepository, TypeRepository $typeRepository)
    {

        $foods = $foodRepository->findAll();
        $types = $typeRepository->findAll();
        return $this->render('Admin/Food/foods.html.twig', [
            'foods' => $foods,
            'types' => $types
        ]);

    }

    /**
     * @Route("/admin/insert/food", name="admin_insert_food")
     */
    public function insertFood(Request $request,
                               FoodRepository $foodRepository,
                               SluggerInterface $slugger,
                               EntityManagerInterface $entityManager)
    {
        $food = new Food();
        $foodForm = $this->createForm(FoodType::class, $food);

        // je demande à mon formulaire $formType de gérer les données
        // de la requête POST
        $foodForm->handleRequest($request);

        if ($foodForm->isSubmitted() && $foodForm->isValid()) {
            // récupère la valeur de l'input cover, donc le fichier uploadé
            // je persiste le book
            $entityManager->persist($food);
            $entityManager->flush();
        }
        return $this->render('Admin/Food/insertFood.html.twig',[
            'foodForm' => $foodForm->createView()
        ]);
    }
    /**
     * @Route("/admin/delete/{id}", name="admin_delete_food")
     */
    public function deleteFood(FoodRepository $foodRepository,
                                EntityManagerInterface $entityManager,
                                $id){
        $food = $foodRepository->find($id);

        $entityManager->remove($food);
        $entityManager->flush();

        $this->addFlash('success', 'Votre plat a bien été supprimé' );
        return $this->redirectToRoute('admin_food_list');
    }
    /**
     * @Route("/admin/update/{id}", name="admin_update_food")
     */
    public function updateFood(FoodRepository $foodRepository,
                               EntityManagerInterface $entityManager,
                               Request $request,
                               $id)
    {
        $food = $foodRepository->find($id);
        $foodForm = $this->createForm(FoodType::class, $food);
        $foodForm->handleRequest($request);

        if ($foodForm->isSubmitted() && $foodForm->isValid()) {
            //je persist le type
            $entityManager->persist($food);
            $entityManager->flush();

            //message flash
            $this->addFlash('success', 'votre plat a été modifié');

        }
        return $this->render('Admin/Food/insertFood.html.twig', [
            'foodForm' => $foodForm->createView(),
        ]);
    }
}
