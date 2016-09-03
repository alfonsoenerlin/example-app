<?php

namespace EcommerceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use EcommerceBundle\Model\Interfaces\OrderInterface;

/**
 * @author Germán Figna <gfigna@wearemarketing.com>
 */
class OrderController extends Controller
{
    /**
     * Order view.
     *
     * @param int $id Order id
     *
     * @return Response Response
     */
    public function thanksAction($id)
    {
        $order = $this
            ->get('wam_ecommerce.order.manager')
            ->findOneBy(array(
                'id' => $id,
                'customer' => $this->getUser(),
                )
            );

        if (!($order instanceof OrderInterface)) {
            throw $this->createNotFoundException('Order not found');
        }

        return $this->render('WAMEcommerceBundle:Order:thanks.html.twig', array(
            'order' => $order,
        ));
    }
}
