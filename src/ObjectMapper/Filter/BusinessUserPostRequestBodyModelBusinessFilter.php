<?php

namespace App\ObjectMapper\Filter;

use App\Entity\Business;
use App\Entity\User;
use App\HttpMessageBodyModel\BusinessUserPostRequestBodyModel;
use Opportus\ExtendedFrameworkBundle\EntityGateway\EntityGatewayInterface;
use Opportus\ExtendedFrameworkBundle\EntityGateway\Query\QueryBuilderInterface;
use Opportus\ObjectMapper\Context;
use Opportus\ObjectMapper\Map\Filter\FilterInterface;
use Opportus\ObjectMapper\Map\Route\Route;
use Opportus\ObjectMapper\Map\Route\RouteBuilderInterface;
use Opportus\ObjectMapper\ObjectMapperInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * The business user post request body model business filter.
 *
 * @package App\ObjectMapper\Filter
 * @author  Clément Cazaud <opportus@gmail.com>
 * @license https://github.com/opportus/demo-rest-api/blob/master/LICENSE.md MIT
 */
final class BusinessUserPostRequestBodyModelBusinessFilter implements FilterInterface
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
     * @var RequestStack $requestStack
     */
    private $requestStack;

    /**
     * Constructs the user post request body model business filter.
     *
     * @param RouteBuilderInterface $routeBuilder
     * @param EntityGatewayInterface $entityGateway
     * @param QueryBuilderInterface $queryBuilder
     * @param RequestStack $requestStack
     */
    public function __construct(RouteBuilderInterface $routeBuilder, EntityGatewayInterface $entityGateway, QueryBuilderInterface $queryBuilder, RequestStack $requestStack)
    {
        $this->route = $routeBuilder->buildRoute(BusinessUserPostRequestBodyModel::class.'::$business', User::class.'::__construct()::$business');
        $this->entityGateway = $entityGateway;
        $this->queryBuilder = $queryBuilder;
        $this->requestStack = $requestStack;
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
        $businessId = $this->requestStack->getCurrentRequest()->attributes->get('business_id');

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
