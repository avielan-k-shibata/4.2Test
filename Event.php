<?php

namespace Plugin\Test;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Eccube\Event\TemplateEvent;
use Eccube\Entity\Block;
use Eccube\Entity\Product;
use Eccube\Repository\ProductRepository;

use Eccube\Repository\BlockRepository;
use Eccube\Repository\CategoryRepository;

class Event implements EventSubscriberInterface
{
    /**
     * @return array
     */

    /**
     * @var BlockRepository
     */
    protected $blockRepository;
    /**
     * @var ProductRepository
     */
    protected $productRepository;
    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;

    public function __construct(
        BlockRepository $blockRepository,
        ProductRepository $productRepository,
        CategoryRepository $categoryRepository
    ){
        $this->blockRepository = $blockRepository;
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;

    }

    public static function getSubscribedEvents()
    {
        return [
            'Product/detail.twig' => 'productDetail',
            '@admin/Order/order_pdf.twig' => 'test2',
            '@admin/Product/product.twig' => 'onRenderAdminProduct',
            '@admin/Product/category.twig' => 'onRenderAdminCategory',
        ];
    }
        /**
     * @param TemplateEvent $event
     */
    public function productDetail(TemplateEvent $event)
    {
        $parameters = $event->getParameters();
        $BlocksList = $this->blockRepository->getList(10);
        $parameters['BlocksList'] = $BlocksList;
        $parameters['Blocks'] = "";
        if($parameters["Product"]["id"]){
            $Product = $this->productRepository->findWithSortedClassCategories($parameters["Product"]["id"]);
            $parameters['Blocks'] = $Product->getBlocks();
        }
        $event->setParameters($parameters);

        $event->addSnippet('@Test/default/MatricsCart.twig');
        $event->addSnippet('@Test/default/product_block.twig');
        $event->addSnippet('@Test/default/category_block.twig');

    }
    public function test2(TemplateEvent $event)
    {
        // $parameters = $event->getParameters();
        // $parameters['test'] = "test";
        // $event->setParameters($parameters);
        $event->addSnippet('@Test/admin/Order/order_pdf_select.twig');

    }

        /**
     * 管理画面：商品登録画面に商品詳細フォームを表示する.
     *
     * @param TemplateEvent $event
     */
    public function onRenderAdminProduct(TemplateEvent $event)
    {
        $parameters = $event->getParameters();
        $BlocksList = $this->blockRepository->getList(10);
        $parameters['BlocksList'] = $BlocksList;
        $parameters['Blocks'] = "";
        if($parameters["Product"]["id"]){
            $Product = $this->productRepository->findWithSortedClassCategories($parameters["Product"]["id"]);
            $parameters['Blocks'] = $Product->getBlocks();
        }
        $event->setParameters($parameters);
        $event->addSnippet('@Test/admin/Product/product_detail.twig');
        $event->addSnippet('@Test/admin/Product/product_block.twig');
    }

    public function onRenderAdminCategory(TemplateEvent $event)
    {
        $parameters = $event->getParameters();
        $BlocksList = $this->blockRepository->getList(10);
        $parameters['BlocksList'] = $BlocksList;
        $parameters['Blocks'] = "";
        if($parameters["TargetCategory"]["Parent"]){
            $Category = $this->categoryRepository->find($parameters["TargetCategory"]["Parent"]["id"]);
            $parameters['Blocks'] = $Category->getBlocks();

            $event->setParameters($parameters);
            $event->addSnippet('@Test/admin/Product/category_block.twig');
        }
    }
}
