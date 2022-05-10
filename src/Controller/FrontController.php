<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Plat;
use App\Entity\Panier;
use App\Entity\Command;
use App\Repository\PlatRepository;
use SebastianBergmann\Environment\Console;
/**
 * @Route("/frontt")
 */
class FrontController extends AbstractController
{
    /**
     * @Route("/", name="app_front")
     */
    public function index(PlatRepository $pr): Response
    {
        $tab = $pr->triparlike();
        //$this->getDoctrine()
        //->getRepository(Plat::class)

        return $this->render('front/index.html.twig', [
            'tab' => $tab,
        ]);
    }

    /**
     *  @Route("/newplat/{id}", name="AddPlatToPanier")
     */
    public function AjoutPlat($id, Request $request): Response
    {
        $command = new Command();

        $repository = $this->getDoctrine()->getRepository(Plat::class);
        $plat = $repository->find($id);

        $command->setIdUser(0);
        $command->setPlat($plat);
        $command->setPrix($plat->getPrix());
        $command->setDescription($plat->getDescription());
        $command->setConfirmed(0);

        $em = $this->getDoctrine()->getManager();



        $repository = $this->getDoctrine()->getRepository(Panier::class);
        $panier = $repository->findOneBy(['idUser' => 0]);
        $panier->addCommand($command);

        $em->persist($command);
        $em->flush();
        return $this->redirectToRoute('front_panier', ['id' => 0]);
    }
    /**
     *  @Route("/remove/{id}", name="removePlatPanier")
     */
    public function RemovePlat($id, Request $request): Response
    {
        $command = new Command();

        $repository = $this->getDoctrine()->getRepository(Command::class);
        $command = $repository->find($id);

        $em = $this->getDoctrine()->getManager();



        $repository = $this->getDoctrine()->getRepository(Panier::class);
        $panier = $repository->findOneBy(['idUser' => 0]);
        $panier->removeCommand($command);

        $em->persist($panier);
        $em->remove($command);
        $em->flush();
        return $this->redirectToRoute('front_panier', ['id' => 0]);
    }
    /**
     * @Route("/panier/{id}", name="front_panier")
     */
    public function panier($id): Response
    {

        $repository = $this->getDoctrine()->getRepository(Panier::class);
        $panier = $repository->findOneBy(['idUser' => $id]);

        $tab = $panier->getCommands()->toArray();

        $total = 0;
        foreach ($tab as $value) {
            $total += $value->getPrix();
        }
        return $this->render('front/panier.html.twig', [
            'tab' => $tab,
            'total' => $total,
        ]);
    }
    /**
     * @Route("/confirmer/{id}", name="front_confirmer")
     */
    public function confirmer($id): Response
    {

        $repository = $this->getDoctrine()->getRepository(Panier::class);
        $panier = $repository->findOneBy(['idUser' => $id]);

        $tab = $panier->getCommands()->toArray();

        $em = $this->getDoctrine()->getManager();
        foreach ($tab as $value) {

            $panier->removeCommand($value);
            $value->setConfirmed(1);
            $em->persist($value);
            $em->flush();
        }
        $em->persist($panier);
        $em->flush();
        return $this->redirectToRoute('app_front');
    }
    
    
    /**
     * @Route("/jaime/{id}", name="front_jaime")
     */
    public function jaime($id): Response
    {

        $repository = $this->getDoctrine()->getRepository(Plat::class);
        $plat = $repository->find($id);

        $plat->setJaime($plat->getJaime()+1); 

        $em = $this->getDoctrine()->getManager();
        $em->persist($plat);
        $em->flush();
        return $this->redirectToRoute('app_front');
    }
}
