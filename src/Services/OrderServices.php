<?php


namespace App\Services;


use App\Entity\Cart;
use App\Entity\CartDetails;
use App\Entity\Order;
use App\Entity\OrderDetails;
use App\Repository\ArmamentRepository;
use Doctrine\ORM\EntityManagerInterface;

class OrderServices
{
    private $manager;
    private $armamentRepository;

    public function __construct(EntityManagerInterface $manager,ArmamentRepository $armamentRepository)
    {
        $this->armamentRepository = $armamentRepository;
        $this->manager = $manager;
    }    
        
    /**
     * getLineItemes
     *
     * @param  mixed $cart
     * @return void
     */
    public function getLineItemes($cart)
    {
        $DetaileCart = $cart->getCartDetails();
        $line_items=[];
        foreach ($DetaileCart as $detail) {
            $armament = $this->armamentRepository->findOneByName($detail->getWeaponName());
  
            $line_items[] = [
              'price_data'=>[
                'currency'=>'EUR',
                'unit_amount'=>$detail->getWeaponPrice(),
                'product_data'=>[
                  'name'=>$detail->getWeaponName(),
                  'images'=>[ $_ENV['YOUR_DOMAIN'].'/assets/img/armament/'.$armament->getImage()],
               ],
              ],
              
            //   'price' => '{{PRICE_ID}}',
              'quantity' => $detail->getQuantity(),
            ];
        }


          return $line_items;
    }
    
    /**
     * creatOrder
     *
     * @param  mixed $cart
     */
    public function creatOrder($cart)
    {
        $order = (new Order)
            ->setCreatedAt($cart->getCreatedAt())
            ->setReference($cart->getReference())
            ->setFullName($cart->getFullName())
            ->setDeliveryAdress($cart->getDeliveryAdress())
            ->setQuantity($cart->getQuantity())
            ->setMoreInformation($cart->getMoreInformation())
            ->setSubTotal($cart->getSubTotal())
            ->setUser($cart->getUser());
        $this->manager->persist($order);

        $armament = $cart->getCartDetails()->getValues();
        foreach ($armament as $cart_produit){
            $orderDetail = (new OrderDetails())
            ->setWeaponName($cart_produit->getWeaponName())
            ->setWeaponPrice($cart_produit->getWeaponPrice())
            ->setQuantity($cart_produit->getQuantity())
            ->setSubTotal($cart_produit->getSubTotal()) 
            ->setOrders($order)
            
            ;
        $this->manager->persist($orderDetail);
        }
        $this->manager->flush();

        return $order;

    }

     
    /**
     * saveCart
     * enregistre les infos en bdd
     * @param  mixed $data représent les donné a enregisté dans l'entité
     * @param  mixed $user l'utilisateur a qui apartien les donne
     * @return void
     */
    public function saveCart($data, $user)
    {

        $reference = $this->generateUuid();
        $adress = $data['checkout']['adresse'];
        $information = $data['checkout']['information'];
        $cart = new Cart();
        $cart->setCreatedAt(new \DateTimeImmutable())
            ->setReference($reference)
            ->setFullName($adress->getFullName())
            ->setDeliveryAdress($adress)
            ->setQuantity($data['data']['quantityCart'])
            ->setMoreInformation($information)
            ->setSubTotal($data['data']['subTotall'])
            ->setUser($user)
        ;
        $cart_detail = [];

        $this->manager->persist($cart);


        $cart_detail = [];
        foreach ($data['fullCart'] as $armament){
            $cartDetail = (new CartDetails())
            ->setWeaponName($armament['armament']->getName())
            ->setWeaponPrice($armament['armament']->getPrice())
            ->setQuantity($armament['quantity'])
            ->setSubTotal($armament['armament']->getPrice()*$armament['quantity']) 
            ->setCarts($cart)
            ;
        $this->manager->persist($cartDetail);
            $cart_detail[] = $cartDetail;
        }


        $this->manager->flush();
        return $reference;
    }

    /**
     * @return string
     * génere un code Uuid
     */
    public function generateUuid(): string
    {
        mt_srand((double)microtime()*10000);

        $charid = strtoupper(md5(uniqid(rand(), true)));
        

        $hyphen = chr(45);
        $uuid = ""
            .substr($charid, 0,8).$hyphen
            .substr($charid, 8,4).$hyphen
            .substr($charid, 12,4).$hyphen
            .substr($charid, 16,4).$hyphen
            .substr($charid, 20,12).$hyphen
        ;
        return $uuid;

    }
}