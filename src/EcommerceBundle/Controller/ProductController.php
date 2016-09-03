<?php

namespace EcommerceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use EcommerceBundle\Model\Interfaces\ProductInterface;

class ProductController extends Controller
{
    /**
     * Product view.
     *
     * @param ProductInterface $contentDocument Product
     *
     * @return Response
     */
    public function viewAction(ProductInterface $contentDocument)
    {
        return $this->render('WAMEcommerceBundle:Product:view.html.twig', array(
            'product' => $contentDocument,
        ));
    }

    /**
     * Product list.
     *
     * @return Response
     */
    public function listAction()
    {
        $products = $this->getProductManager()->getProducts();

        return $this->render('WAMEcommerceBundle:Product:list.html.twig', array(
            'products' => $products,
        ));
    }

    /**
     * @return ProducManagerInterface
     */
    protected function getProductManager()
    {
        return $this->get('wam_ecommerce.product.manager');
    }
}
