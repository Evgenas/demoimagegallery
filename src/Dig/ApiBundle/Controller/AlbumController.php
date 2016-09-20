<?php

namespace Dig\ApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\Get;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/album")
 */
class AlbumController extends FOSRestController
{
    /**
     * Get images by album.
     *
     * ApiDoc(
     *   section = "Albums",
     *   description = "Get images by album id with pagination",
     *   resource = true,
     *   output="Gis\ApiBundle\Entity\Album",
     *   statusCodes = {
     *     200 = "List of all images in album",
     *     204 = "No content. Nothing to list.",
     *     404 = "Album is not found."
     *   }
     * )
     *
     * @QueryParam(
     *   name="id",
     *   requirements="\d+",
     *   nullable=false,
     *   description="Album id"
     * )
     * @QueryParam(
     *   name="page",
     *   requirements="\d+",
     *   nullable=true,
     *   default="1",
     *   description="Requested page in album"
     * )
     *
     * @Get("/{id}")
     * @Get("/{id}/page/{page}")
     *
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     *
     * @param ParamFetcherInterface $paramFetcher
     *
     * @return Response
     */
    public function getAlbumAction(ParamFetcherInterface $paramFetcher)
    {
        $answer['album'] = [];

        return $answer;
    }
}
