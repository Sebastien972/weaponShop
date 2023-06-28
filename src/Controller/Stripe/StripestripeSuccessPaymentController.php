<?php

namespace App\Controller\Stripe;

use App\Entity\Order;
use App\Services\CartServices;
use App\Services\OrderServices;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StripestripeSuccessPaymentController extends AbstractController
{


    private $manager;
    private $orderServices;
    private $cartServices;
  public function __construct(EntityManagerInterface $manager, OrderServices $orderServices,CartServices $cartServices)
  {
    $this->manager = $manager;
    $this->orderServices = $orderServices;
    $this->cartServices= $cartServices;
  }

    #[Route('/stripe-success-payment/{stripeCheckoutSessionId}', name: 'app_stripe-success-payment')]
    public function index(?Order $order): Response
    {
        // dd($order);
        if(!$order ||$order->getUser() !== $this->getUser())
        {
            
            return $this->redirectToRoute('app_home');
        }

        if ($order->isIsPaid()=== false) {
            // $stockService->deStock($order);
           $order->setIsPaid(true);
           $this->manager->flush();
        //    dd($order);
        $this->cartServices->removeAllCart();
        }
        
        return $this->render('stripestripe_success_payment/index.html.twig', [
            'order' =>$order,
        ]);
    }
}
