<?php
/**
 * Created by PhpStorm.
 * User: Рустам
 * Date: 25.02.2017
 * Time: 15:22
 */

namespace Users\Service;


use Doctrine\ORM\EntityManager;
use Users\Entity\Users;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UsersServiceFactory implements FactoryInterface
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
        /** @var EntityManager $em */
        $em = $serviceLocator->get('doctrine.entitymanager.orm_default');
        
        $usersRepository = $em->getRepository(Users::class);

        //$authService = $serviceLocator->get('Zend\Authentication\AuthenticationService');
        $config = $serviceLocator->get('Config');
        $this->steamauth['apikey'] = $config['steam']['api_key']; // Your Steam WebAPI-Key found at http://steamcommunity.com/dev/apikey
        $this->steamauth['domainname'] = $config['base_domain']; // The main URL of your website displayed in the login page
        $this->steamauth['player_request_templ'] = $config['steam']['player_request_templ'];
        $this->steamauth['logoutpage'] = "logout"; // Page to redirect to after a successfull logout (from the directory the SteamAuth-folder is located in) - NO slash at the beginning!
        $this->steamauth['loginpage'] = "my/my";

        return new UsersService(/*$authService, */$usersRepository, $em, $this->steamauth);
    }
}