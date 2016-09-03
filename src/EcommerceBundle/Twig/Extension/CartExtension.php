<?php

namespace EcommerceBundle\Twig\Extension;

use EcommerceBundle\Wrapper\CartWrapper;

/**
 * @author Germán Figna <gfigna@wearemarketing.com>
 */
class CartExtension extends  \Twig_Extension
{
    /**
     * CartExtension constructor.
     *
     * @param CartWrapper $cartWrapper
     */
    public function __construct(CartWrapper $cartWrapper)
    {
        $this->cartWrapper = $cartWrapper;
    }

    /**
     * @var CartWrapper
     */
    protected $cartWrapper;
    /**
     * Returns a list of global functions to add to the existing list.
     *
     * @return array An array of global functions
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction(
                'wam_ecommerce_shoping_cart',
                array($this, 'renderCart'),
                array(
                    'is_safe' => array('html'),
                    'needs_environment' => true,
                )
            ),
        );
    }

    /**
     * @param \Twig_Environment $twig
     * @param string|null       $template
     *
     * @return string
     */
    public function renderCart(\Twig_Environment $twig, $template = null)
    {
        $finalTemplate = is_null($template) ? 'WAMEcommerceBundle:Cart:block.html.twig' : $template;

        $cart = $this->cartWrapper->get();

        return $twig->render($finalTemplate, array(
            'cart' => $cart,
        ));
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'wam_shopping_cart';
    }
}
