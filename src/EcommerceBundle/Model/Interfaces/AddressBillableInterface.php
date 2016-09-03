<?php
/**
 * @author Germán Figna <gfigna@wearemarketing.com>
 */
namespace EcommerceBundle\Model\Interfaces;

/**
 * Interface AddressBillableInterface
 * @package EcommerceBundle\Model\Interfaces
 */
interface AddressBillableInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getAddressLine1();

    /**
     * @param string $addressLine1
     *
     * @return $this
     */
    public function setAddressLine1($addressLine1);

    /**
     * @return string
     */
    public function getAddressLine2();

    /**
     * @param string $addressLine2
     *
     * @return $this
     */
    public function setAddressLine2($addressLine2);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getNif();

    /**
     * @param string $nif
     *
     * @return $this
     */
    public function setNif($nif);
    
    /**
     * @return string
     */
    public function getPhone();

    /**
     * @param string $phone
     *
     * @return $this
     */
    public function setPhone($phone);
}
