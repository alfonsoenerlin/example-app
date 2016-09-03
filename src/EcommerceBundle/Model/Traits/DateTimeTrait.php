<?php

namespace EcommerceBundle\Model\Traits;

/**
 * trait for DateTime common variables and methods.
 */
trait DateTimeTrait
{
    /**
     * @var \DateTime
     *
     * Created at
     */
    protected $createdAt;

    /**
     * @var \DateTime
     *
     * Updated at
     */
    protected $updatedAt;

    /**
     * Set locally created at value.
     *
     * @param \DateTime $createdAt Created at value
     *
     * @return $this Self object
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Return created_at value.
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set locally updated at value.
     *
     * @param \DateTime $updatedAt Updated at value
     *
     * @return $this Self object
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Return updated_at value.
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Method triggered by LifeCycleEvent.
     * Sets or updates $this->updatedAt.
     */
    public function loadUpdateAt()
    {
        $this->setUpdatedAt(new \DateTime());
    }
}
