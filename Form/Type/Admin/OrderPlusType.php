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

namespace Plugin\Test\Form\Type\Admin;

use Doctrine\ORM\EntityManagerInterface;
use Eccube\Common\EccubeConfig;
use Plugin\Test\Entity\ProductDetail;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Plugin\Test\Entity\OrderPlus;

/**
 * Class OrderPlusType.
 */
class OrderPlusType extends AbstractType
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;
    /**
     * @var EccubeConfig
     */
    private $eccubeConfig;

    /**
     * ProductDetailType constructor.
     *
     * @param EccubeConfig $eccubeConfig
     */
    public function __construct(EccubeConfig $eccubeConfig, EntityManagerInterface $entityManager)
    {
        $this->eccubeConfig = $eccubeConfig;
        $this->entityManager = $entityManager;

    }

    /**
     * Build config type form.
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        dump(12345);
        $builder
            // ->add('name', ChoiceType::class, [
            //     'choices'  => [
            //         '選択肢1' => 'Choice 1',
            //         '選択肢2' => 'Choice 2',
            //         '選択肢3' => 'Choice 3',
            //     ],
            //     'expanded' => true,
            //     'multiple' => true,
            // ])
            ->add('name', TextType::class, [
                'label'=> "内容",
                'required' => false,
                
            ])
            ->add('attention', TextType::class, [
                'label'=> "内容",
                'required' => false,
                
            ])
            ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => OrderPlus::class,
        ]);
    }
}
