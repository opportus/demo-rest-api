<?php

namespace App\Controller;

use App\Entity\Product;
use App\HttpMessageBodyModel\ProductPatchRequestBodyModel;
use App\HttpMessageBodyModel\ProductPostRequestBodyModel;
use App\HttpMessageBodyModel\ProductResponseBodyModel;
use App\HttpMessageBodyModel\VndErrorResponseBodyModel;
use App\Validator\Constraints\ProductCollectionQuery;
use Opportus\ExtendedFrameworkBundle\DataFetcher\Accessor as DataFetching;
use Opportus\ExtendedFrameworkBundle\EntityGateway\Query\QueryResultInterface;
use Opportus\ExtendedFrameworkBundle\Generator\Configuration as Generation;
use Opportus\ExtendedFrameworkBundle\Generator\Context\ControllerResult;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * The product controller.
 *
 * @package App\Controller
 * @author  Clément Cazaud <opportus@gmail.com>
 * @license https://github.com/opportus/demo-rest-api/blob/master/LICENSE.md MIT
 */
class ProductController
{
    use ControllerTrait;

    /**
     * Gets a collection of products.
     *
     * @param QueryResultInterface $data
     * @return ControllerResult
     *
     * @Route("/products", name="cget_product", methods={"GET"}, defaults={"_format"="json"}, requirements={"_format"="json"})
     *
     * @Generation\EntityCollection(
     *     entityFqcn=Product::class,
     *     queryConstraintFqcn=ProductCollectionQuery::class
     * )
     *
     * @Generation\Response(
     *     statusCode=Response::HTTP_OK,
     *     content=@Generation\SerializedData(
     *         format="application/hal+json",
     *         serializationFqcn=ProductResponseBodyModel::class
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
    public function cgetProduct(QueryResultInterface $data): ControllerResult
    {
        return new ControllerResult(Response::HTTP_OK, $data);
    }

    /**
     * Gets a product.
     *
     * @param Product $data
     * @return ControllerResult
     *
     * @Route("/products/{id}", name="get_product", methods={"GET"}, defaults={"_format"="json"}, requirements={"_format"="json"})
     *
     * @Generation\Entity(entityFqcn=Product::class)
     *
     * @Generation\Response(
     *     statusCode=Response::HTTP_OK,
     *     content=@Generation\SerializedData(
     *         format="application/hal+json",
     *         serializationFqcn=ProductResponseBodyModel::class
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
    public function getProduct(Product $data): ControllerResult
    {
        return new ControllerResult(Response::HTTP_OK, $data);
    }

    /**
     * Posts a product.
     *
     * @param Product $data
     * @return ControllerResult
     *
     * @Route("/products", name="post_product", methods={"POST"}, defaults={"_format"="json"}, requirements={"_format"="json"})
     *
     * @Security("user.getBusiness().getName() == 'BileMo'")
     *
     * @Generation\PostEntity(
     *     entityFqcn=Product::class,
     *     deserializationFqcn=ProductPostRequestBodyModel::class
     * )
     *
     * @Generation\Response(
     *     statusCode=Response::HTTP_CREATED,
     *     headers={"Location"=@Generation\Route(name="get_product", parameters={"id"=@DataFetching\GetterAccessor(name="getId")})},
     *     content=@Generation\SerializedData(
     *         format="application/hal+json",
     *         serializationFqcn=ProductResponseBodyModel::class
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
    public function postProduct(Product $data): ControllerResult
    {
        $this->entityGateway->save($data);
        $this->entityGateway->commit();

        return new ControllerResult(Response::HTTP_CREATED, $data);
    }

    /**
     * Patches a product.
     *
     * @param Product $data
     * @return ControllerResult
     *
     * @Route("/products/{id}", name="patch_product", methods={"PATCH"}, defaults={"_format"="json"}, requirements={"_format"="json"})
     *
     * @Security("user.getBusiness().getName() == 'BileMo'")
     *
     * @Generation\PatchEntity(
     *     entityFqcn=Product::class,
     *     deserializationFqcn=ProductPatchRequestBodyModel::class
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
     *
     * @Generation\Response(
     *     statusCode=Response::HTTP_UNSUPPORTED_MEDIA_TYPE,
     *     content=@Generation\SerializedData(
     *         format="application/hal+json"
     *     )
     * )
     */
    public function patchProduct(Product $data): ControllerResult
    {
        $this->entityGateway->save($data);
        $this->entityGateway->commit();

        return new ControllerResult(Response::HTTP_NO_CONTENT);
    }

    /**
     * Deletes a product.
     *
     * @param Product $data
     * @return ControllerResult
     *
     * @Route("/products/{id}", name="delete_product", methods={"DELETE"}, defaults={"_format"="json"}, requirements={"_format"="json"})
     *
     * @Security("user.getBusiness().getName() == 'BileMo'")
     *
     * @Generation\Entity(entityFqcn=Product::class)
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
    public function deleteProduct(Product $data): ControllerResult
    {
        $this->entityGateway->delete($data);
        $this->entityGateway->commit();

        return new ControllerResult(Response::HTTP_NO_CONTENT);
    }
}
