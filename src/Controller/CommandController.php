<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Command;
use App\Entity\Plat;
use App\Entity\Panier   ;

use Symfony\Component\HttpFoundation\Request;
use App\Form\CommandType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;



class CommandController extends AbstractController
{
    /**
     * @Route("/command","/", name="app_command")
     */
    public function index(): Response
    {
        $tab = $this->getDoctrine()
            ->getRepository(Command::class)
            ->findAll();

        return $this->render('command/index.html.twig', [
            'tab' => $tab,
        ]);
    }
    /**
     * @Route("/plat", name="app_plat")
     */
    public function plat(): Response
    {
        $tab = $this->getDoctrine()
            ->getRepository(Plat::class)
            ->findAll();

        return $this->render('command/plat.html.twig', [
            'tab' => $tab,
        ]);
    }
    /**
     * @Route("/plat/add", name="platAdd")
     */
    public function platNew(): Response
    {
        $tab = $this->getDoctrine()
            ->getRepository(Plat::class)
            ->findAll();

        return $this->render('command/plat.html.twig', [
            'tab' => $tab,
        ]);
    }

    /**
     *  @Route("/command/newcommand", name="newcommand")
     */
    public function newCommand(Request $request): Response
    {
        $command = new Command();

        $form = $this->createForm(CommandType::class, $command);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($command);
            $em->flush();

            return $this->redirectToRoute('app_command');
        }

        return $this->render('command/newCommand.html.twig', [
            'CommandForm' => $form->createView(),
        ]);
    }
    /**
     *  @Route("/newcommand/{id}", name="AddToCommand")
     */
    public function AjoutCommand($id, Request $request): Response
    {
        $command = new Command();

        $repository = $this->getDoctrine()->getRepository(Plat::class);
        $plat = $repository->find($id);

        $command->setIdUser(0);
        $command->setConfirmed(0);
        $command->setPlat($plat);
        $command->setPrix($plat->getPrix());
        $command->setDescription($plat->getDescription());

        $em = $this->getDoctrine()->getManager();

        
        
        $repository = $this->getDoctrine()->getRepository(Panier::class);
        $panier = $repository->findOneBy(['idUser' => 0]);
        $panier->addCommand($command);
        
        $em->persist($command);
        $em->flush();

        
        return $this->redirectToRoute('app_command');
    }

    /**
     * @Route ("/command/delete/{id}",name="commandDelete")
     */
    public function commandDelete($id)
    {
        $repository = $this->getDoctrine()->getRepository(Command::class);

        $command = $repository->find($id);
        $em = $this->getDoctrine()->getManager();

        $em->remove($command);
        $em->flush();
        return $this->redirectToRoute('app_command');
    }
}
