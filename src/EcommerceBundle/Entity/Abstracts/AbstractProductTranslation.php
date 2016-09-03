<?php

namespace EcommerceBundle\Entity\Abstracts;

use EcommerceBundle\Model\Interfaces\ProductTranslationInterface;

abstract class AbstractProductTranslation implements ProductTranslationInterface
{

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     *
     * Description
     */
    protected $description;

    /**
     * @var string
     *
     * Description
     */
    protected $slug;

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Set description.
     *
     * @param string $description Description
     *
     * @return AbstractProductTranslation Self object
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string Description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return array
     */
    public function getSluggableFields()
    {
        return array('title');
    }

    /**
     * Set slug.
     *
     * @param string $slug Slug
     *
     * @return AbstractProductTranslation Self object
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug.
     *
     * @return string slug
     */
    public function getSlug()
    {
        return $this->slug;
    }
}
