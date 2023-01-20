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
use Eccube\Form\Type\Admin\ProductType;
use Plugin\RelatedProduct42\Entity\RelatedProduct;
use Plugin\Test\Entity\ProductDetail;
use Plugin\Test\Form\Type\Admin\ProductDetailType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\TextType;


/**
 * Class ProductDetailExtension.
 */
class ProductDetailExtension extends AbstractTypeExtension
{
    /**
     * @var EccubeConfig
     */
    private $eccubeConfig;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EccubeConfig $eccubeConfig, EntityManagerInterface $entityManager)
    {
        $this->eccubeConfig = $eccubeConfig;
        $this->entityManager = $entityManager;
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
            ->add('ProductDetails', CollectionType::class, [
                'label' => 'product_detail.block.title',
                'entry_type' => ProductDetailType::class,
                'required' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true
            ])
            ;
        $builder->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {
            /** @var Product $Product */
            $Product = $event->getData();
            dump($Product);
            $form = $event->getForm();
            $form['ProductDetails']->setData($Product->getProductDetails());
        });
        $builder
            ->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event){
                /** @var Product $data */
                $data = $event->getData();
                $form = $event->getForm();

                // 商品項目をクリア
                $productItems = $this->entityManager->getRepository(ProductDetail::class)
                    ->findBy(["Product" => $data]);
                foreach ($productItems as $productItem) {
                    $this->entityManager->remove($productItem);
                }

                // 商品項目を登録
                $productItems = $form->get('ProductDetails')->getData();

                /** @var ProductItem $productItem */
                foreach($productItems as $productItem) {
                    $productItem->setProduct($data);
                    $this->entityManager->persist($productItem);
                }
            });
    }

    /**
     * product admin form name.
     *
     * @return string
     */
    public function getExtendedType()
    {
        return ProductType::class;
    }

    /**
     * product admin form name.
     *
     * @return string[]
     */
    public static function getExtendedTypes(): iterable
    {
        yield ProductType::class;
    }
}
