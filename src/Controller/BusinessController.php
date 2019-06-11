<?php

namespace App\Controller;

use App\Entity\Business;
use App\Entity\User;
use App\HttpMessageBodyModel\BusinessPostRequestBodyModel;
use App\HttpMessageBodyModel\BusinessResponseBodyModel;
use App\HttpMessageBodyModel\BusinessUserPostRequestBodyModel;
use App\HttpMessageBodyModel\BusinessUserResponseBodyModel;
use App\HttpMessageBodyModel\VndErrorResponseBodyModel;
use App\Validator\Constraints\BusinessCollectionQuery;
use App\Validator\Constraints\BusinessUserCollectionQuery;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Opportus\ExtendedFrameworkBundle\DataFetcher\Accessor as DataFetching;
use Opportus\ExtendedFrameworkBundle\EntityGateway\Query\QueryResultInterface;
use Opportus\ExtendedFrameworkBundle\Generator\Configuration as Generation;
use Opportus\ExtendedFrameworkBundle\Generator\Context\ControllerResult;

/**
 * The business controller.
 *
 * @package App\Controller
 * @author  Clément Cazaud <opportus@gmail.com>
 * @license https://github.com/opportus/demo-rest-api/blob/master/LICENSE.md MIT
 */
class BusinessController
{
    use ControllerTrait;

