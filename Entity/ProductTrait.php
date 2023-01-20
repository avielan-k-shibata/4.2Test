<?php

/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) EC-CUBE CO.,LTD. All Rights Reserved.
 *
 * http://www.ec-cube.co.jp/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\Test\Entity;

use Doctrine\ORM\Mapping as ORM;
use Eccube\Annotation as Eccube;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Eccube\Annotation\EntityExtension;

/**
 * @Eccube\EntityExtension("Eccube\Entity\Product")
 */
trait ProductTrait
{
    /**
     * 商品がカテゴリーに属しているかどうかチェックする 子カテゴリーは考慮しない
     * @param $category \Eccube\Entity\Category|integer|string
     * @return bool
     */
    public function belongsToCategory($category)
    {
        if ($category instanceof \Eccube\Entity\Category) {
            $category = $category->getId();
        }
        foreach ($this->ProductCategories as $C) {
            if (is_int($category)) {
                if ($C->getCategoryId() === $category) {
                    return true;
                }
            } else if (is_string($category)) {
                if ($C->getCategory()->getName() === $category) {
                    return true; // もし同じ名前のカテゴリーが複数登録されていればこの比較はできません
                }
            } else {
                // throw new \Exception()するなりお好きに
            }
        }
        return false;
    }

    /**
     * @var ProductDetail[]|Collection
     *
     * @ORM\OneToMany(targetEntity="Plugin\Test\Entity\ProductDetail", mappedBy="Product", cascade={"persist", "remove"})
     * @ORM\OrderBy({
     *     "id"="ASC"
     * })
     */
    private $ProductDetails;

    /**
     * @return ProductDetail[]|Collection
     */
    public function getProductDetails()
    {
        if (null === $this->ProductDetails) {
            $this->ProductDetails = new ArrayCollection();
        }

        return $this->ProductDetails;
    }

    /**
     * @param ProductDetail $ProductDetail
     */
    public function addProductDetail(ProductDetail $ProductDetail)
    {
        if (null === $this->ProductDetails) {
            $this->RelatedProducts = new ArrayCollection();
        }

        $this->ProductDetails[] = $ProductDetail;
    }

    /**
     * @param ProductDetail $RelatedProduct
     *
     * @return bool
     */
    public function removeProductDetail(ProductDetail $ProductDetail)
    {
        if (null === $this->ProductDetails) {
            $this->ProductDetails = new ArrayCollection();
        }

        return $this->ProductDetails->removeElement($ProductDetail);
    }
}
