<?php

namespace App\Controller\Cart;

use App\Form\CheckoutType;
use App\Services\CartServices;
use App\Services\OrderServices;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CheckoutController extends AbstractController
{
    private $cartServices;
    private $session;

    public function __construct(CartServices $cartServices, RequestStack $requestStack)
    {
        $this->cartServices = $cartServices;
        $this->session = $requestStack->getSession();
    }

    #[Route('/checkout', name: 'app_checkout')]
    public function index(Request $request): Response
    {
        $cart = $this->cartServices->getFullCart();
        $user = $this->getUser();

        if (empty($cart['fullCart'])) {
            return $this->redirectToRoute('app_home');
        }
        if ($user == null) {
            $this->addFlash('checkout_message', 'vous devez vous connecter a pour continuer');



            return $this->redirectToRoute('app_login');
        }

        if (empty($user->getAdresses()->getValues())) {
            $this->addFlash('checkout_message', 'vous devez ajouter une adresse pour continuer');
            return $this->redirectToRoute('app_adress_new');

        }

        if($this->session->get('checkout_data')) {
            return $this->redirectToRoute('app_checkout_confirm');

        }



        $form = $this->createForm(CheckoutType::class, null, ['user' => $user]);




        return $this->render('checkout/index.html.twig', [
            'cart' => $cart,
            'form'=> $form->createView(),
        ]);
    }


    #[Route('/checkout/confirm', name: 'app_checkout_confirm')]
    public function checkConfirm(Request $request, OrderServices $orderServices)
    {
        $user = $this->getUser();

        $cart = $this->cartServices->getFullCart();

        if (empty($cart)) {
            return $this->redirectToRoute('home');
        }
        if ($user == null) {
            $this->addFlash('checkout_message', 'vous devez vous connecter a pour continuer');

            return $this->redirectToRoute('app_login');
        }
        if (empty($user->getAdresses()->getValues())) {
            $this->addFlash('checkout_message', 'vous devez ajouter une adresse pour continuer');
            return $this->redirectToRoute('adresse_new');

        }


        $form = $this->createForm(CheckoutType::class, null, ['user' => $user]);
        // dd($cart);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() || $this->session->get('checkout_data')) {
            if ($this->session->get('checkout_data')) {
                $data = $this->session->get('checkout_data');
            } else {
                $data = $form->getData();
                $this->session->set('checkout_data', $data);
            }

            $adresse = $data['adresse'];
            $info = $data['information'];
            $cart['checkout'] = $data;
            $ref = $orderServices->saveCart($cart, $user);
            // dd($ref);

            return $this->render('checkout/confirm.html.twig', [
                'cart' => $cart,
                'adresse'=>$adresse,
                'info'=>$info,
                'form'=> $form->createView(),
                'ref'=>$ref,

            ]);
        }
        return $this->redirectToRoute('app_checkout');
    }

    #[Route('/checkout/edit', name: 'app_checkout_edit')]
    public function checkoutEdit()
    {
        $this->session->set('checkout_data',[]);
       return $this->redirectToRoute('app_checkout');
    }
}
