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
use Eccube\Entity\AbstractEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Eccube\Entity\Product;
/**
 * Class ProductDetail.
 *
 * @ORM\Table(name="plg_test_product_detail")
 * @ORM\Entity(repositoryClass="Plugin\Test\Repository\ProductDetailRepository")
 */
class ProductDetail extends AbstractEntity
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", options={"unsigned":true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="detail", type="string", length=255)
     */
    private $detail;

    /**
     * @var string
     *
     * @ORM\Column(name="contents", type="string", length=255)
     */
    private $contents;

    /**
     * @var int
     *
     * @ORM\Column(name="sort_no", type="integer")
     */
    private $sort_no;


    /**
     * @var Product
     *
     * @ORM\ManyToOne(targetEntity="Eccube\Entity\Product", inversedBy="RelatedProducts")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     * })
     */
    private $Product;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return ProductDetail
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get detail.
     *
     * @return string
     */
    public function getDetail()
    {
        return $this->detail;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return ProductDetail
     */
    public function setDetail($detail)
    {
        $this->detail = $detail;

        return $this;
    }

    /**
     * Get detail.
     *
     * @return string
     */
    public function getContents()
    {
        return $this->contents;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return ProductDetail
     */
    public function setContents($contents)
    {
        $this->contents = $contents;

        return $this;
    }

    /**
     * Get sort_no.
     *
     * @return int
     */
    public function getSortNo()
    {
        return $this->sort_no;
    }

    /**
     * Set sort no.
     *
     * @param int $sortNo
     *
     * @return ProductDetail
     */
    public function setSortNo($sortNo)
    {
        $this->sort_no = $sortNo;

        return $this;
    }

    /**
     * get related product content.
     *
     * @return Product
     */
    public function getProduct()
    {
        return $this->Product;
    }

    /**
     * set related product product.
     *
     * @param Product $Product
     *
     * @return $this
     */
    public function setProduct(Product $Product): self
    {
        $this->Product = $Product;

        return $this;
    }    
    /**
     * Unique check.
     *
     * @param ClassMetadata $metadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addConstraint(new UniqueEntity([
            'fields' => 'name',
        ]));
    }
}
