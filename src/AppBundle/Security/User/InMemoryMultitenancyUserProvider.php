<?php

namespace AppBundle\Security\User;

use AppBundle\Entity\User;
use STK\MultitenancyAuthBundle\Security\Exception\Security\User\TenantNotFoundException;
use STK\MultitenancyAuthBundle\Security\User\MultitenancyUserInterface;
use STK\MultitenancyAuthBundle\Security\User\MultitenancyUserProviderInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;

class InMemoryMultitenancyUserProvider implements MultitenancyUserProviderInterface
{
    private $tenants = [
        ['1', 'tenant1'],
        ['2', 'tenant2'],
    ];
    
    private $users = [
        ['1', '1', 'user1', '12345'],
        ['2', '2', 'user2', '54321'],
    ];
    
    /**
     * Loads the user for the given username.
     *
     * This method must throw UsernameNotFoundException if the user is not
     * found.
     *
     * @param string $tenant The tenant
     * @param string $username The username
     *
     * @return MultitenancyUserInterface
     *
     * @throws TenantNotFoundException if the tenant is not found
     * @throws UsernameNotFoundException if the user is not found
     */
    public function loadUserByTenantAndUsername($tenant, $username)
    {
        $foundTenant = array_filter($this->tenants, function($currentTenant) use ($tenant) {
            return $currentTenant[1] === $tenant;
        });
        
        if (count($foundTenant) === 0) {
            throw new TenantNotFoundException();
        }
        $foundTenant = current($foundTenant);

        $foundUser = array_filter($this->users, function($currentUser) use ($foundTenant, $username) {
            return $currentUser[1] === $foundTenant[0] and $currentUser[2] === $username;
        });


        if (count($foundUser) === 0) {
            throw new UsernameNotFoundException();
        }

        $user = current($foundUser);

        return new User($user[0], $foundTenant[1], $user[2], $user[3]);
    }

    /**
     * Loads the user for the given username.
     *
     * This method must throw UsernameNotFoundException if the user is not
     * found.
     *
     * @param string $username The username
     *
     * @return UserInterface
     *
     * @throws UsernameNotFoundException if the user is not found
     */
    public function loadUserByUsername($username)
    {
        // TODO: Implement loadUserByUsername() method.
    }

    /**
     * Refreshes the user for the account interface.
     *
     * It is up to the implementation to decide if the user data should be
     * totally reloaded (e.g. from the database), or if the UserInterface
     * object can just be merged into some internal array of users / identity
     * map.
     *
     * @param UserInterface $user
     *
     * @return UserInterface
     *
     * @throws UnsupportedUserException if the account is not supported
     */
    public function refreshUser(UserInterface $user)
    {
        // TODO: Implement refreshUser() method.
    }

    /**
     * Whether this provider supports the given user class.
     *
     * @param string $class
     *
     * @return bool
     */
    public function supportsClass($class)
    {
        // TODO: Implement supportsClass() method.
    }
}