<?php

namespace App\Controller;

use App\HttpMessageBodyModel\EntryPointResponseBodyModel;
use Opportus\ExtendedFrameworkBundle\Generator\Configuration as Generation;
use Opportus\ExtendedFrameworkBundle\Generator\Context\ControllerResult;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * The entry point controller.
 *
 * @package App\Controller
 * @author  Clément Cazaud <opportus@gmail.com>
 * @license https://github.com/opportus/demo-rest-api/blob/master/LICENSE.md MIT
 */
class EntryPointController
{
    use ControllerTrait;

    /**
     * Get the entry point.
     * 
     * @return ControllerResult
     * 
     * @Route("/", name="get_entry_point", methods={"GET"}, defaults={"_format"="json"}, requirements={"_format"="json"})
     * 
     * @Generation\Response(
     *     statusCode=Response::HTTP_OK,
     *     content=@Generation\SerializedData(format="application/hal+json")
     * )
     *
     * @Generation\Response(
     *     statusCode=Response::HTTP_FORBIDDEN,
     *     content=@Generation\SerializedData(format="application/hal+json")
     * )
     */
    public function getEntryPoint(): ControllerResult
    {
        return new ControllerResult(Response::HTTP_OK, new EntryPointResponseBodyModel());
    }
}
