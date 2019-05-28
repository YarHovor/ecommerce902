<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Product;
use App\Form\OrderType;
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

        if ($request->isXmlHttpRequest()) {
            return $this->headerCart($ordersService);
        }

        //надо бросить пользователя туда где он тыклнул эту кнопку

        //береm ссылку на которой он был до этого, ссылкой типа
        $referer = $request->headers->get('Referer');
        //и кидаем его жа ну страницу
        return $this->redirect($referer);
    }

    /**
     * @Route("/cart", name="order_cart")
     */
    public function cart(OrdersService $ordersService)
    {
        return $this->render('order/cart.html.twig', [
            'order' => $ordersService->getOrderFromCart(),
        ]);
    }

    public function headerCart(OrdersService $ordersService)
    {
        return $this->render('order/headerCart.html.twig', [
            'order' => $ordersService->getOrderFromCart(),
        ]);
    }

    /**
     * @Route("/cart/update-count/{id}", name="order_update_count")
     */
    public function updateCount(OrderItem $orderItem, OrdersService $ordersService, Request $request)
    {
        // совпадает ли текущая корзина с текущим пользователем с заказом ордерИтем
        $order = $ordersService->getOrderFromCart();  // сервис для проверки
        if ($orderItem->getOrder() !== $order) {   // берем текущую корзину, и если ордерИтем не= текущей корзине
            return $this->createAccessDeniedException('Invalid order item'); // то
        }
        // а если хорошо надо обновить к-во и отдать ту же самую табличку
        $count = $request->request->getInt('count');  // к-во передаем
        $ordersService->setCount($orderItem, $count); // используем метод
        return $this->render('order/cartTable.html.twig', [ // ответ - отрисование таблицы в отдельный шаблон
            'order' => $order,   //
        ]);
    }

    /**
     * @Route("/cart/delete-item/{id}", name="order_delete_item")
     */
    public function deleteItem(OrderItem $orderItem, OrdersService $ordersService, Request $request)
    {
        // zachita ot xakera
        $order = $ordersService->getOrderFromCart();  // сервис для проверки
        if ($orderItem->getOrder() !== $order) {   // берем текущую корзину, и если ордерИтем не= текущей корзине
            return $this->createAccessDeniedException('Invalid order item'); // то
        }

        $ordersService->deleteItem($orderItem);

        if ($request->isXmlHttpRequest()) {
            return $this->render('order/cartTable.html.twig', [
                'order' => $order,
            ]);
        }

        return $this->redirectToRoute('order_cart');
    }


    /**
     * @Route("/order/make", name="order_make_order")
     */
    public function makeOrder(OrdersService $ordersService, Request $form)
    {
        $order = $ordersService->getOrderFromCart();
        $form = $this->createForm(OrderType::class, $order);


        return $this->render('order/makeOrder.html.twig', [
            'order' => $order,
            'form' => $form,

        ]);
    }
}