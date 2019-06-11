<?php

namespace App\ObjectMapper\Filter;

use App\Entity\Business;
use App\HttpMessageBodyModel\BusinessResponseBodyModel;
use App\HttpMessageBodyModel\BusinessUserResponseBodyModel;
use Opportus\ObjectMapper\Context;
use Opportus\ObjectMapper\Map\Filter\FilterInterface;
use Opportus\ObjectMapper\Map\Route\Route;
use Opportus\ObjectMapper\Map\Route\RouteBuilderInterface;
use Opportus\ObjectMapper\ObjectMapperInterface;

/**
 * The business users recursion filter.
 *
 * @package App\ObjectMapper\Filter
 * @author  Clément Cazaud <opportus@gmail.com>
 * @license https://github.com/opportus/demo-rest-api/blob/master/LICENSE.md MIT
 */
final class BusinessUsersRecursionFilter implements FilterInterface
{
    /**
     * @var Route $route
     */
    private $route;

    /**
     * Constructs the business users recursion filter.
     *
     * @param RouteBuilderInterface $routeBuilder
     */
    public function __construct(RouteBuilderInterface $routeBuilder)
    {
        $this->route = $routeBuilder->buildRoute(Business::class.'::getUsers()', BusinessResponseBodyModel::class.'::$users');
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
        $sources = $this->route->getSourcePoint()->getValue($context->getSource());

        $businessUsers = [];

        foreach ($sources as $source) {
            $businessUsers[] = $objectMapper->map($source, BusinessUserResponseBodyModel::class, $context->getMap());
        }

        return $businessUsers;
    }
}
