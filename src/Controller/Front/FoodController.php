<?php


namespace App\Controller\Front;


use App\Repository\FoodRepository;
use App\Repository\TypeRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;



class FoodController extends AbstractController
{
    /**
     * @Route("/foods", name="food_list")
     * @param FoodRepository $foodRepository
     * @return Response
     */
    public function frontFoodList(FoodRepository $foodRepository, TypeRepository $typeRepository)
    {

        $foods = $foodRepository->findAll();
        $types = $typeRepository->findAll();
        return $this->render('Front/foods.html.twig', [
            'foods' => $foods,
            'types' => $types
        ]);

    }
}