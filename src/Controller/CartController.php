<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/mon-panier', name: 'app_cart')]
    public function index(Cart $cart, EntityManagerInterface $entityManager)
    {
        $cartCompete = [];

        if ($cart->get() != null) {
            foreach ($cart->get() as $id => $quantity) {
                $productObject = $entityManager->getRepository(Product::class)->find($id);
                if (!$productObject) {
                    $cart->delete($id);
                    continue;
                }
                $cartCompete[] = [
                    'product' => $productObject,
                    'quantity' => $quantity
                ];
            }
        }

        return $this->render('cart/index.html.twig', [
            'cart' => $cartCompete,
        ]);
    }

    #[Route('/cart/add/{id}', name: 'app_add_to_cart')]
    public function add(Cart $cart, $id)
    {
        $cart->add($id);

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/deleteOne/{id}', name: 'app_deleteOne_to_cart')]
    public function deleteOne(Cart $cart, $id)
    {
        $cart->deleteOne($id);

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/remove', name: 'app_remove_my_cart')]
    public function remove(Cart $cart)
    {
        $cart->remove();

        return $this->redirectToRoute('app_home');
    }

    #[Route('/cart/delete/{id}', name: 'app_deleteOne_my_cart')]
    public function delete(Cart $cart, $id)
    {
        $cart->delete($id);

        return $this->redirectToRoute('app_cart');
    }
}
