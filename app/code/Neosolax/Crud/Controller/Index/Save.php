<?php

namespace Neosolax\Crud\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Neosolax\Crud\Model\PostFactory;

class Save extends Action
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
        $postData = $this->postFactory->create();

        if ($data) {
            $postData = [
                'firstName' => $data['fname'],
                'lastName' => $data['lname'],
                'dob' => $data['dob'],
                'startDate' => $data['st_date'],
                'contact' => $data['contact']
            ];

            $this->postFactory->create()->setData($postData)->save();
            $resultRedirect = $this->resultRedirectFactory->create();
            $resultRedirect->setPath('crud/index/index/');
            return $resultRedirect;
        }

        return $this->pageFactory->create();
    }
//    public function execute()
//    {
//        $post = $this->getRequest()->getParams();
//
//        if (!empty($post)) {
//            try {
//                $firstname = $post['firstname'];
//                $lastname = $post['lastname'];
//                $dob = $post['dob'];
//                $salary = $post['salary'];
//
//                $this->employee->setFirstName($firstname);
//                $this->employee->setLastName($lastname);
//                $this->employee->setDob($dob);
//                $this->employee->setSalary($salary);
//                $this->employee->save();
//            } catch (\Exception $e) {
//                $this->messageManager->addErrorMessage($e->getMessage());
////                throw new Exception($e->getMessage());
//            }
//
//            $this->messageManager->addSuccessMessage('Registration Done !');
//
//            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
//            $resultRedirect->setUrl('/employee/');
//
//            return $resultRedirect;
//        }
//        $this->_view->loadLayout();
//        $this->_view->renderLayout();
//    }


}
