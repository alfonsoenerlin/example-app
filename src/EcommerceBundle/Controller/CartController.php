<?php

namespace EcommerceBundle\Controller;

use Mmoreram\ControllerExtraBundle\Annotation\Entity as AnnotationEntity;
use Mmoreram\ControllerExtraBundle\Exceptions\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use EcommerceBundle\Model\Interfaces\CartInterface;
use EcommerceBundle\Model\Interfaces\CartLineInterface;
use EcommerceBundle\Model\Interfaces\ProductInterface;

/**
 * @author Germán Figna <gfigna@wearemarketing.com>
 */
class CartController extends Controller
{
    /**
     * Adds product into cart.
     *
     * @param Request          $request Request object
     * @param ProductInterface $product Product id
     * @param CartInterface    $cart    Cart
     *
     * @return Response Redirect response
     *
     * @throws EntityNotFoundException product not found
     *
     *
     * @AnnotationEntity(
     *      class = "wam.ecommerce.class.product",
     *      name = "product",
     *      mapping = {
     *          "id" = "~id~"
     *      }
     * )
     * @AnnotationEntity(
     *      class = {
     *          "factory" = "wam_ecommerce.wrapper.cart",
     *          "method" = "get",
     *          "static" = false,
     *      },
     *      name = "cart"
     * )
     */
    public function addProductAction(
        Request $request,
        ProductInterface $product,
        CartInterface $cart
    ) {
        $cartQuantity = (int) $request
            ->request
            ->get('add-cart-quantity', 1);

        $this
            ->get('wam_ecommerce.cart.manager')
            ->addPurchasable(
                $cart,
                $product,
                $cartQuantity
            );

        if ($request->isXmlHttpRequest()) {
            return new JsonResponse(array('result' => 'ok'));
        }

        $referrer = $request
            ->headers
            ->get(
                'referer',
                $this->generateUrl('wam_ecommerce_store_cart_view')
            );

        return $this->redirect($referrer);
    }

    /**
     * Empty Cart.
     *
     * @param CartInterface $cart Cart
     *
     * @return RedirectResponse
     *
     *
     * @AnnotationEntity(
     *      class = {
     *          "factory" = "wam_ecommerce.wrapper.cart",
     *          "method" = "get",
     *          "static" = false,
     *      },
     *      name = "cart"
     * )
     */
    public function emptyCartAction(CartInterface $cart)
    {
        $this
            ->get('wam_ecommerce.cart.manager')
            ->emptyLines($cart);

        return $this->redirect(
            $this->generateUrl('wam_ecommerce_store_cart_view')
        );
    }

    /**
     * Deletes CartLine.
     *
     * @param CartInterface     $cart     Cart
     * @param CartLineInterface $cartLine Cart Line
     *
     * @return RedirectResponse
     *
     *
     * @AnnotationEntity(
     *      class = {
     *          "factory" = "wam_ecommerce.wrapper.cart",
     *          "method" = "get",
     *          "static" = false,
     *      },
     *      name = "cart"
     * )
     * @AnnotationEntity(
     *      class = "wam.ecommerce.class.cart_line",
     *      name = "cartLine",
     *      mapping = {
     *          "id" = "~id~",
     *      }
     * )
     */
    public function removeCartLineAction(
        Request $request,
        CartInterface $cart,
        CartLineInterface $cartLine
    ) {
        $this
            ->get('wam_ecommerce.cart.manager')
            ->removeLine(
                $cart,
                $cartLine
            );

        if ($request->isXmlHttpRequest()) {
            return new JsonResponse(array('result' => 'ok'));
        }

        $referrer = $request
            ->headers
            ->get(
                'referer',
                $this->generateUrl('wam_ecommerce_store_cart_view')
            );

        return $this->redirect($referrer);
    }

    /**
     * Adds show the cart.
     *
     * @param Request       $request Request object
     * @param CartInterface $cart    Cart
     *
     * @return Response
     *
     * @AnnotationEntity(
     *      class = {
     *          "factory" = "wam_ecommerce.wrapper.cart",
     *          "method" = "get",
     *          "static" = false,
     *      },
     *      name = "cart"
     * )
     */
    public function checkoutAction(
        Request $request,
        CartInterface $cart
    ) {
        $products = $this->get('wam_ecommerce.product.manager')->getProducts();

        return $this->render('WAMEcommerceBundle:Cart:checkout.html.twig', array(
            'cart' => $cart,
            'products' => $products,
        ));
    }

    /**
     * Adds show the cart.
     *
     * @param Request       $request Request object
     * @param CartInterface $cart    Cart
     *
     * @return Response
     *
     * @AnnotationEntity(
     *      class = {
     *          "factory" = "wam_ecommerce.wrapper.cart",
     *          "method" = "get",
     *          "static" = false,
     *      },
     *      name = "cart"
     * )
     */
    public function viewAction(Request $request, CartInterface $cart)
    {
        return $this->render('WAMEcommerceBundle:Cart:view.html.twig', array(
            'cart' => $cart,
        ));
    }
}
