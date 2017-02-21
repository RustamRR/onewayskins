<?php
/**
 * Created by PhpStorm.
 * User: Рустам
 * Date: 20.02.2017
 * Time: 22:57
 */

namespace Users\Controller;


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
        $config = $parentLocator->get('Config');
        $this->steamauth['apikey'] = $config['steam']['api_key']; // Your Steam WebAPI-Key found at http://steamcommunity.com/dev/apikey
        $this->steamauth['domainname'] = $config['base_domain']; // The main URL of your website displayed in the login page
        $this->steamauth['logoutpage'] = "logout"; // Page to redirect to after a successfull logout (from the directory the SteamAuth-folder is located in) - NO slash at the beginning!
        $this->steamauth['loginpage'] = "my/my";

        return new IndexController($this->steamauth);
    }
}