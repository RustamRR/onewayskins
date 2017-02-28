<?php
/**
 * Created by PhpStorm.
 * User: Рустам
 * Date: 25.02.2017
 * Time: 15:21
 */

namespace Users\Service;

use Doctrine\ORM\EntityManager;
use Users\Entity\Users;
use Zend\Session\Container;

class UsersService
{
    /** @var  EntityManager */
    private $em;

    private $steamauth;

    private $usersRepository;

    private $authService;

    public function __construct(/*$authService, */$usersRepository, $em, $steamauth)
    {
        $this->em = $em;
        $this->steamauth = $steamauth;
        $this->usersRepository = $usersRepository;
        //$this->authService = $authService;
    }

    /**
     * @return mixed
     */
    public function getUsersRepository()
    {
        return $this->usersRepository;
    }

    /**
     * @return EntityManager
     */
    public function getEm()
    {
        return $this->em;
    }

    /**
     * @return
     */
    public function getAuthService()
    {
        return $this->authService;
    }

    public function checkUser($steamData, $guid){
        /** @var Users $user */
        $user = $this->getUsersRepository()->findOneBy(array("steamid" => $steamData["steamid"]));
        if($user){
            $user->setPassword($guid);
            $user->setUserpic($steamData["userpic"]);
            $user->setPersonaname($steamData["personaname"]);
            $this->getEm()->persist($user);
            $this->getEm()->flush($user);
            return $user;
        }else{
            $newUser = $this->createUser($steamData, $guid);
            return $newUser;
        }
    }

    /**
     * @param $steamData
     * @param $guid
     * @return Users
     */
    public function createUser($steamData, $guid){
        $user = new Users();
        $user->fillUserData($steamData, $guid);
        $this->getEm()->persist($user);
        $this->getEm()->flush($user);

        return $user;
    }

    public function steamAuth(){
        try {
            $openid = new OpenidService($this->steamauth['domainname']);

            if(!$openid->mode) {
                $openid->identity = 'http://steamcommunity.com/openid';
                header('Location: ' . $openid->authUrl());
                exit();
            } else {
                if($openid->validate()) {
                    $id = $openid->identity;
                    $ptn = "/^http:\/\/steamcommunity\.com\/openid\/id\/(7[0-9]{15,25}+)$/";
                    preg_match($ptn, $id, $matches);

                    $container = array();

                    $container1 = array();

                    $container1['steamid'] = $matches[1];

                    $url = file_get_contents(sprintf($this->steamauth['player_request_templ'], $this->steamauth['apikey'], $container1['steamid']));
                    $content = json_decode($url, true);


                        $container['steamid'] = $content['response']['players'][0]['steamid'];
                        $container['steam_communityvisibilitystate'] = $content['response']['players'][0]['communityvisibilitystate'];
                        $container['steam_profilestate'] = $content['response']['players'][0]['profilestate'];
                        $container['personaname'] = $content['response']['players'][0]['personaname'];
                        $container['steam_lastlogoff'] = $content['response']['players'][0]['lastlogoff'];
                        $container['profileurl'] = $content['response']['players'][0]['profileurl'];
                        $container['steam_avatar'] = $content['response']['players'][0]['avatar'];
                        $container['userpic'] = $content['response']['players'][0]['avatarmedium'];
                        $container['steam_avatarfull'] = $content['response']['players'][0]['avatarfull'];
                        $container['steam_personastate'] = $content['response']['players'][0]['personastate'];
                        if (isset($content['response']['players'][0]['realname'])) {
                            $container['realname'] = $content['response']['players'][0]['realname'];
                        } else {
                            $container['realname'] = "Real name not given";
                        }
                        $container['primaryclanid'] = $content['response']['players'][0]['primaryclanid'];
                        $container['steam_timecreated'] = $content['response']['players'][0]['timecreated'];
                        $container['steam_uptodate'] = time();

                        return $container;


                    return null;
                } else {
                    return false;
                }

            }
        } catch(\Exception $e) {
            var_dump($e);
        }
    }


}