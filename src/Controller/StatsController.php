<?php

namespace App\Controller;

// use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;

use App\Entity\Command;
use App\Entity\Plat;
use symfony\ux\chartjs\Builder\ChartBuilderInterface;
use symfony\ux\chartjs\Model\Chart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatsController extends AbstractController
{

    /**
     * @Route("/stat", name="app_stat")
     */
    public function index(): Response
    {
        $tabp = $this->getDoctrine()
            ->getRepository(Plat::class)
            ->findAll();

        $tabc = $this->getDoctrine()
            ->getRepository(Command::class)
            ->findAll();

        foreach ($tabp as $o) {
            // $o->get
        }
        

        return $this->render('stat/index.html.twig', [
            'tab' => 's',
        ]);
    }

    
}
