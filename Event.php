<?php

namespace Plugin\Test;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Eccube\Event\TemplateEvent;

class Event implements EventSubscriberInterface
{
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'Product/detail.twig' => 'test',
            '@admin/Order/order_pdf.twig' => 'test2',
            '@admin/Product/product.twig' => 'onRenderAdminProduct',

        ];
    }
        /**
     * @param TemplateEvent $event
     */
    public function test(TemplateEvent $event)
    {
        // $parameters = $event->getParameters();
        // $parameters['test'] = "test";
        // $event->setParameters($parameters);
        $event->addSnippet('@Test/default/MatricsCart.twig');
        
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
        $event->addSnippet('@Test/admin/Product/product_detail.twig');
        $event->addSnippet('@Test/admin/Product/product_block.twig');
    }
}
