<?php

namespace EcommerceBundle\Entity;

use EcommerceBundle\Model\Interfaces\OrderInterface;
use EcommerceBundle\Model\Interfaces\PaymentInterface;
use EcommerceBundle\Model\Traits\DateTimeTrait;
use EcommerceBundle\Model\Traits\IdentifiableTrait;

/**
 * @author Germán Figna <gfigna@wearemarketing.com>
 */
class Payment implements PaymentInterface
{
    use IdentifiableTrait;
    use DateTimeTrait;

    const RESULT_SUCCESS = 'SUCCESS';
    const RESULT_FAIL = 'FAIL';

    /**
     * @var string Payment Name
     */
    protected $methodName;

    /**
     * @var string Payment Result Data
     */
    protected $resultData;

    /**
     * @var OrderInterface
     */
    protected $order;

    /**
     * @var string
     */
    protected $status;

    /**
     * {@inheritdoc}
     */
    public function getMethodName()
    {
        return $this->methodName;
    }

    /**
     * {@inheritdoc}
     */
    public function setMethodName($methodName)
    {
        $this->methodName = $methodName;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getResultData()
    {
        return $this->resultData;
    }

    /**
     * {@inheritdoc}
     */
    public function setResultData($resultData)
    {
        $this->resultData = $resultData;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * {@inheritdoc}
     */
    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * {@inheritdoc}
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    public function __toString()
    {
        return "#{$this->id} {$this->getStatus()} Payment {$this->getMethodName()}";
    }
}