    /**
     * Gets a collection of businesses.
     *
     * @param QueryResultInterface $data
     * @return ControllerResult
     *
     * @Route("/businesses", name="cget_business", methods={"GET"}, defaults={"_format"="json"}, requirements={"_format"="json"})
     *
     * @Security("user.getBusiness().getName() == 'BileMo'")
     *
     * @Generation\EntityCollection(
     *     entityFqcn=Business::class,
     *     queryConstraintFqcn=BusinessCollectionQuery::class
     * )
     *
     * @Generation\Response(
     *     statusCode=Response::HTTP_OK,
     *     content=@Generation\SerializedData(
     *         format="application/hal+json",
     *         serializationFqcn=BusinessResponseBodyModel::class
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
    public function cgetBusiness(QueryResultInterface $data): ControllerResult
    {
        return new ControllerResult(Response::HTTP_OK, $data);
    }

    /**
     * Gets a business.
     *
     * @param Business $data
     * @return ControllerResult
     *
     * @Route("/businesses/{id}", name="get_business", methods={"GET"}, defaults={"_format"="json"}, requirements={"_format"="json"})
     *
     * @Security("user.getBusiness().getName() == 'BileMo' or user.getBusiness().getId() == request.attributes.get('id')")
     *
     * @Generation\Entity(entityFqcn=Business::class)
     *
     * @Generation\Response(
     *     statusCode=Response::HTTP_OK,
     *     content=@Generation\SerializedData(
     *         format="application/hal+json",
     *         serializationFqcn=BusinessResponseBodyModel::class
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
    public function getBusiness(Business $data): ControllerResult
    {
        return new ControllerResult(Response::HTTP_OK, $data);
    }

    /**
     * Posts a business.
     *
     * @param Business $data
     * @return ControllerResult
     *
     * @Route("/businesses", name="post_business", methods={"POST"}, defaults={"_format"="json"}, requirements={"_format"="json"})
     *
     * @Security("user.getBusiness().getName() == 'BileMo'")
     *
     * @Generation\PostEntity(
     *     entityFqcn=Business::class,
     *     deserializationFqcn=BusinessPostRequestBodyModel::class,
     * )
     *
     * @Generation\Response(
     *     statusCode=Response::HTTP_CREATED,
     *     headers={"Location"=@Generation\Route(name="get_business", parameters={"id"=@DataFetching\GetterAccessor(name="getId")})},
     *     content=@Generation\SerializedData(
     *         format="application/hal+json",
     *         serializationFqcn=BusinessResponseBodyModel::class
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
    public function postBusiness(Business $data): ControllerResult
    {
        $this->entityGateway->save($data);
        $this->entityGateway->commit();

        return new ControllerResult(Response::HTTP_CREATED, $data);
    }

    /**
     * Deletes a business.
     *
     * @param Business $data
     * @return ControllerResult
     *
     * @Route("/businesses/{id}", name="delete_business", methods={"DELETE"}, defaults={"_format"="json"}, requirements={"_format"="json"})
     *
     * @Security("user.getBusiness().getName() == 'BileMo'")
     *
     * @Generation\Entity(entityFqcn=Business::class)
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
    public function deleteBusiness(Business $data): ControllerResult
    {
        $this->entityGateway->delete($data);
        $this->entityGateway->commit();

        return new ControllerResult(Response::HTTP_NO_CONTENT);
    }

    /**
     * Gets a collection of business users.
     *
     * @param QueryResultInterface $data
     * @return ControllerResult
     *
     * @Route("/businesses/{business_id}/users", name="cget_business_user", methods={"GET"}, defaults={"_format"="json"}, requirements={"_format"="json"})
     *
     * @Security("user.getBusiness().getName() == 'BileMo' or user.getBusiness().getId() == request.attributes.get('business_id')")
     *
     * @Generation\EntityCollection(
     *     entityFqcn=User::class,
     *     entityCriteria={"business"="business_id"},
     *     queryConstraintFqcn=BusinessUserCollectionQuery::class
     * )
     *
     * @Generation\Response(
     *     statusCode=Response::HTTP_OK,
     *     content=@Generation\SerializedData(
     *         format="application/hal+json",
     *         serializationFqcn=BusinessUserResponseBodyModel::class
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
    public function cgetBusinessUser(QueryResultInterface $data): ControllerResult
    {
        return new ControllerResult(Response::HTTP_OK, $data);
    }

    /**
     * Gets a business user.
     *
     * @param User $data
     * @return ControllerResult
     *
     * @Route("/businesses/{business_id}/users/{user_id}", name="get_business_user", methods={"GET"}, defaults={"_format"="json"}, requirements={"_format"="json"})
     *
     * @Security("user.getBusiness().getName() == 'BileMo' or user.getBusiness().getId() == request.attributes.get('business_id')")
     *
     * @Generation\Entity(
     *     entityFqcn=User::class,
     *     entityCriteria={"business"="business_id", "id"="user_id"}
     * )
     *
     * @Generation\Response(
     *     statusCode=Response::HTTP_OK,
     *     content=@Generation\SerializedData(
     *         format="application/hal+json",
     *         serializationFqcn=BusinessUserResponseBodyModel::class
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
    public function getBusinessUser(User $data): ControllerResult
    {
        return new ControllerResult(Response::HTTP_OK, $data);
    }

    /**
     * Posts a business user.
     *
     * @param User $data
     * @return ControllerResult
     *
     * @Route("/businesses/{business_id}/users", name="post_business_user", methods={"POST"}, defaults={"_format"="json"}, requirements={"_format"="json"})
     *
     * @Security("user.getBusiness().getName() == 'BileMo' or user.getBusiness().getId() == request.attributes.get('business_id')")
     *
     * @Generation\PostEntity(
     *     entityFqcn=User::class,
     *     deserializationFqcn=BusinessUserPostRequestBodyModel::class
     * )
     *
     * @Generation\Response(
     *     statusCode=Response::HTTP_CREATED,
     *     headers={"Location"=@Generation\Route(name="get_user", parameters={"id"=@DataFetching\GetterAccessor(name="getId")})},
     *     content=@Generation\SerializedData(
     *         format="application/hal+json",
     *         serializationFqcn=BusinessUserResponseBodyModel::class
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
    public function postBusinessUser(User $data): ControllerResult
    {
        $this->entityGateway->save($data);
        $this->entityGateway->commit();

        return new ControllerResult(Response::HTTP_CREATED, $data);
    }

    /**
     * Deletes a business user.
     *
     * @param User $data
     * @return ControllerResult
     *
     * @Route("/businesses/{business_id}/users/{user_id}", name="delete_business_user", methods={"DELETE"}, defaults={"_format"="json"}, requirements={"_format"="json"})
     *
     * @Security("user.getBusiness().getName() == 'BileMo' or user.getBusiness().getId() == request.attributes.get('business_id')")
     *
     * @Generation\Entity(
     *     entityFqcn=User::class,
     *     entityCriteria={"business"="business_id","id"="user_id"}
     * )
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
    public function deleteBusinessUser(User $data): ControllerResult
    {
        $this->entityGateway->delete($data);
        $this->entityGateway->commit();

        return new ControllerResult(Response::HTTP_NO_CONTENT);
    }
}
