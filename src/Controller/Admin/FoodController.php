<?php


namespace App\Controller\Admin;
use App\Form\FoodType;
use phpDocumentor\Reflection\Types\This;
use App\Entity\Food;
use App\Repository\FoodRepository;
use App\Repository\TypeRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;


class FoodController extends AbstractController
{
    /**
     * @Route("/admin/foodlist", name="admin_foodList")
     * @param FoodRepository $foodRepository
     * @return Response
     */
    public function foodList(FoodRepository $foodRepository, TypeRepository $typeRepository)
    {

        $foods = $foodRepository->findAll();
        $types = $typeRepository->findAll();
        return $this->render('Admin/foods.html.twig', [
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
        return $this->render('Admin/insertFood.html.twig',[
            'foodForm' => $foodForm->createView()
        ]);

    }
}
