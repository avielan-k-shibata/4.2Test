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
use Eccube\Entity\Order;

/**
 * OrderPlus
 *
 * @ORM\Table(name="plg_order_plus")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discriminator_type", type="string", length=255)
 * @ORM\Entity(repositoryClass="Plugin\Test\Repository\OrderPlusRepository")
 */

class OrderPlus extends AbstractEntity
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
     * @ORM\Column(name="attention", type="string", length=255)
     */
    private $attention;

    /**
     * @var \Eccube\Entity\Order
     *
     * @ORM\OneToOne(targetEntity="Eccube\Entity\Order", inversedBy="OrderPlus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     * })
     */
    private $Order;

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
     * @return OrderPlus
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
    /**
     * Get name.
     *
     * @return string
     */
    public function getAttention()
    {
        return $this->attention;
    }

    /**
     * Set name.
     *
     * @param string $attention
     *
     * @return OrderPlus
     */
    public function setAttention($attention)
    {
        $this->attention = $attention;

        return $this;
    }
        /**
     * get related order content.
     *
     * @return Order
     */
    public function getOrder()
    {
        return $this->Order;
    }

    /**
     * set related order order.
     *
     * @param Order $Order
     *
     * @return $this
     */
    public function setOrder(Order $Order): self
    {
        $this->Order = $Order;

        return $this;
    }  
}