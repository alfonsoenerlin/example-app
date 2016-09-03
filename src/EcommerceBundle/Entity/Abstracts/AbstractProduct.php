<?php

namespace EcommerceBundle\Entity\Abstracts;

use Doctrine\Common\Collections\Collection;
use EcommerceBundle\Model\Interfaces\ProductInterface;
use EcommerceBundle\Model\Traits\DateTimeTrait;
use EcommerceBundle\Model\Interfaces\FakeCategoryInterface as CategoryInterface;

/**
 * Class AbstractProduct.
 *
 * @author Germán Figna <gfigna@wearemarketing.com>
 */
abstract class AbstractProduct extends AbstractPurchasable
    implements  ProductInterface
{
    use DateTimeTrait;


    /**
     * @var Collection
     */
    protected $categories;

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->translate(null, false)->getTitle();
    }

    /**
     * @param  $title
     *
     * @return AbstractProduct
     */
    public function setTitle($title)
    {
        $this->translate(null, false)->setTitle($title);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->translate(null, false)->getDescription();
    }

    /**
     * @param  $description
     *
     * @return AbstractProduct
     */
    public function setDescription($description)
    {
        $this->translate(null, false)->setDescription($description);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->translate(null, false)->getSlug();
    }

    /**
     * @param  $slug
     *
     * @return AbstractProduct
     */
    public function setSlug($slug)
    {
        $this->translate(null, false)->setSlug($slug);

        return $this;
    }

    /**
     * @return Media
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * @param Media $media
     *
     * @return AbstractProduct
     */
    public function setMedia($media)
    {
        $this->media = $media;

        return $this;
    }

    /**
     * Provides a title of this page to be used in SEO context.
     *
     * @return string
     */
    public function getSeoTitle()
    {
        return $this->getTitle();
    }

    /**
     * Provide a description of this page to be used in SEO context.
     *
     * @return string
     */
    public function getSeoDescription()
    {
        return $this->getDescription();
    }

    /**
     * Provides a list of keywords for this page to be
     * used in SEO context.
     *
     * @return string|array
     */
    public function getSeoKeywords()
    {
        return '';
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        $date = new \DateTime('now');

        return
            $this->status === ExpirableBehaviourInterface::STATUS_PUBLISHED
            && $this->dateStart <= $date
            && ($this->dateEnd > $date || is_null($this->dateEnd));
    }

    /**
     * {@inheritdoc}
     */
    public function setCategories(Collection $categories)
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * {@inheritdoc}
     */
    public function addCategory(CategoryInterface $category)
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeCategory(CategoryInterface $category)
    {
        $this->categories->removeElement($category);

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return 'Product #'.$this->getId();
    }

    protected function doTranslate($locale = null, $fallbackToDefault = true)
    {
        if (null === $locale) {
            $locale = $this->getCurrentLocale();
        }

        $translation = $this->findTranslationByLocale($locale);
        if ($translation and !$translation->isEmpty()) {
            return $translation;
        }

        if ($fallbackToDefault && $defaultTranslation = $this->findTranslationByLocale($this->getDefaultLocale(), false)) {
            return $defaultTranslation;
        }

        $class = $this->getTranslationEntity();
        $translation = new $class();
        $translation->setLocale($locale);

        $this->getNewTranslations()->set($translation->getLocale(), $translation);
        $translation->setTranslatable($this);

        return $translation;
    }
}
