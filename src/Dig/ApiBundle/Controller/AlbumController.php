<?php

namespace Dig\ApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\Get;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @Route("/album")
 */
class AlbumController extends FOSRestController
{
    /**
     * Get images by album.
     *
     * @ApiDoc(
     *   section = "Albums",
     *   description = "Get images by album id with pagination",
     *   resource = true,
     *   output="Gis\ApiBundle\Entity\Album",
     *   statusCodes = {
     *     200 = "List of all images in album",
     *     404 = "Album is not found."
     *   }
     * )
     *
     * @Get("/{id}", requirements={"id": "\d+"})
     * @Get("/{id}/page/{page}", requirements={ "id": "\d+", "page": "\d+"})
     *
     * @Rest\View(serializerEnableMaxDepthChecks=false)
     *
     * @param int $id
     * @param int $page
     *
     * @throws NotFoundHttpException
     *
     * @return Response
     */
    public function getAlbumAction($id, $page = 1)
    {
        /** @var $manager\Dig\ApiBundle\Service\AlbumManager */
        $manager = $this->container->get('dig.album.manager');
        $album = $manager->getAlbum($id);

        if (!$album) {
            throw new NotFoundHttpException(sprintf('Entity with id %d not found.', $id));
        }

        $images = $manager->getAlbumImages($id, $page);

        $answer['album'] = $images;

        return $answer;
    }
}
