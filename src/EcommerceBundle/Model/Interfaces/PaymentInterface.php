<?php

namespace EcommerceBundle\Model\Interfaces;

/**
 * Interface PaymentInterface.
 */
interface PaymentInterface
    extends
    IdentifiableInterface
{
    /**
     * Sets Method Name.
     *
     * @param string $methodName
     *
     * @return PaymentInterface Self object
     */
    public function setMethodName($methodName);

    /**
     * Get Method Name.
     *
     * @return string Method Name
     */
    public function getMethodName();

    /**
     * Get Result data.
     *
     * @return array ResultData
     */
    public function getResultData();

    /**
     * Sets Result data.
     *
     * @param array $resultData
     *
     * @return PaymentInterface Self object
     */
    public function setResultData($resultData);

    /**
     * @return OrderInterface
     */
    public function getOrder();

    /**
     * @param OrderInterface $order
     *
     * @return PaymentInterface
     */
    public function setOrder($order);

    /**
     * @return string
     */
    public function getStatus();

    /**
     * @param string $status
     *
     * @return PaymentInterface Self object
     */
    public function setStatus($status);
}
