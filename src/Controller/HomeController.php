<?php

namespace App\Controller;

use App\Entity\Armament;
use App\Entity\Categorie;
use App\Form\AddtoCartType;
use App\Repository\ArmamentRepository;
use App\Repository\CategorieRepository;
use App\Service\CartServices as ServiceCartServices;
use App\Services\CartServices;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ArmamentRepository $repoArmament, CategorieRepository $categorieRepository, Request $request): Response
    {

        $filters = $request->get('categorie');
        
        $armamentPopular = $repoArmament->findByMostPopular(1);
        $categorie = $categorieRepository->findAll();

        return $this->render('home/index.html.twig', [
            'armamentPopular' => $armamentPopular,
            'categorie' => $categorie,
            'filters' => $filters
        ]);
    }
    




    /**
     * @Route("/show/{slug}", name="armament")
     */
    public function show(?Armament $armament, Request $request, CartServices $cartServices):Response
    {
        if (!$armament) {
            return $this->redirectToRoute("app_home");
        }

        $form = $this->createForm(AddtoCartType::class);
        $form->handleRequest($request);

       

        return $this->render('home/armament.html.twig', [
            'armes'=>$armament,

        ]);
        
    }


}