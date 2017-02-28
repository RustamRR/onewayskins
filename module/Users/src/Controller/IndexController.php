<?php

namespace Users\Controller;

use Application\Utils\UuidGenerator;
use Users\Entity\Users;
use Users\Form\UsersForm;
use Users\Service\OpenidService;
use Users\Service\UsersService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\ServiceManager\ServiceManager;
use Zend\Session\Container;
use Zend\Session\SessionManager;

class IndexController extends AbstractActionController
{

    protected $steamauth;
    /** @var  UsersService */
    protected $usersService;

    public function __construct($usersService)
    {
        $this->usersService = $usersService;
    }

    public function indexAction()
    {
        $params = $this->params()->fromQuery();

        $authData = $this->usersService->steamAuth();
        $password = UuidGenerator::generateUuid();

        if(!is_null($authData)){
            $user = $this->usersService->checkUser($authData, $password);
        }
        /** @var UsersForm $form */
        $form = $this->getServiceLocator()
            ->get('formElementManager')
            ->get(UsersForm::class);
        $form->setHydrator(new \Zend\Stdlib\Hydrator\ObjectProperty());
        $form->bind(new Users());

        $authData['password'] = $password;

        $form->setData([
            "auth" => $authData,
        ]);

        if($form->isValid()){
            $data = $authData;

            /** @var \Zend\Authentication\AuthenticationService $authService */
            $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
            /** @var \DoctrineModule\Authentication\Adapter\ObjectRepository $adapter */
            $adapter = $authService->getAdapter();
//            $class_methods = get_class_methods($adapter);
//            echo "<pre>";print_r($class_methods);exit;
            $adapter->setIdentity($data["steamid"]);
            $adapter->setCredential($data["password"]);

            $authResult = $authService->authenticate();
            if($authResult->isValid()){
                $identity = $authResult->getIdentity();
                $authService->getStorage()->write($identity);
                return $this->redirect()->toRoute('application');
            }else{
                $messages = $authResult->getMessages();
                var_dump($messages);die();
            }
        }else{
            $messages = $form->getMessages();
            var_dump($messages);
        }

        if($authData){
            return $this->redirect()->toRoute('application');
        }

        return $this->redirect()->toRoute('application');
    }

    public function logoutAction(){
        $auth = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');

        if($auth->hasIdentity()){
            /**
             * Если верить документации доктрины, то тут должен располагаться
             * экземпляр Users\Entity\Users
             */
            $identity = $auth->getIdentity();
        }

        $auth->clearIdentity();

        $sessionManager = new SessionManager();
        $sessionManager->forgetMe();

        return $this->redirect()->toRoute('application');
    }

    public function myAction(){
        return array();
    }

    public function fooAction()
    {
        // This shows the :controller and :action parameters in default route
        // are working when you browse to /module-specific-root/skeleton/foo
        return array();
    }
}

