<?php
namespace NeoSolax\WhatThreeWords\Observer;

class SaveWhatThreeWordsInOrder implements \Magento\Framework\Event\ObserverInterface
{
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();
        $quote = $observer->getEvent()->getQuote();
        if ($quote->getBillingAddress()) {
            $order->getBillingAddress()->setWhatThreeWords($quote->getBillingAddress()->getExtensionAttributes()->getWhatThreeWords());
        }
        if (!$quote->isVirtual()) {
            $order->getShippingAddress()->setWhatThreeWords($quote->getShippingAddress()->getWhatThreeWords());
        }
        return $this;
    }
}
