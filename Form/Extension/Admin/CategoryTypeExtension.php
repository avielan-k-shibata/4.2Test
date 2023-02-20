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
use Eccube\Entity\Category;
use Eccube\Entity\Block;

use Eccube\Form\Type\Admin\CategoryType;
use Plugin\Test\Entity\CategoryBlock;
use Plugin\Test\Form\Type\Admin\ProductDetailType;
use Plugin\Test\Form\Type\Admin\ProductBlockType;
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

/**
 * Class CategoryTypeExtension.
 */
class CategoryTypeExtension extends AbstractTypeExtension
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

        // 詳細な説明
        $builder->add('Block', ChoiceType::class, [
            'choice_label' => 'Name',
            'multiple' => true,
            'mapped' => false,
            'expanded' => true,
            'choices' => $this->blockRepository->getList(10),
            'choice_value' => function (Block $Block = null) {
                return $Block ? $Block->getId() : null;
            },
        ]);

        $builder->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {
            /** @var Product $Product */
            $Product = $event->getData();
            $form = $event->getForm();
            $form['ProductDetails']->setData($Product->getProductDetails());
            $form['ProductBlock']->setData($Product->getProductBlock());
        });
        
        $builder
        ->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event){
            /** @var Product $data */
            $Product = $event->getData();
            $form = $event->getForm();

            $productItems = $this->entityManager->getRepository(ProductBlock::class)
            ->findBy(["Product" => $Product]);
            foreach ($productItems as $productItem) {
                $this->entityManager->remove($productItem);
                $this->entityManager->flush();
            }
            // 商品項目を登録
            $Blocks = $form->get('Block')->getData();
            /** @var ProductItem $productItem */
            foreach($Blocks as $Block) {
                $ProductBlock = new ProductBlock();
                $ProductBlock 
                    ->setProductId($Product->getId())
                    ->setBlockId($Block->getId())
                    ->setProduct($Product)
                    ->setBlock($Block);
                // $Product->addProductBlock($ProductBlock);
                $this->entityManager->persist($ProductBlock);
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
        return CategoryType::class;
    }

    /**
     * product admin form name.
     *
     * @return string[]
     */
    public static function getExtendedTypes(): iterable
    {
        yield CategoryType::class;
    }
}
