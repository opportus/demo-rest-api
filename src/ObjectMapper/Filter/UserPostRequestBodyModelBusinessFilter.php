<?php

namespace App\ObjectMapper\Filter;

use App\Entity\Business;
use App\Entity\User;
use App\HttpMessageBodyModel\UserPostRequestBodyModel;
use Opportus\ExtendedFrameworkBundle\EntityGateway\EntityGatewayInterface;
use Opportus\ExtendedFrameworkBundle\EntityGateway\Query\QueryBuilderInterface;
use Opportus\ObjectMapper\Context;
use Opportus\ObjectMapper\Map\Filter\FilterInterface;
use Opportus\ObjectMapper\Map\Route\Route;
use Opportus\ObjectMapper\Map\Route\RouteBuilderInterface;
use Opportus\ObjectMapper\ObjectMapperInterface;

/**
 * The user post request body model business filter.
 *
 * @package App\ObjectMapper\Filter
 * @author  Clément Cazaud <opportus@gmail.com>
 * @license https://github.com/opportus/demo-rest-api/blob/master/LICENSE.md MIT
 */
final class UserPostRequestBodyModelBusinessFilter implements FilterInterface
{
    /**
     * @var Route $route
     */
    private $route;

    /**
     * @var EntityGatewayInterface $entityGateway
     */
    private $entityGateway;

    /**
     * @var QueryBuilderInterface $queryBuilder
     */
    private $queryBuilder;

    /**
     * Constructs the user post request body model business filter.
     *
     * @param RouteBuilderInterface $routeBuilder
     * @param EntityGatewayInterface $entityGateway
     * @param QueryBuilderInterface $queryBuilder
     */
    public function __construct(RouteBuilderInterface $routeBuilder, EntityGatewayInterface $entityGateway, QueryBuilderInterface $queryBuilder)
    {
        $this->route = $routeBuilder->buildRoute(UserPostRequestBodyModel::class.'::$business', User::class.'::__construct()::$business');
        $this->entityGateway = $entityGateway;
        $this->queryBuilder = $queryBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function getRouteFqn(): string
    {
        return $this->route->getFqn();
    }

    /**
     * {@inheritdoc}
     */
    public function getValue(Context $context, ObjectMapperInterface $objectMapper)
    {
        $businessId = $this->route->getSourcePoint()->getValue($context->getSource());

        $query = $this->queryBuilder
            ->prepareQuery()
            ->setEntityFqcn(Business::class)
            ->setCriteria(\sprintf('id = "%s"', $businessId))
            ->build()
        ;

        $queryResult = $this->entityGateway->query($query);

        return $queryResult[0];
    }
}
