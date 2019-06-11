<?php

namespace App\Generator\Strategy;

use App\HttpMessageBodyModel\VndErrorResponseBodyModel;
use Hateoas\Representation\CollectionRepresentation;
use JMS\Serializer\SerializerInterface;
use Opportus\ExtendedFrameworkBundle\Generator\Configuration\AbstractViewConfiguration;
use Opportus\ExtendedFrameworkBundle\Generator\Configuration\SerializedData as SerializedDataConfiguration;
use Opportus\ExtendedFrameworkBundle\Generator\Context\ControllerResultInterface;
use Opportus\ExtendedFrameworkBundle\Generator\Context\ControllerException;
use Opportus\ExtendedFrameworkBundle\Generator\GeneratorException;
use Opportus\ExtendedFrameworkBundle\Generator\Strategy\ViewStrategyInterface;
use Opportus\ExtendedFrameworkBundle\DataFetcher\DataFetcherInterface;
use Opportus\ExtendedFrameworkBundle\EntityGateway\Query\QueryResult;
use Opportus\ObjectMapper\ObjectMapperInterface;
use StdClass;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolationList;

/**
 * The HAL serialized data strategy.
 *
 * @package App\Generator\Strategy
 * @author  Clément Cazaud <opportus@gmail.com>
 * @license https://github.com/opportus/demo-rest-api/blob/master/LICENSE.md MIT
 */
final class HalSerializedDataStrategy implements ViewStrategyInterface
{
    /**
     * @var SerializerInterface $serializerInterface
     */
    private $serializer;

    /**
     * @var DataFetcherInterface $dataFetcher
     */
    private $dataFetcher;

    /**
     * @var ObjectMapperInterface $objectMapper
     */
    private $objectMapper;

    /**
     * Constructs the serialized data strategy.
     *
     * @param SerializerInterface $serializerInterface
     * @param DataFetcherInterface $dataFetcher
     * @param ObjectMapperInterface $objectMapper
     */
    public function __construct(SerializerInterface $serializer, DataFetcherInterface $dataFetcher, ObjectMapperInterface $objectMapper)
    {
        $this->serializer = $serializer;
        $this->dataFetcher = $dataFetcher;
        $this->objectMapper = $objectMapper;
    }

    /**
     * {@inheritdoc}
     */
    public function generate(AbstractViewConfiguration $viewConfiguration, ControllerResultInterface $controllerResult, Request $request): string
    {
        if (false === $this->supports($viewConfiguration, $controllerResult, $request)) {
            throw new GeneratorException(\sprintf(
                '"%s" does not support the view configuration within the current context.',
                self::class
            ));
        }

        $accessor = $viewConfiguration->getAccessor();

        if (null === $accessor) {
            $data = $controllerResult->getData();
        } else {
            $data = $this->dataFetcher->fetch($accessor, $controllerResult->getData());
        }

        $data = $data ?? new StdClass();
        $format = $this->getSerializationFormat($viewConfiguration, $request);
        $serializationFqcn = $viewConfiguration->getSerializationFqcn();

        if (\is_object($data)) {
            if ($data instanceof QueryResult) {
                if (null === $serializationFqcn) {
                    $data = new CollectionRepresentation($data->toArray());
                } else {
                    $serializableItems = [];

                    foreach ($data as $entity) {
                        $serializableItems[] = $this->objectMapper->map($entity, $serializationFqcn);
                    }

                    $data = new CollectionRepresentation($serializableItems);
                }
            } elseif ($data instanceof ConstraintViolationList) {
                $errors = [];

                foreach ($data as $constraintViolation) {
                    $errors[] = $this->objectMapper->map($constraintViolation, VndErrorResponseBodyModel::class);
                }

                if (1 < \count($errors)) {
                    $data = new CollectionRepresentation($errors);
                } else {
                    $data = $errors[0];
                }
            } elseif (null !== $serializationFqcn) {
                $data = $this->objectMapper->map($data, $serializationFqcn);
            }
        }

        return $this->serializer->serialize($data, $format);
    }

    /**
     * {@inheritdoc}
     */
    public function supports(AbstractViewConfiguration $viewConfiguration, ControllerResultInterface $controllerResult, Request $request): bool
    {
        if (!$viewConfiguration instanceof SerializedDataConfiguration) {
            return false;
        }

        return 'application/hal+json' === $viewConfiguration->getFormat() || 'application/hal+xml' === $viewConfiguration->getFormat();

        if (self::class !== $viewConfiguration->getStrategyFqcn()) {
            return false;
        }

        return true;
    }

    /**
     * Gets the serialization format.
     *
     * @param AbstractViewConfiguration $viewConfiguration
     * @param Request $request
     * @return string
     */
    private function getSerializationFormat(AbstractViewConfiguration $viewConfiguration, Request $request): string
    {
        switch ($viewConfiguration->getFormat()) {
            case 'application/hal+json':
                return 'json';
            case 'application/hal+xml':
                return 'xml';
        }
    }
}
