<?php

namespace App\Controller\Cart;

use App\Services\CartServices;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function index(SessionInterface $sesssion): Response
    {

        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
        ]);
    }
   
    
    #[Route('/add/{id}', name: 'add')]    
    /**
     * panier
     *
     * @param  mixed $id
     * @param  mixed $cartServices
     * @return void
     */
    public function panier($id, CartServices $cartServices)
    {

        
        $cartServices->add($id);
// dd($id);

        // return $this->redirectToRoute('app_home');

            return new JsonResponse([
                'content' => $this->renderView('_cart.html.twig'),
                'cart' => $this->renderView('cart/_Cart.html.twig')
            ]);




    }



    /**
     * @Route("/deletcart/", name="deletcart")
     */
    public function deletPanier( CartServices $cartServices)
    {

        
        $cartServices->removeAllCart();
        return new JsonResponse([
            'content' => $this->renderView('_cart.html.twig'),
            'cart' => $this->renderView('cart/_Cart.html.twig')
        ]);

        // return $this->redirectToRoute('app_home');


    }
    /**
     * @Route("/removeItem/{id}", name="delet", requirements={"id"="\d+"})
     */
    public function removpanier($id, CartServices $cartServices)
    {

        $cartServices->removeAllItem($id);

       
        return new JsonResponse([
            'content' => $this->renderView('_cart.html.twig'),
            'cart' => $this->renderView('cart/_Cart.html.twig')
        ]);


    }



    /**
     * @Route("/remove/{id}", name="remove", requirements={"id"="\d+"})
     */
    public function remove($id, CartServices $cartServices)
    {

        $cartServices->remove($id);

       
        return new JsonResponse([
            'content' => $this->renderView('_cart.html.twig'),
            'cart' => $this->renderView('cart/_Cart.html.twig')
        ]);


    }
}
