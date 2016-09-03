<?php

namespace EcommerceBundle\Model\Interfaces;

/**
 * Interface IdentifiableInterface.
 */
interface IdentifiableInterface
{
    /**
     * Get Id.
     *
     * @return int Id
     */
    public function getId();

    /**
     * Sets Id.
     *
     * @param int $id Id
     *
     * @return IdentifiableInterface Self object
     */
    public function setId($id);
}
