<?php

namespace EcommerceBundle\Model\Interfaces;

use Doctrine\Common\Collections\Collection;
use EcommerceBundle\Model\Interfaces\FakeCategoryInterface as CategoryInterface;

/**
 * Class ProductInterface.
 *
 * @author Germán Figna <gfigna@wearemarketing.com>
 */
interface ProductInterface extends PurchasableInterface
{
    /**
     * Set slug.
     *
     * @param string $slug Slug
     *
     * @return ProductInterface Self object
     */
    public function setSlug($slug);

    /**
     * Get slug.
     *
     * @return string slug
     */
    public function getSlug();

    /**
     * @param string $description
     *
     * @return ProductInterface Self object
     */
    public function setDescription($description);

    /**
     * Get description.
     *
     * @return string Description
     */
    public function getDescription();

    /**
     * Set categories.
     *
     * @param Collection $categories Categories
     *
     * @return OrderInterface Self object
     */
    public function setCategories(Collection $categories);

    /**
     * Get categories.
     *
     * @return Collection Categories
     */
    public function getCategories();

    /**
     * Add category.
     *
     * @param CategoryInterface $category Category
     *
     * @return OrderInterface Self object
     */
    public function addCategory(CategoryInterface $category);

    /**
     * Remove category.
     *
     * @param CategoryInterface $category Category
     *
     * @return OrderInterface Self object
     */
    public function removeCategory(CategoryInterface $category);
}
