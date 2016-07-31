<?php

namespace AppBundle\Entity;

use STK\MultitenancyAuthBundle\Security\User\MultitenancyUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class User implements MultitenancyUserInterface
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $tenant;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @param string $id
     * @param string $tenant
     * @param string $username
     * @param string $password
     */
    public function __construct($id, $tenant, $username, $password)
    {
        $this->id = $id;
        $this->tenant = $tenant;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getTenant()
    {
        return $this->tenant;
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return null
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }


    public function eraseCredentials()
    {
        unset($this->password);
    }
}
