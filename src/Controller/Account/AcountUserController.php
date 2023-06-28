<?php

namespace App\Controller\Account;

use App\Entity\Adress;
use App\Entity\Order;
use App\Form\ChangePasswordFormType;
use App\Form\InfosUserType;
use App\Repository\AdressRepository;
use App\Repository\OrderRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class AcountUserController extends AbstractController
{
    #[Route('/acount', name: 'app_acount_user')]
    public function index(Request $request,
        UserPasswordHasherInterface $passwordHasher, 
        UserInterface $user, 
        UserRepository $userRepository, 
        AdressRepository $adressRepository,
        OrderRepository $orderRepository): Response
    {
        $order = $orderRepository->findBy(['isPaid' => true, 'user' => $this->getUser()],['id' => 'DESC']);
        // dd($order);
        $formResetPass = $this->createForm(ChangePasswordFormType::class);
        $formResetPass->handleRequest($request);
        $adresse = $adressRepository->findAll();

        if ($formResetPass->isSubmitted() && $formResetPass->isValid()) {

            $hashedPassword = $passwordHasher->hashPassword(
                    $user,
                    $formResetPass->get('plainPassword')->getData()
            );
            $userRepository->upgradePassword($user, $hashedPassword);
            
            // return $this->redi  rectToRoute('app_home');
        }



        return $this->render('account_user/index.html.twig', [
            'controller_name' => 'AcountUserController',
            'resetFormResetPass' => $formResetPass->createView(),
            'adresse' => $adresse,
            'order' => $order
			
        ]);
    }

    #[Route('/acount/order{id}', name: 'app_acount_user_order')]
    public function order(?Order $order)
    {
        if (!$order->isIspaid() !== $order->getUser() || !$order->isIsPaid()) {
            return $this->redirectToRoute('app_home');
        } 
        if (!$order->isIsPaid()) {
            return $this->redirectToRoute('app_acount_user');
        }
        // dd($Order);
        return $this->render('account_user/order.html.twig' , [
            'order'=> $order,
        ]);
    }
}
