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
 * @Eccube\EntityExtension("Eccube\Entity\Category")
 */
trait CategoryTrait
{
    // カテゴリーとブロックの紐づけ
    /**
     * @var CategoryBlock[]|Collection
     *
     * @ORM\OneToMany(targetEntity="Plugin\Test\Entity\CategoryBlock", mappedBy="Category", cascade={"remove"})
     */
    private $CategoryBlock;
    /**
     * Add categoryBlock.
     *
     * @param \Plugin\Test\Entity\CategoryBlock $categoryBlock
     *
     * @return Category
     */
    public function addCategoryBlock(CategoryBlock $categoryBlock)
    {
        $this->CategoryBlock[] = $categoryBlock;

        return $this;
    }

    /**
     * Remove categoryBlock.
     *
     * @param \Plugin\Test\Entity\CategoryBlock $categoryBlock
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeCategoryBlock(CategoryBlock $categoryBlock)
    {
        return $this->CategoryBlock->removeElement($categoryBlock);
    }

    /**
     * Get categoryBlock.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategoryBlock()
    {
        return $this->CategoryBlock;
    }

    /**
     * Get Block
     * フロント側タグsort_no順の配列を作成する
     *
     * @return []Block
     */
    public function getBlocks()
    {
        $Blocks = [];

        foreach ($this->getCategoryBlock() as $categoryBlock) {
            $Blocks[] = $categoryBlock->getBlock();
        }
        return $Blocks;
    }
    
}
