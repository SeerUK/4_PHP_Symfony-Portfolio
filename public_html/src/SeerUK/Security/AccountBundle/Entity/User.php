<?php

namespace SeerUK\Security\AccountBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * SeerUK\Security\AccountBundle\Entity\User
 *
 * @ORM\Table(name="account")
 * @ORM\Entity(repositoryClass="SeerUK\Security\AccountBundle\Entity\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $account_id;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $account_name;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $account_salt;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $account_password;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $account_email;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    public function __construct()
    {
        $this->isActive = true;
        $this->account_salt = '';
    }

    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->account_name;
    }

    /**
     * @inheritDoc
     */
    public function setUsername($username)
    {
    	$this->account_name = $username;
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        return $this->account_salt;
    }

    /**
     * @inheritDoc
     */
    public function setSalt($salt)
    {
    	$this->account_salt = $salt;
    }

    /**
     * @inheritDoc
     */
    public function getPassword()
    {
        return $this->account_password;
    }

    /**
     * @inheritcDoc
     */
    public function setPassword($password)
    {
    	$this->account_password = $password;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return array('ROLE_USER');
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
    }

    /**
     * @inheritDoc
     */
    public function equals(UserInterface $user)
    {
        return $this->account_name === $user->getUsername();
    }
}
