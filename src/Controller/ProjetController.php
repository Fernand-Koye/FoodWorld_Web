<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use\App\Entity\Restaurant;
use\App\Entity\Menu;
use\App\Entity\Commentaire;
use App\Repository\RestaurantRepository;
use App\Repository\MenuRepository;
use App\Repository\CommentaireRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use App\Form\RestaurantType;
use App\Form\CommentaireType;
use App\Form\MenuType;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ProjetController extends AbstractController
{

    /////////////////////////////////////////////////////////////// FRONT ////////////////////////////////////////////////

    /**
     * @Route("/", name="home")
     */
    public function home(){
        return $this->render('restaurant/home.html.twig');
    }

    /////////////////////////////////////////////////////////////// RESTAURANT ////////////////////////////////////////////////

    /**
     * @Route("/restaurant", name="app_projet")
     */
    public function index(RestaurantRepository $repo): Response
    {
        //$repo = $this->getDoctrine()->getRepository(Restaurant::class);

        $restaurants = $repo->findAll();

        return $this->render('restaurant/index.html.twig', [
            'controller_name' => 'ProjetController','restaurants' => $restaurants
        ]);
    }

    /**
     * @Route("/restaurant/new", name="add")
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
        return $this->render('restaurant/create.html.twig',[
            'controller_name' => 'ProjetController','formRestaurant' => $form->createView()
        ]);
    }

    /**
     * @Route ("/restaurant/{id}", name="projet_show")
     */
    public function show(Request $request, RestaurantRepository $repo, CommentaireRepository $repoCommentaire, $id){
        //$repo = $this -> getDoctrine()->getRepository(Restaurant::class);

        $commentaire = new commentaire();

        $comment = $repoCommentaire->findBy(array('idRestaurant' => $id));

        $restaurant = $repo->find($id);

        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->add('Commenter',SubmitType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $commentaire->setIdRestaurant($restaurant);
            $em = $this->getDoctrine()->getManager();
            $em ->persist($commentaire);
            $em ->flush();

            return $this->redirectToRoute('projet_show', [
                'controller_name' => 'ProjetController','id' => $restaurant->getId()
            ]);
        }
        return $this->render('restaurant/show.html.twig',[
            'controller_name' => 'ProjetController','restaurant' => $restaurant,'formCommentaire' => $form->createView(),
            'commentaire' => $comment
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

        return $this->render('restaurant/create.html.twig',[
            'controller_name' => 'ProjetController','formRestaurant' => $form->createView()
        ]);
    }

    /**
     * @Route("/restaurant/delete/{id}", name="projet_delete")
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

    /**
     * @Route("/back/affiche", name="app_projet_back")
     */
    public function indexback(RestaurantRepository $repo): Response
    {
        //$repo = $this->getDoctrine()->getRepository(Restaurant::class);

        $restaurants = $repo->findAll();

        return $this->render('restaurant/indexback.html.twig', [
            'controller_name' => 'ProjetController','restaurants' => $restaurants
        ]);
    }

    /**
     * @Route ("/back/{id}", name="show_back")
     */
    public function show_index(RestaurantRepository $repo, $id){
        //$repo = $this -> getDoctrine()->getRepository(Restaurant::class);

        $restaurant = $repo->find($id);
        return $this->render('restaurant/show_back.html.twig',[
            'controller_name' => 'ProjetController','restaurant' => $restaurant
        ]);
    }

    ///////////////////////////////////////////////////////////////GERANT RESTAURANT////////////////////////////////////////////////

    /**
     * @Route("/gerant", name="gerant")
     */
    public function gerant(){
        return $this->render('gerant.html.twig');
    }

    /////////////////////////////////////////////////////////////// BACK  ////////////////////////////////////////////////

    /**
     * @Route("/back", name="back")
     */
    public function back(){
        return $this->render('back.html.twig');
    }

    /**
     * @Route("/restaurant/like/{id}", name="addLike")
     */
    public function addLike($id){

        $repository = $this->getDoctrine()->getRepository(Restaurant::class);
        $restaurant = $repository->find($id);

        $restaurant->setLikeRestaurant($restaurant->getLikeRestaurant() + 1);

        //if(restaurant->setIdClient != $idClient){
        $manager = $this->getDoctrine()->getManager();
        $manager ->persist($restaurant);
        $manager->flush();
        //}

        return $this->redirectToRoute('projet_show', [
            'id' => $restaurant->getId()
        ]);
    }

    /**
     * @Route("/restaurant/dislike/{id}", name="adddisLike")
     */
    public function adddisLike($id){

        $repository = $this->getDoctrine()->getRepository(Restaurant::class);
        $restaurant = $repository->find($id);

        $restaurant->setDislikeRestaurant($restaurant->getDislikeRestaurant() + 1);

        $manager = $this->getDoctrine()->getManager();
        $manager ->persist($restaurant);
        $manager->flush();

        return $this->redirectToRoute('projet_show', [
            'id' => $restaurant->getId()
        ]);
    }

    /**
     * @Route("/stats", name="stats")
     */
    public function statistiques(RestaurantRepository $repo){

        $restaurants = $repo->findAll();
        $nom = [];
        $likeRestaurant = [];
        $dislikeRestaurant = [];

        foreach($restaurants as $restaurant){
            $nom[] = $restaurant->getNom();
            $likeRestaurant[] = $restaurant->getLikeRestaurant();
            $dislikeRestaurant[] = $restaurant->getDislikeRestaurant();
        }
        return $this->render('restaurant/stats.html.twig',[
            'nom' => json_encode($nom), 'likeRestaurant' => json_encode($likeRestaurant),
            'dislikeRestaurant' => json_encode($dislikeRestaurant)
        ]);
    }
    
}