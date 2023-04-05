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

namespace Plugin\Test\Form\Extension\Admin;

use Doctrine\ORM\EntityManagerInterface;
use Eccube\Common\EccubeConfig;
use Eccube\Entity\Product;
use Eccube\Entity\Order;

use Eccube\Form\Type\Admin\ProductType;
use Plugin\RelatedProduct42\Entity\RelatedProduct;
use Plugin\Test\Entity\OrderPlus;
use Plugin\Test\Entity\ProductBlock;
use Plugin\Test\Form\Type\Admin\ProductDetailType;
use Plugin\Test\Form\Type\Admin\OrderPlusType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Eccube\Repository\BlockRepository;
use Eccube\Form\Type\Admin\OrderType;

/**
 * Class OrderTypeExtension.
 */
class OrderTypeExtension extends AbstractTypeExtension
{
    /**
     * @var EccubeConfig
     */
    private $eccubeConfig;
    /**
     * @var BlockRepository
     */
    protected $blockRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(
        BlockRepository $blockRepository,
        EccubeConfig $eccubeConfig, 
        EntityManagerInterface $entityManager)
    {
        $this->eccubeConfig = $eccubeConfig;
        $this->entityManager = $entityManager;
        $this->blockRepository = $blockRepository;

    }

    /**
     * RelatedCollectionExtension.
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        // ->add('OrderPlus', CollectionType::class, [
        //     'label' => 'plus',
        //     'entry_type' => OrderPlusType::class,
        //     'allow_add' => true,
        //     'allow_delete' => true,
        //     'prototype' => true,
        // ])
        ->add('OrderPlus', OrderPlusType::class, [
            // 'mapped' => false,
            // 'prototype' => true,
            // 'data_class' => null,
        ])
    ;
        
    }

    /**
     * order admin form name.
     *
     * @return string
     */
    public function getExtendedType()
    {
        return OrderType::class;
    }

    /**
     * order admin form name.
     *
     * @return string[]
     */
    public static function getExtendedTypes(): iterable
    {
        yield OrderType::class;
    }
}
