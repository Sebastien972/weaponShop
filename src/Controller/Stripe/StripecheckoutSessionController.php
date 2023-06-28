<?php

namespace App\Controller\Stripe;

use App\Entity\Cart;
use App\Services\OrderServices;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StripecheckoutSessionController extends AbstractController
{
  private $manager;
  private  $orderServices;
  public function __construct(EntityManagerInterface $manager, OrderServices  $orderServices)
  {
    $this->manager = $manager;
    $this->orderServices = $orderServices;
  }
    #[Route('/Stipecheckout/session{reference}', name: 'app_strype_checkout_session')]
    public function index(Cart $cart): Response
    {
      if (!$cart) {
       return $this->redirectToRoute('app_home');
      }
        Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY'] );

        $user = $this->getUser();
        $order = $this->orderServices->creatOrder($cart); 
        $line_items = $this->orderServices->getLineItemes($cart);
        // dd($cart);
        $checkout_session = Session::create([
          'customer_email' => $user->getEmail(),
            'line_items' => $line_items,
            'mode' => 'payment',
            'success_url' => $_ENV['YOUR_DOMAIN'] . '/stripe-success-payment/{CHECKOUT_SESSION_ID}' ,
            'cancel_url' => $_ENV['YOUR_DOMAIN'] . '/stripe-cancel-payment/{CHECKOUT_SESSION_ID}',
        ]);
        $order->setStripeCheckoutSessionId($checkout_session->id);
        //  dd($checkout_session->id);
        $this->manager->flush();
        return $this->redirect( $checkout_session->url );
    }


       
}
