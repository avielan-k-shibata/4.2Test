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
use Eccube\Entity\Category;
use Eccube\Entity\Block;


    /**
     * CategoryBlock
     *
     * @ORM\Table(name="plg_category_block")
     * @ORM\InheritanceType("SINGLE_TABLE")
     * @ORM\DiscriminatorColumn(name="discriminator_type", type="string", length=255)
     * @ORM\HasLifecycleCallbacks()
     * @ORM\Entity(repositoryClass="Plugin\Test\Repository\CategoryBlockRepository")
     */
    class CategoryBlock extends AbstractEntity
    {
        /**
         * @var int
         *
         * @ORM\Column(name="category_id", type="integer", options={"unsigned":true})
         * @ORM\Id
         * @ORM\GeneratedValue(strategy="NONE")
         */
        private $category_id;

        /**
         * @var int
         *
         * @ORM\Column(name="block_id", type="integer", options={"unsigned":true})
         * @ORM\Id
         * @ORM\GeneratedValue(strategy="NONE")
         */
        private $block_id;

        /**
         * @var \Eccube\Entity\Category
         *
         * @ORM\ManyToOne(targetEntity="Eccube\Entity\Category", inversedBy="CategoryBlocks")
         * @ORM\JoinColumns({
         *   @ORM\JoinColumn(name="category_id", referencedColumnName="id")
         * })
         */
        private $Category;

        /**
         * @var \Eccube\Entity\Block
         *
         * @ORM\ManyToOne(targetEntity="Eccube\Entity\Block", inversedBy="CategoryBlocks")
         * @ORM\JoinColumns({
         *   @ORM\JoinColumn(name="block_id", referencedColumnName="id")
         * })
         */
        private $Block;

        /**
         * Set categoryId.
         *
         * @param int $categoryId
         *
         * @return CategoryBlock
         */
        public function setCategoryId($categoryId)
        {
            $this->category_id = $categoryId;

            return $this;
        }

        /**
         * Get categoryId.
         *
         * @return int
         */
        public function getCategoryId()
        {
            return $this->category_id;
        }

        /**
         * Set blockId.
         *
         * @param int $blockId
         *
         * @return CategoryBlock
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
         * Set category.
         *
         * @param \Eccube\Entity\Category|null $category
         *
         * @return CategoryBlock
         */
        public function setCategory(Category $category = null)
        {
            $this->Category = $category;

            return $this;
        }

        /**
         * Get category.
         *
         * @return \Eccube\Entity\Category|null
         */
        public function getCategory()
        {
            return $this->Category;
        }

        /**
         * Set block.
         *
         * @param \Eccube\Entity\Block|null $block
         *
         * @return CategoryBlock
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
