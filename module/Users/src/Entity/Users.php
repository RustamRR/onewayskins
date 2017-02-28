<?php
/**
 * Created by PhpStorm.
 * User: Рустам
 * Date: 20.02.2017
 * Time: 22:55
 */

namespace Users\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Element\DateTime;

/**
 * @ORM\Entity()
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="UsersRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 *
 * Class Users
 * @package Users\Entity
 */
class Users
{

    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", unique=true, nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="steam_id", type="string", unique=true, nullable=false)
     */
    protected $steamid;
    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", nullable=false)
     */
    protected $password;
    /**
     * @var string
     *
     * @ORM\Column(name="personaname", type="string")
     */
    protected $personaname;
    /**
     * @var string
     *
     * @ORM\Column(name="profileurl", type="string", nullable=false)
     */
    protected $profileurl;
    /**
     * @var string
     *
     * @ORM\Column(name="realname", type="string", nullable=false)
     */
    protected $realname;
    /**
     * @var string
     *
     * @ORM\Column(name="primaryclanid", type="string", nullable=true)
     */
    protected $primaryclanid;
    /**
     * @var string
     *
     * @ORM\Column(name="loccountrycode", type="string", nullable=true)
     */
    protected $loccountrycode;
    /**
     * @var string
     *
     * @ORM\Column(name="locstatecode", type="string", nullable=true)
     */
    protected $locstatecode;
    /**
     * @var string
     *
     * @ORM\Column(name="loccityid", type="string", nullable=true)
     */
    protected $loccityid;
    /**
     * @var DateTime
     *
     * @ORM\Column(name="registration_date", type="datetime", nullable=true)
     */
    protected $registrationDate;
    /**
     * @var string
     *
     * @ORM\Column(name="userpic", type="string")
     */
    protected $userpic;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getLoccityid()
    {
        return $this->loccityid;
    }

    /**
     * @param mixed $loccityid
     */
    public function setLoccityid($loccityid)
    {
        $this->loccityid = $loccityid;
    }

    /**
     * @return mixed
     */
    public function getLoccountrycode()
    {
        return $this->loccountrycode;
    }

    /**
     * @param mixed $loccountrycode
     */
    public function setLoccountrycode($loccountrycode)
    {
        $this->loccountrycode = $loccountrycode;
    }

    /**
     * @return mixed
     */
    public function getLocstatecode()
    {
        return $this->locstatecode;
    }

    /**
     * @param mixed $locstatecode
     */
    public function setLocstatecode($locstatecode)
    {
        $this->locstatecode = $locstatecode;
    }

    /**
     * @return mixed
     */
    public function getPersonaname()
    {
        return $this->personaname;
    }

    /**
     * @param mixed $personaname
     */
    public function setPersonaname($personaname)
    {
        $this->personaname = $personaname;
    }

    /**
     * @return mixed
     */
    public function getPrimaryclanid()
    {
        return $this->primaryclanid;
    }

    /**
     * @param mixed $primaryclanid
     */
    public function setPrimaryclanid($primaryclanid)
    {
        $this->primaryclanid = $primaryclanid;
    }

    /**
     * @return mixed
     */
    public function getProfileurl()
    {
        return $this->profileurl;
    }

    /**
     * @param mixed $profileurl
     */
    public function setProfileurl($profileurl)
    {
        $this->profileurl = $profileurl;
    }

    /**
     * @return mixed
     */
    public function getRealname()
    {
        return $this->realname;
    }

    /**
     * @param mixed $realname
     */
    public function setRealname($realname)
    {
        $this->realname = $realname;
    }

    /**
     * @return DateTime
     */
    public function getRegistrationDate()
    {
        return $this->registrationDate;
    }

    /**
     * @param DateTime $registrationDate
     */
    public function setRegistrationDate($registrationDate)
    {
        $this->registrationDate = $registrationDate;
    }

    /**
     * @return string
     */
    public function getUserpic()
    {
        return $this->userpic;
    }

    /**
     * @param string $userpic
     */
    public function setUserpic($userpic)
    {
        $this->userpic = $userpic;
    }

    /**
     * @return mixed
     */
    public function getSteamid()
    {
        return $this->steamid;
    }

    /**
     * @param mixed $steamid
     */
    public function setSteamid($steamId)
    {
        $this->steamid = $steamId;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function fillUserData($steamData, $guid){
        $this->setPassword($guid);
        /*foreach ($steamData as $key => $value){
            $prop = "set".ucfirst($key);
            var_dump($prop);
            //$this->$prop.($value);
        }
        die();*/
        $this->setSteamid($steamData["steamid"]);
        $this->setUserpic($steamData["userpic"]);
        $this->setProfileurl($steamData["profileurl"]);
        //$this->setLoccityid($steamData["steamid"]);
        //$this->setLoccountrycode($steamData["steamid"]);
        $this->setRealname($steamData["realname"]);
        $this->setPersonaname($steamData["personaname"]);
        $this->setRegistrationDate(new \DateTime());
    }
}