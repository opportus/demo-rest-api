<?php

namespace App\Controller;

use App\Entity\User;
use App\HttpMessageBodyModel\UserPostRequestBodyModel;
use App\HttpMessageBodyModel\UserResponseBodyModel;
use App\HttpMessageBodyModel\VndErrorResponseBodyModel;
use App\Validator\Constraints\UserCollectionQuery;
use Opportus\ExtendedFrameworkBundle\DataFetcher\Accessor as DataFetching;
use Opportus\ExtendedFrameworkBundle\EntityGateway\Query\QueryResultInterface;
use Opportus\ExtendedFrameworkBundle\Generator\Configuration as Generation;
use Opportus\ExtendedFrameworkBundle\Generator\Context\ControllerResult;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * The user controller.
 *
 * @package App\Controller
 * @author  Clément Cazaud <opportus@gmail.com>
 * @license https://github.com/opportus/demo-rest-api/blob/master/LICENSE.md MIT
 */
class UserController
{
    use ControllerTrait;

    /**
     * Gets a collection of users.
     *
     * @param QueryResultInterface $data
     * @return ControllerResult
     *
     * @Route("/users", name="cget_user", methods={"GET"}, defaults={"_format"="json"}, requirements={"_format"="json"})
     *
     * @Security("user.getBusiness().getName() == 'BileMo'")
     *
     * @Generation\EntityCollection(
     *     entityFqcn=User::class,
     *     queryConstraintFqcn=UserCollectionQuery::class
     * )
     *
     * @Generation\Response(
     *     statusCode=Response::HTTP_OK,
     *     content=@Generation\SerializedData(
     *         format="application/hal+json",
     *         serializationFqcn=UserResponseBodyModel::class
     *     )
     * )
     *
     * @Generation\Response(
     *     statusCode=Response::HTTP_BAD_REQUEST,
     *     content=@Generation\SerializedData(
     *         format="application/hal+json",
     *         serializationFqcn=VndErrorResponseBodyModel::class
     *     )
     * )
     *
     * @Generation\Response(
     *     statusCode=Response::HTTP_FORBIDDEN,
     *     content=@Generation\SerializedData(
     *         format="application/hal+json"
     *     )
     * )
     *
     * @Generation\Response(
     *     statusCode=Response::HTTP_NOT_FOUND,
     *     content=@Generation\SerializedData(
     *         format="application/hal+json"
     *     )
     * )
     */
    public function cgetUser(QueryResultInterface $data): ControllerResult
    {
        return new ControllerResult(Response::HTTP_OK, $data);
    }

    /**
     * Gets a user.
     *
     * @param User $data
     * @return ControllerResult
     *
     * @Route("/users/{id}", name="get_user", methods={"GET"}, defaults={"_format"="json"}, requirements={"_format"="json"})
     *
     * @Security("user.getBusiness().getName() == 'BileMo'")
     *
     * @Generation\Entity(entityFqcn=User::class)
     *
     * @Generation\Response(
     *     statusCode=Response::HTTP_OK,
     *     content=@Generation\SerializedData(
     *         format="application/hal+json",
     *         serializationFqcn=UserResponseBodyModel::class
     *     )
     * )
     *
     * @Generation\Response(
     *     statusCode=Response::HTTP_FORBIDDEN,
     *     content=@Generation\SerializedData(
     *         format="application/hal+json"
     *     )
     * )
     *
     * @Generation\Response(
     *     statusCode=Response::HTTP_NOT_FOUND,
     *     content=@Generation\SerializedData(
     *         format="application/hal+json"
     *     )
     * )
     */
    public function getUser(User $data): ControllerResult
    {
        return new ControllerResult(Response::HTTP_OK, $data);
    }

    /**
     * Posts a user.
     *
     * @param User $data
     * @return ControllerResult
     *
     * @Route("/users", name="post_user", methods={"POST"}, defaults={"_format"="json"}, requirements={"_format"="json"})
     *
     * @Security("user.getBusiness().getName() == 'BileMo'")
     *
     * @Generation\PostEntity(
     *     entityFqcn=User::class,
     *     deserializationFqcn=UserPostRequestBodyModel::class
     * )
     *
     * @Generation\Response(
     *     statusCode=Response::HTTP_CREATED,
     *     headers={"Location"=@Generation\Route(name="get_user", parameters={"id"=@DataFetching\GetterAccessor(name="getId")})},
     *     content=@Generation\SerializedData(
     *         format="application/hal+json",
     *         serializationFqcn=UserResponseBodyModel::class
     *     )
     * )
     *
     * @Generation\Response(
     *     statusCode=Response::HTTP_BAD_REQUEST,
     *     content=@Generation\SerializedData(
     *         format="application/hal+json",
     *         serializationFqcn=VndErrorResponseBodyModel::class
     *     )
     * )
     *
     * @Generation\Response(
     *     statusCode=Response::HTTP_FORBIDDEN,
     *     content=@Generation\SerializedData(
     *         format="application/hal+json"
     *     )
     * )
     *
     * @Generation\Response(
     *     statusCode=Response::HTTP_UNSUPPORTED_MEDIA_TYPE,
     *     content=@Generation\SerializedData(
     *         format="application/hal+json"
     *     )
     * )
     */
    public function postUser(User $data): ControllerResult
    {
        $this->entityGateway->save($data);
        $this->entityGateway->commit();

        return new ControllerResult(Response::HTTP_CREATED, $data);
    }

    /**
     * Deletes a user.
     *
     * @param User $data
     * @return ControllerResult
     *
     * @Route("/users/{id}", name="delete_user", methods={"DELETE"}, defaults={"_format"="json"}, requirements={"_format"="json"})
     *
     * @Security("user.getBusiness().getName() == 'BileMo'")
     *
     * @Generation\Entity(entityFqcn=User::class)
     *
     * @Generation\Response(
     *     statusCode=Response::HTTP_NO_CONTENT,
     *     content=@Generation\SerializedData(
     *         format="application/hal+json"
     *     )
     * )
     *
     * @Generation\Response(
     *     statusCode=Response::HTTP_FORBIDDEN,
     *     content=@Generation\SerializedData(
     *         format="application/hal+json"
     *     )
     * )
     *
     * @Generation\Response(
     *     statusCode=Response::HTTP_NOT_FOUND,
     *     content=@Generation\SerializedData(
     *         format="application/hal+json"
     *     )
     * )
     */
    public function deleteUser(User $data): ControllerResult
    {
        $this->entityGateway->delete($data);
        $this->entityGateway->commit();

        return new ControllerResult(Response::HTTP_NO_CONTENT);
    }
}
