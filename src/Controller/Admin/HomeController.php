<?php


namespace App\Controller\Admin;

// pour pouvoir utiliser cette classe dans mon code
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

class HomeController extends AbstractController
{
    /**
     *@Route("/admin/home", name="admin_home")
     */
    public function home(){
        return $this->render('Admin/home.html.twig');
    }

    /**
     * @Route("/admin/foodlist", name="admin_foodList")
     * @param FoodRepository $foodRepository
     * @return Response
     */
    public function foodList(FoodRepository $foodRepository, TypeRepository $typeRepository){

        $foods = $foodRepository->findAll();
        $types = $typeRepository->findAll();
        return $this->render('Admin/foods.html.twig',[
            'foods' => $foods,
            'types' =>$types
        ]);

    }



}