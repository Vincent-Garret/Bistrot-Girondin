<?php


namespace App\Controller\Admin;


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
}