<?php

namespace App\Controller;

use App\Entity\Product;
use App\Service\OrdersService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    /**
     * @Route("/order/add-to-cart/{id}", name="order_add_to_cart")
     */
    public function addToCart(Product $product, OrdersService $ordersService, Request $request)
    {
        $ordersService->addToCart($product);

        //надо бросить пользователя туда где он тыклнул эту кнопку

        //береm ссылку на которой он был до этого, ссылкой типа
        $referer = $request->headers->get('Referer');
        //и кидаем его жа ну страницу
        return $this->redirect($referer);
    }
}