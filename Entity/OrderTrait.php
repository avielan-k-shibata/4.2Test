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
 * @Eccube\EntityExtension("Eccube\Entity\Order")
 */
trait OrderTrait
{

    /**
     * @var OrderPlus
     *
     * @ORM\OneToOne(targetEntity="Plugin\Test\Entity\OrderPlus", mappedBy="Order", cascade={"persist", "remove"})
     * @ORM\OrderBy({
     *     "id"="ASC"
     * })
     */
    private $OrderPlus;

    /**
     * @return OrderPlus
     */
    public function getOrderPlus()
    {

        return $this->OrderPlus;
    }

    /**
     * @param \Plugin\Test\Entity\OrderPlus $OrderPlus
     */
    public function addOrderPlus(OrderPlus $OrderPlus)
    {

        $this->OrderPlus[] = $OrderPlus;
        return $this;
    }

    /**
     * @param \Plugin\Test\Entity\OrderPlus $OrderPlus
     *
     * @return bool
     */
    public function removeOrderPlus(OrderPlus $OrderPlus)
    {

        return $this->OrderPlus->removeElement($OrderPlus);
    }

}
