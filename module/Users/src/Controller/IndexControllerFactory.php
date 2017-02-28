<?php
/**
 * Created by PhpStorm.
 * User: Рустам
 * Date: 20.02.2017
 * Time: 22:57
 */

namespace Users\Controller;


use Users\Service\UsersService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class IndexControllerFactory implements FactoryInterface
{

    protected $steamauth;
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {

        $parentLocator = $serviceLocator->getServiceLocator();

        $usersService = $parentLocator->get(UsersService::class);

        return new IndexController($usersService);
    }
}