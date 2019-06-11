<?php

namespace App\ObjectMapper\Filter;

use App\Entity\User;
use App\HttpMessageBodyModel\UserBusinessResponseBodyModel;
use App\HttpMessageBodyModel\UserResponseBodyModel;
use Opportus\ObjectMapper\Context;
use Opportus\ObjectMapper\Map\Filter\FilterInterface;
use Opportus\ObjectMapper\Map\Route\Route;
use Opportus\ObjectMapper\Map\Route\RouteBuilderInterface;
use Opportus\ObjectMapper\ObjectMapperInterface;

/**
 * The user business recursion filter.
 *
 * @package App\ObjectMapper\Filter
 * @author  Clément Cazaud <opportus@gmail.com>
 * @license https://github.com/opportus/demo-rest-api/blob/master/LICENSE.md MIT
 */
final class UserBusinessRecursionFilter implements FilterInterface
{
    /**
     * @var Route $route
     */
    private $route;

    /**
     * Constructs the user business recursion.
     *
     * @param RouteBuilderInterface $routeBuilder
     */
    public function __construct(RouteBuilderInterface $routeBuilder)
    {
        $this->route = $routeBuilder->buildRoute(User::class.'::getBusiness()', UserResponseBodyModel::class.'::$business');
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
        $source = $this->route->getSourcePoint()->getValue($context->getSource());
        $target = UserBusinessResponseBodyModel::class;
        $map = $context->getMap();

        return $objectMapper->map($source, $target, $map);
    }
}
