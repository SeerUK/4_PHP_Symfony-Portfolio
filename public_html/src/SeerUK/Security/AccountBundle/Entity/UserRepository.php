<?php

namespace SeerUK\Security\AccountBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

use SeerUK\Portfolio\PortfolioBundle\DependencyInjection\Cache\MemcacheClient;

class UserRepository extends EntityRepository implements UserProviderInterface
{
	public function loadUserByUsername($username)
    {
        $memcacheClient = new MemcacheClient;

        $ck = get_class($this) . '::' . $username;
        $cq = $memcacheClient->get($ck);

        if(!empty($cq))
        {
            $user = $cq;
        }
        else
        {
            $q = $this
                ->createQueryBuilder('u')
                ->where('u.account_name = :username OR u.account_email = :email')
                ->setParameter('username', $username)
                ->setParameter('email', $username)
                ->getQuery()
            ;

            try {
                $user = $q->getSingleResult();
                $memcacheClient->set($ck, $user, 60);
            } catch (NoResultException $e) {
                throw new UsernameNotFoundException(sprintf('Unable to find an active user AcmeUserBundle:User object identified by "%s".', $username), null, 0, $e);
            }
        }

        return $user;
    }

    public function refreshUser(UserInterface $user)
    {
        $class = get_class($user);
        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $class));
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class)
    {
        return $this->getEntityName() === $class || is_subclass_of($class, $this->getEntityName());
    }
}
