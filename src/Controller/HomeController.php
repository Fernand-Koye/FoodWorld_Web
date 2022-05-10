<?php

namespace App\Controller;

use App\Repository\ReservationRepository;
use App\Repository\EvenementRepository; 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="app_home")
     */
    public function index(EvenementRepository $ev): Response
    { return $this->render('home/index.html.twig', [
        'evenements'=> $ev->findAll(),
     
    ]);
    }
}
