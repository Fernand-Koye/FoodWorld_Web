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

class ProjetController extends AbstractController
{
    /**
     * @Route("/projet", name="app_projet")
     */
    public function index(RestaurantRepository $repo): Response
    {
        //$repo = $this->getDoctrine()->getRepository(Restaurant::class);

        $restaurants = $repo->findAll();

        return $this->render('projet/index.html.twig', [
            'controller_name' => 'ProjetController','restaurants' => $restaurants
        ]);
    }

    /**
     * @Route("/back/affiche", name="app_projet_back")
     */
    public function indexback(RestaurantRepository $repo): Response
    {
        //$repo = $this->getDoctrine()->getRepository(Restaurant::class);

        $restaurants = $repo->findAll();

        return $this->render('indexback.html.twig', [
            'controller_name' => 'ProjetController','restaurants' => $restaurants
        ]);
    }

    /**
     * @Route("/", name="home")
     */
    public function home(){
        return $this->render('projet/home.html.twig');
    }

    /**
     * @Route("/back", name="back")
     */
    public function back(){
        return $this->render('/back.html.twig');
    }

     /**
     * @Route("/gerant", name="gerant")
     */
    public function gerant(){
        return $this->render('/gerant.html.twig');
    }

    /**
     * @Route("/projet/new", name="add")
     */
    public function add(Request $request){
        $restaurant = new restaurant();

        $form = $this->createForm(RestaurantType::class, $restaurant);
        $form->add('Ajout',SubmitType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($restaurant);
            $manager->flush();

            return $this->redirectToRoute('back', [
                'id' => $restaurant->getId()
            ]);
        }
        return $this->render('projet/create.html.twig',[
            'controller_name' => 'ProjetController','formRestaurant' => $form->createView()
        ]);
    }

    /**
     * @Route ("/projet/{id}", name="projet_show")
     */
    public function show(RestaurantRepository $repo, $id){
        //$repo = $this -> getDoctrine()->getRepository(Restaurant::class);

        $restaurant = $repo->find($id);
        return $this->render('projet/show.html.twig',[
            'controller_name' => 'ProjetController','restaurant' => $restaurant
        ]);
    }

    /**
     * @Route ("/menu/{id}", name="menu_show")
     */
    public function show_menu(MenuRepository $repo, $id){
        //$repo = $this -> getDoctrine()->getRepository(Restaurant::class);

        $menus = $repo->findBy(array('idRestaurant' => $id));
        return $this->render('projet/menu.html.twig',[
            'controller_name' => 'ProjetController','menus' => $menus
        ]);
    }

    /**
     * @Route ("/back/{id}", name="show_back")
     */
    public function show_index(RestaurantRepository $repo, $id){
        //$repo = $this -> getDoctrine()->getRepository(Restaurant::class);

        $restaurant = $repo->find($id);
        return $this->render('show_back.html.twig',[
            'controller_name' => 'ProjetController','restaurant' => $restaurant
        ]);
    }

    /**
     * @Route("/back/update/{id}", name="back_update")
     */
    public function update(Request $request, $id){
        $repository = $this->getDoctrine()->getRepository(Restaurant::class);
        $restaurant = $repository->find($id);

        $form = $this->createForm(RestaurantType::class, $restaurant);
        $form ->add('Upadte', SubmitType::class);
        $form ->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em ->persist($restaurant);
            $em ->flush();

            return $this->redirectToRoute('back', [
                'controller_name' => 'ProjetController','id' => $restaurant->getId()
            ]);
        }

        return $this->render('projet/create.html.twig',[
            'controller_name' => 'ProjetController','formRestaurant' => $form->createView()
        ]);
    }

    
    /**
     * @Route("/projet/delete/{id}", name="projet_delete")
     */
    public function delete($id){
        $repository = $this->getDoctrine()->getRepository(Restaurant::class);
        $restaurant = $repository->find($id);

        $em = $this->getDoctrine()->getManager();
        $em ->remove($restaurant);
        $em ->flush();

        return $this->redirectToRoute('app_projet');
    }

    /**
     * @Route("/back/delete/{id}", name="back_delete")
     */
    public function delete_back($id){
        $repository = $this->getDoctrine()->getRepository(Restaurant::class);
        $restaurant = $repository->find($id);

        $em = $this->getDoctrine()->getManager();
        $em ->remove($restaurant);
        $em ->flush();

        return $this->redirectToRoute('app_projet_back');
    }

    ///////////////////////////////////////////////////////////////GERANT RESTAURANT////////////////////////////////////////////////
    /**
     * @Route ("/menuAll", name="menuAll")
     */
    public function show_menuAll(MenuRepository $repo){
        //$repo = $this -> getDoctrine()->getRepository(Restaurant::class);

        $menus = $repo->findAll();
        return $this->render('menuAll.html.twig',[
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
        return $this->render('create_menu.html.twig',[
            'controller_name' => 'ProjetController','formResto' => $form->createView()
        ]);
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

        return $this->render('create_menu.html.twig',[
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
}