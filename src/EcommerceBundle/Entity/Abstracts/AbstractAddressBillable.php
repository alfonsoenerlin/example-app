<?php

namespace EcommerceBundle\Entity\Abstracts;

/**
 * Class AbstractAddressBillable.
 *
 * @author Germán Figna <gfigna@wearemarketing.com>
 */
abstract class AbstractAddressBillable
{
    /**
     * Dirección Linea 1.
     *
     * @var string
     */
    protected $addressLine1;

    /**
     * Dirección Linea 2.
     *
     * @var string
     */
    protected $addressLine2;

    /**
     * Nombre o Razón social.
     *
     * @var string
     */
    protected $name;

    /**
     * DNI o CIF.
     *
     * @var string
     */
    protected $nif;

    /**
     * Teléfono.
     *
     * @var string
     */
    protected $phone;

    /**
     * @return string
     */
    public function getAddressLine1()
    {
        return $this->addressLine1;
    }

    /**
     * @param string $addressLine1
     *
     * @return $this
     */
    public function setAddressLine1($addressLine1)
    {
        $this->addressLine1 = $addressLine1;

        return $this;
    }

    /**
     * @return string
     */
    public function getAddressLine2()
    {
        return $this->addressLine2;
    }

    /**
     * @param string $addressLine2
     *
     * @return $this
     */
    public function setAddressLine2($addressLine2)
    {
        $this->addressLine2 = $addressLine2;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getNif()
    {
        return $this->nif;
    }

    /**
     * @param string $nif
     *
     * @return $this
     */
    public function setNif($nif)
    {
        $this->nif = $nif;

        return $this;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     *
     * @return $this
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }
}
