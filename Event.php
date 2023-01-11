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
}
