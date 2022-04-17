<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use\App\Entity\Restaurant;
use\App\Entity\Menu;
use App\Repository\RestaurantRepository;
use App\Repository\MenuRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use App\Form\RestaurantType;
use App\Form\MenuType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class MenuController extends AbstractController
{
    /**
     * @Route ("/menu/{id}", name="menu_show")
     */
    public function show_menu(MenuRepository $repo, $id){
        //$repo = $this -> getDoctrine()->getRepository(Restaurant::class);

        $menus = $repo->findBy(array('idRestaurant' => $id));
        return $this->render('menu/menu.html.twig',[
            'controller_name' => 'ProjetController','menus' => $menus
        ]);
    }

    /**
     * @Route ("/menuAll", name="menuAll")
     */
    public function show_menuAll(MenuRepository $repo){
        //$repo = $this -> getDoctrine()->getRepository(Restaurant::class);

        $menus = $repo->findAll();
        return $this->render('menu/menuAll.html.twig',[
            'controller_name' => 'ProjetController','menus' => $menus
        ]);
    }

    /**
     * @Route("/gerant/delete/{id}", name="gerant_delete")
     */
    public function delete_gerant($id){
        $repository = $this->getDoctrine()->getRepository(Menu::class);
        $menu = $repository->find($id);

        $em = $this->getDoctrine()->getManager();
        $em ->remove($menu);
        $em ->flush();

        return $this->redirectToRoute('app_projet_back');
    }

    /**
     * @Route("/gerant/new", name="add_gerant")
     */
    public function add_gerant(Request $request){
        $menu = new menu();

        $form = $this->createForm(MenuType::class, $menu);
        $form->add('Ajout',SubmitType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($menu);
            $manager->flush();

            return $this->redirectToRoute('menuAll', [
                'id' => $menu->getId()
            ]);
        }
        return $this->render('menu/create_menu.html.twig',[
            'controller_name' => 'ProjetController','formResto' => $form->createView()
        ]);
    }

    /**
     * @Route("/gerant/delete/{id}", name="gerant_delete")
     */
    public function delete_menu($id){
        $repository = $this->getDoctrine()->getRepository(Menu::class);
        $menu = $repository->find($id);

        $em = $this->getDoctrine()->getManager();
        $em ->remove($menu);
        $em ->flush();

        return $this->redirectToRoute('menuAll');
    }

    /**
     * @Route("/gerant/update/{id}", name="gerant_update")
     */
    public function update_menu(Request $request, $id){
        $repository = $this->getDoctrine()->getRepository(Menu::class);
        $menu = $repository->find($id);

        $form = $this->createForm(MenuType::class, $menu);
        $form ->add('Upadte', SubmitType::class);
        $form ->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em ->persist($menu);
            $em ->flush();

            return $this->redirectToRoute('menuAll', [
                'controller_name' => 'ProjetController','id' => $menu->getId()
            ]);
        }

        return $this->render('menu/create_menu.html.twig',[
            'controller_name' => 'ProjetController','formResto' => $form->createView()
        ]);
    }

    /**
     * @Route("menu/promotion/{id}" , name="promotion")
     */
    public function promotion(MenuRepository $repo, $id){
        $repository = $this->getDoctrine()->getRepository(Menu::class);
        $menus = $repository->findBy(array('idRestaurant' => $id), array('datePeremption' < "-10 days"));
        return $this->render('menu/menu.html.twig',[
            'controller_name' => 'ProjetController','menus' => $menus
        ]);
    }

    /**
     * @Route("/menu/like/{id}", name="addLikeMenu")
     */
    public function addLike($id){

        $repository = $this->getDoctrine()->getRepository(Menu::class);
        $menu = $repository->find($id);

        $menu->setLikeMenu($menu->getLikeMenu() + 1);

        //if(restaurant->setIdClient != $idClient){
        $manager = $this->getDoctrine()->getManager();
        $manager ->persist($menu);
        $manager->flush();
        //}

        return $this->redirectToRoute('menu_show', [
            'id' => $menu->getIdRestaurant()
        ]);
    }

    /**
     * @Route("/menu/dislike/{id}", name="adddisLikeMenu")
     */
    public function adddisLike($id){

        $repository = $this->getDoctrine()->getRepository(Menu::class);
        $menu = $repository->find($id);

        $menu->setDislikeMenu($menu->getDislikeMenu() + 1);

        $manager = $this->getDoctrine()->getManager();
        $manager ->persist($menu);
        $manager->flush();

        return $this->redirectToRoute('menu_show', [
            'id' => $menu->getIdRestaurant()
        ]);
    }
}
