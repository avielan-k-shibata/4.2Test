<?php
namespace Plugin\Test\Form\Extension;
 
use Eccube\Form\Type\SearchProductType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
 
class TestSearchProductTypeExtension extends AbstractTypeExtension
{ 
     /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('tag_id', HiddenType::class, []);
        $builder->add('color', HiddenType::class, []);
        $builder->add('maker', HiddenType::class, []);
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return SearchProductType::class;
    }
    /**
     * {@inheritdoc}
     */
    public static function getExtendedTypes(): iterable
    {
        yield SearchProductType::class;
    }
}