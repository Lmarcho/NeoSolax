<?php

namespace Neosolax\Crud\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Neosolax\Crud\Model\PostFactory;

class Edit extends Action
{
    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        PostFactory $postFactory
    ) {
        $this->postFactory = $postFactory;
        $this->pageFactory = $pageFactory;
        return parent::__construct($context);
    }

    public function execute()
    {
        $data = $this->getRequest()->getParams();

        if (isset($data['employee_id'])) {
            $post = $this->postFactory->create()->load($data['employee_id']);

            $postData = [
                'employee_id' => $data['employee_id'],
                'firstName' => $data['fname'],
                'lastName' => $data['lname'],
                'dob' => $data['dob'],
                'startDate' => $data['st_date'],
                'contact' => $data['contact']
            ];

            $post->setData($postData)->save();
            $resultRedirect = $this->resultRedirectFactory->create();
            $resultRedirect->setPath('crud/index/index/');
            return $resultRedirect;
        }

        return $this->pageFactory->create();
    }
}
