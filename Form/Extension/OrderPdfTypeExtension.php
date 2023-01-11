<?php
namespace Plugin\Test\Form\Extension;
 
use Eccube\Form\Type\Admin\OrderPdfType;
use Eccube\Common\EccubeConfig;

use Symfony\Component\Form\AbstractTypeExtension;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;
 
class OrderPdfTypeExtension extends AbstractTypeExtension
{ 
     /**
     * {@inheritdoc}
     */
    /** @var EccubeConfig */
    private $eccubeConfig;
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $config = $this->eccubeConfig;

        $builder->add('download_kind2', TextType::class, [
            'required' => false,
        ]);
        $builder->add('title2', TextType::class, [
            'required' => false,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return OrderPdfType::class;
    }
    /**
     * {@inheritdoc}
     */
    public static function getExtendedTypes(): iterable
    {
        yield OrderPdfType::class;
    }
}