<?php
namespace App\Services;

use App\Repository\ArmamentRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class CartServices{

    private $session;
    private $armamentRepository;

    public function __construct(RequestStack $requestStack, ArmamentRepository $armamentRepository )
    {
        $this->session = $requestStack->getSession();
        $this->armamentRepository = $armamentRepository;
        
        
    }


    public function getCart()
    {
        return $this->session->get('cart',[]);
    }


    public function updateCart($cart)
    {
        // dd($cart);
      
        $this->session->set('cart', $cart);
        $this->session->set('cartData', $this->getFullCart());
    }
    
        
    
    public function add($id)
    {
      
        $cart = $this->getCart();
        if (!empty($cart[$id])) {
            $cart[$id]++;
        }else{
            $cart[$id] = 1 ;
        }
        $this->updateCart($cart);


    }

    public function remove($id)
    {
        $cart = $this->getCart();

        if (isset($cart[$id])) {
            if($cart[$id] > 1){
                $cart[$id]--;
            }else{
                unset($cart[$id]);
            }

        } 
        $this->updateCart($cart);
        
        

       
    }

    public function removeAllItem($id)
    {
        $cart = $this->getCart();

        if (isset($cart[$id])) {
           
            unset($cart[$id]);
            

            $this->updateCart($cart);
        } 
        
        

       
    }

    public function removeAllCart()
    {
        $this->updateCart([]);

    }

    public function getFullCart()
    {
        $cart = $this->getCart();
        $fullCart = [];
        $quantityCart = 0;
        $subTotal = 0;
        foreach ($cart as $id => $quantity) {
            $armament = $this->armamentRepository->find($id);

            if ($armament) {

                $fullCart['fullCart'] []=
                [
                    'quantity' => $quantity,
                    'armament' => $armament,
                ];
                $quantityCart += $quantity;
                $subTotal += $armament->getPrice()* $quantity;
            }else {
                    $this->removeAllCart($id);
            }
        }
        $fullCart['data']=[
            'quantityCart'=> $quantityCart,
            'subTotall' => $subTotal,
        ];
        return $fullCart;
    }



}