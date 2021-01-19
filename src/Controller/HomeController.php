<?php

namespace App\Controller;

use App\Repository\AgencyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{

    /**
     * @Route("/", name="app_home")
     */
    public function home(): Response
    {


        return $this->render('home/index.html.twig');
    }


    /**
     * @Route("/map/mapinfo", name="app_map")
     */
    public function map(AgencyRepository $agencyRepository, EntityManagerInterface $em): Response
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");

        $agencies = $agencyRepository->findAll();

        $datas = [];

        foreach ($agencies as $key =>$agency){
            $datas[$key]['id'] = $agency->getId();
            $datas[$key]['city'] = $agency->getCity();
            $datas[$key]['lat'] = $agency->getLat();
            $datas[$key]['lon'] = $agency->getLon();
            $datas[$key]['number'] = $agency->getNumber();
            $datas[$key]['mail'] = $agency->getMail();
            $datas[$key]['address'] = $agency->getAddress();
            $datas[$key]['comment'] = $agency->getComment();
        }

        return new JsonResponse (['agences' => $datas]);
    }
}