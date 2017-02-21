<?php

namespace Users\Controller;

use Users\Service\OpenidService;
use Zend\Mvc\Controller\AbstractActionController;

class IndexController extends AbstractActionController
{

    protected $steamauth;

    public function __construct($steamauth)
    {
        $this->steamauth = $steamauth;
    }

    public function indexAction()
    {
        $params = $this->params()->fromQuery();
        
        try {
            //require 'SteamConfig.php';
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

                    $_SESSION['steamid'] = $matches[1];
                    if (empty($_SESSION['steam_uptodate']) or empty($_SESSION['steam_personaname'])) {
                        //require 'SteamConfig.php';
                        $url = file_get_contents("http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=".$this->steamauth['apikey']."&steamids=".$_SESSION['steamid']);
                        $content = json_decode($url, true);
                        $_SESSION['steam_steamid'] = $content['response']['players'][0]['steamid'];
                        $_SESSION['steam_communityvisibilitystate'] = $content['response']['players'][0]['communityvisibilitystate'];
                        $_SESSION['steam_profilestate'] = $content['response']['players'][0]['profilestate'];
                        $_SESSION['steam_personaname'] = $content['response']['players'][0]['personaname'];
                        $_SESSION['steam_lastlogoff'] = $content['response']['players'][0]['lastlogoff'];
                        $_SESSION['steam_profileurl'] = $content['response']['players'][0]['profileurl'];
                        $_SESSION['steam_avatar'] = $content['response']['players'][0]['avatar'];
                        $_SESSION['steam_avatarmedium'] = $content['response']['players'][0]['avatarmedium'];
                        $_SESSION['steam_avatarfull'] = $content['response']['players'][0]['avatarfull'];
                        $_SESSION['steam_personastate'] = $content['response']['players'][0]['personastate'];
                        if (isset($content['response']['players'][0]['realname'])) {
                            $_SESSION['steam_realname'] = $content['response']['players'][0]['realname'];
                        } else {
                            $_SESSION['steam_realname'] = "Real name not given";
                        }
                        $_SESSION['steam_primaryclanid'] = $content['response']['players'][0]['primaryclanid'];
                        $_SESSION['steam_timecreated'] = $content['response']['players'][0]['timecreated'];
                        $_SESSION['steam_uptodate'] = time();
                    }
                    $steamprofile['steamid'] = $_SESSION['steam_steamid'];
                    $steamprofile['communityvisibilitystate'] = $_SESSION['steam_communityvisibilitystate'];
                    $steamprofile['profilestate'] = $_SESSION['steam_profilestate'];
                    $steamprofile['personaname'] = $_SESSION['steam_personaname'];
                    $steamprofile['lastlogoff'] = $_SESSION['steam_lastlogoff'];
                    $steamprofile['profileurl'] = $_SESSION['steam_profileurl'];
                    $steamprofile['avatar'] = $_SESSION['steam_avatar'];
                    $steamprofile['avatarmedium'] = $_SESSION['steam_avatarmedium'];
                    $steamprofile['avatarfull'] = $_SESSION['steam_avatarfull'];
                    $steamprofile['personastate'] = $_SESSION['steam_personastate'];
                    $steamprofile['realname'] = $_SESSION['steam_realname'];
                    $steamprofile['primaryclanid'] = $_SESSION['steam_primaryclanid'];
                    $steamprofile['timecreated'] = $_SESSION['steam_timecreated'];
                    $steamprofile['uptodate'] = $_SESSION['steam_uptodate'];

                    print "<pre>";
                    var_dump($_SESSION); die();
                    var_dump($content);die();

                    /*$_SESSION['steamid'] = $matches[1];
                    if (!headers_sent()) {
                        header('Location: '.$this->steamauth['loginpage']);
                        exit;
                    } else {
                        ?>
                        <script type="text/javascript">
                            window.location.href="<?=$this->steamauth['loginpage']?>";
                        </script>
                        <noscript>
                            <meta http-equiv="refresh" content="0;url=<?=$this->steamauth['loginpage']?>" />
                        </noscript>
                        <?php
                        exit;
                    }*/
                } else {
                    print "<pre>";
                    var_dump($openid);
                    //echo "User is not logged in.\n";
                }

            }
        } catch(\Exception $e) {
            var_dump($e);
        }
        return array();
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
