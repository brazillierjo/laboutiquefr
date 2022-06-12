<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Order;
use App\Form\OrderType;
use App\Repository\ProductRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    #[Route('/commande', name: 'app_order')]
    public function index(Cart $cart, ProductRepository $productRepository, Request $request): Response
    {
        if (!$this->getUser()->getAddresses()->getValues()) {
            return $this->redirectToRoute('app_account_new_address');
        }

        $form = $this->createForm(OrderType::class, null, [
            'user' => $this->getUser(),
        ]);

        return $this->render('order/index.html.twig', [
            'form' => $form->createView(),
            'cart' => $cart->getFull($productRepository)
        ]);
    }

    #[Route('/recapitulatif', name: 'app_order_recap')]
    public function add(Cart $cart, ProductRepository $productRepository, Request $request): Response
    {
        $form = $this->createForm(OrderType::class, null, [
            'user' => $this->getUser(),
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $date = new DateTime();
            $carriers = $form->get('carriers')->getData();
            $delivery = $form->get('addresses')->getData();

            $delivery_content = $delivery->getFirstName();
            $delivery_content .= '</br>' . $delivery->getLastName();
            if ($delivery->getCompany()) {
                $delivery_content .= '</br>' . $delivery->getCompany();
            }
            $delivery_content .= '</br>' . $delivery->getAddress();
            $delivery_content .= '</br>' . $delivery->getPostal();
            $delivery_content .= '</br>' . $delivery->getCity();
            $delivery_content .= '</br>' . $delivery->getCountry();
            dd($delivery_content);

            $order = new Order();
            $order->setUser($this->getUser());
            $order->setCreatedAt($date);
            $order->setCarrierName($carriers->getName());
            $order->setCarrierPrice($carriers->getPrice());


        }

        return $this->render('order/recap.html.twig', [
            'cart' => $cart->getFull($productRepository)
        ]);
    }
}
