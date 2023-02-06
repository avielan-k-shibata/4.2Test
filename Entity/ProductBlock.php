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
use Eccube\Entity\Product;
use Eccube\Entity\Block;


    /**
     * ProductBlock
     *
     * @ORM\Table(name="plg_product_block")
     * @ORM\InheritanceType("SINGLE_TABLE")
     * @ORM\DiscriminatorColumn(name="discriminator_type", type="string", length=255)
     * @ORM\HasLifecycleCallbacks()
     * @ORM\Entity(repositoryClass="Eccube\Repository\ProductBlockRepository")
     */
    class ProductBlock extends AbstractEntity
    {
        /**
         * @var int
         *
         * @ORM\Column(name="product_id", type="integer", options={"unsigned":true})
         * @ORM\Id
         * @ORM\GeneratedValue(strategy="NONE")
         */
        private $product_id;

        /**
         * @var int
         *
         * @ORM\Column(name="block_id", type="integer", options={"unsigned":true})
         * @ORM\Id
         * @ORM\GeneratedValue(strategy="NONE")
         */
        private $block_id;

        /**
         * @var \Eccube\Entity\Product
         *
         * @ORM\ManyToOne(targetEntity="Eccube\Entity\Product", inversedBy="ProductBlocks")
         * @ORM\JoinColumns({
         *   @ORM\JoinColumn(name="product_id", referencedColumnName="id")
         * })
         */
        private $Product;

        /**
         * @var \Eccube\Entity\Block
         *
         * @ORM\ManyToOne(targetEntity="Eccube\Entity\Block", inversedBy="ProductBlocks")
         * @ORM\JoinColumns({
         *   @ORM\JoinColumn(name="block_id", referencedColumnName="id")
         * })
         */
        private $Block;

        /**
         * Set productId.
         *
         * @param int $productId
         *
         * @return ProductBlock
         */
        public function setProductId($productId)
        {
            $this->product_id = $productId;

            return $this;
        }

        /**
         * Get productId.
         *
         * @return int
         */
        public function getProductId()
        {
            return $this->product_id;
        }

        /**
         * Set blockId.
         *
         * @param int $blockId
         *
         * @return ProductBlock
         */
        public function setBlockId($blockId)
        {
            $this->block_id = $blockId;

            return $this;
        }

        /**
         * Get blockId.
         *
         * @return int
         */
        public function getBlockId()
        {
            return $this->block_id;
        }

        /**
         * Set product.
         *
         * @param \Eccube\Entity\Product|null $product
         *
         * @return ProductBlock
         */
        public function setProduct(Product $product = null)
        {
            $this->Product = $product;

            return $this;
        }

        /**
         * Get product.
         *
         * @return \Eccube\Entity\Product|null
         */
        public function getProduct()
        {
            return $this->Product;
        }

        /**
         * Set block.
         *
         * @param \Eccube\Entity\Block|null $block
         *
         * @return ProductBlock
         */
        public function setBlock(Block $block = null)
        {
            $this->Block = $block;

            return $this;
        }

        /**
         * Get block.
         *
         * @return \Eccube\Entity\Block|null
         */
        public function getBlock()
        {
            return $this->Block;
        }
    }
