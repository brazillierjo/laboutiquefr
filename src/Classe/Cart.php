<?php

namespace App\Classe;

use Symfony\Component\HttpFoundation\RequestStack;

class Cart
{
    private $stack;

    public function __construct(RequestStack $stack)

    {
        return $this->stack = $stack;
    }

    public function add($id)
    {
        $session = $this->stack->getSession();
        $cart = $session->get('cart', []);

        if (!empty($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }

        $session->set('cart', $cart);
    }

    public function deleteOne($id)
    {
        $session = $this->stack->getSession();
        $cart = $session->get('cart', []);

        if (!empty($cart[$id])) {
            $cart[$id]--;
            if ($cart[$id] <= 0) {
                unset($cart[$id]);
            }
        }

        $session->set('cart', $cart);
    }

    public function get()
    {
        $methodget = $this->stack->getSession();
        return $methodget->get('cart');
    }

    public function remove()
    {
        $methodremove = $this->stack->getSession();
        return $methodremove->remove('cart');
    }

    public function delete($id)
    {
        $methoddelete = $this->stack->getSession();
        $cart = $methoddelete->get('cart');
        unset($cart[$id]);
        $methoddelete->set('cart', $cart);

        return $methoddelete;
    }
}
