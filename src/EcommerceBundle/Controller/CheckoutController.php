<?php

namespace EcommerceBundle\Controller;

use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use EcommerceBundle\Model\Interfaces\AddressBillableInterface;
use EcommerceBundle\Form\Type\AddressBillableType;
use EcommerceBundle\Model\Interfaces\CartInterface;
use EcommerceBundle\Model\Interfaces\CustomerInterface;
use EcommerceBundle\Model\Interfaces\OrderInterface;

/**
 * Class CheckoutController.
 */
class CheckoutController extends Controller
{
    /**
     * Checkout address step.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function addressAction(Request $request)
    {
        $cart = $this
            ->get('wam_ecommerce.wrapper.cart')
            ->get();

        $address = $cart->getBillingAddress();
        $addressManager = $this->get('wam_ecommerce.address.manager');

        if (is_null($address)) {

            $address = $addressManager->create();

            if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
                $user = $this->getUser();
                $address->setName($user->getFirstName())." ".$address->setSurname($user->getLastName());
                $address->setEmail($user->getEmail());
                $address->setPhone($user->getPhone());
            }
        }

        /*
         * @var Form
         */
        $form = $this->createForm(new AddressBillableType(), $address);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $addressManager->save($address);

            $cart->setBillingAddress($address);

            $cartManager = $this->get('wam_ecommerce.cart.manager');
            $cartManager->save($cart);

            return $this->redirect(
                $this->generateUrl('wam_ecommerce_store_checkout_payment')
            );
        }

        return $this->render(
            'WAMEcommerceBundle:Checkout:address.html.twig',
            array(
                'form' => $form->createView(),
                'cart' => $cart,
            )

        );
    }

    /**
     * Checkout payment step.
     *
     * @param CartInterface $cart Cart
     *
     * @return Response Response
     *
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "wam_ecommerce.wrapper.cart",
     *          "method" = "get",
     *          "static" = false
     *      },
     *      name = "cart"
     * )
     */
    public function paymentAction(CartInterface $cart)
    {

        /*
         * If some address is missing in loaded cart, then we should go back to
         * address screen
         */
        if (!($cart->getBillingAddress() instanceof AddressBillableInterface)) {
            return $this->redirect($this->generateUrl('wam_ecommerce_store_checkout_address'));
        }

        /*
         * Available payment methods
         */
        $paymentMethods = $this
            ->get('wam_ecommerce.wrapper.payment_methods')
            ->get($cart);

        return $this->render(
            'WAMEcommerceBundle:Checkout:payment.html.twig',
            array(
                'cart' => $cart,
                'paymentMethods' => $paymentMethods,
            )
        );
    }

    /**
     * Checkout payment fail action.
     *
     * @param CustomerInterface $customer Customer
     * @param OrderInterface    $order    Order
     *
     * @throws AccessDeniedException Customer cannot see this Order
     *
     * @return array
     *
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "wam_ecommerce.wrapper.customer",
     *          "method" = "get",
     *          "static" = false
     *      },
     *      name = "customer",
     * )
     * @EntityAnnotation(
     *      class = "wam.ecommerce.class.order",
     *      name = "order",
     *      mapping = {
     *          "id" = "~id~",
     *      }
     * )
     */
    public function paymentFailAction(
        CustomerInterface $customer,
        OrderInterface $order
    ) {
        /*
         * Checking if logged user has permission to see
         * this page
         */
        if (!is_null($order->getCustomer()) && $order->getCustomer() != $customer) {
            throw($this->createAccessDeniedException());
        }

        return $this->render(
            'WAMEcommerceBundle:Checkout:payment-fail.html.twig',
            array(
                'order' => $order,
            )
        );
    }
}
