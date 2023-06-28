<?php

namespace App\Controller\Shop;

use App\Entity\Caliber;
use App\Repository\ArmamentRepository;
use App\Repository\CaliberRepository;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShopController extends AbstractController
{
    #[Route('/shop', name: 'app_shop')]
    public function index(Request $request, ArmamentRepository $armamentRepository, CategorieRepository $categorieRepository, CaliberRepository $caliberRepository): Response
    {
        $limit = 6;
        $page = (int)$request->query->get('page', 1);
        $filters = $request->get('categorie');
        $maxPrice = $request->get('maxPrice');
        $minPrice = $request->get('minPrice');
        $caliber = $request->get('caliber');
        // dd($filters);
        $sort = $request->get('sort');
        // dd($sort);
        $search = $request->get('search');
        $categorie = $categorieRepository->getCategorie();
        
        // dd($categorie);

        $armament = $armamentRepository->getPaginatedArmament($page, $limit, $filters, $search, $sort, $maxPrice, $minPrice, $caliber);
        // dd($armament);
        $total = $armamentRepository->getTotalProduit($filters, $search, $sort, $maxPrice, $minPrice, $caliber);
        $priceMax = $armamentRepository->getMaxPrice();

        if ($request->get('ajax')){
            return new JsonResponse([
                'content' => $this->renderView('shop/_shop.html.twig',
                [
                'armament' => $armament,
                'total' => $total,
                'page' => $page,
                'limit' => $limit,
                'categorie' => $categorie,
                'priceMax' => $priceMax,

                

                ]
                )]);

            

        }

        return $this->render('shop/index.html.twig', [
            'armament' => $armament,
            'total' => $total,
            'page' => $page,
            'limit' => $limit,
            'categorie' => $categorie,
            'priceMax' => $priceMax,
            





        ]);
    }


    

    
}

