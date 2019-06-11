<?php

namespace App\Security;

use App\Entity\User;
use Exception;
use Opportus\ExtendedFrameworkBundle\EntityGateway\EntityGatewayInterface;
use Opportus\ExtendedFrameworkBundle\EntityGateway\Query\QueryBuilderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

/**
 * The user provider.
 *
 * @package App\Security
 * @author  Clément Cazaud <opportus@gmail.com>
 * @license https://github.com/opportus/demo-rest-api/blob/master/LICENSE.md MIT
 */
class UserProvider implements UserProviderInterface
{
    /**
     * @var EntityGatewayInterface $entityGateway
     */
    private $entityGateway;

    /**
     * @var QueryBuilderInterface $queryBuilder
     */
    private $queryBuilder;

    /**
     * Constructs the user provider.
     *
     * @param EntityGatewayInterface $entityGateway
     * @param QueryBuilderInterface $queryBuilder
     */
    public function __construct(EntityGatewayInterface $entityGateway, QueryBuilderInterface $queryBuilder)
    {
        $this->entityGateway = $entityGateway;
        $this->queryBuilder = $queryBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByUsername($username)
    {
        try {
            $query = $this->queryBuilder
                ->prepareQuery()
                ->setEntityFqcn(User::class)
                ->setCriteria(\sprintf('username = "%s"', $username))
                ->build()
            ;

            $queryResult = $this->entityGateway->query($query);
        } catch (Exception $exception) {
            throw $exception;
            throw new UsernameNotFoundException(\sprintf('Username "%s" could not be found.', $username));
        }

        if ($queryResult->isEmpty()) {
            throw new UsernameNotFoundException(\sprintf('Username "%s" could not be found.', $username));
        }

        return $queryResult[0];
    }

    /**
     * {@inheritdoc}
     */
    public function refreshUser(UserInterface $user)
    {
        $userClass = \get_class($user);

        if (false === $this->supportsClass($userClass)) {
            throw new UnsupportedUserException(\sprintf('Expected an instance of type "%s", got an instance of type "%s"', User::class, $userClass));
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    /**
     * {@inheritdoc}
     */
    public function supportsClass($class)
    {
        return $class === User::class;
    }
}
