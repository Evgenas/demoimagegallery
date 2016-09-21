<?php

namespace Dig\ApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\Get;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AlbumController extends FOSRestController
{
    /**
     * Get all albums.
     *
     * Response example:
     * {"albums":[
     *      {"id":"1","name":"Album 1"},
     *      {"id":"2","name":"Album 2"},
     *      {"id":"3","name":"Album 3"},
     *      {"id":"4","name":"Album 4"},
     *      {"id":"5","name":"Album 3"}
     * ]}
     *
     * @ApiDoc(
     *   section = "Albums",
     *   description = "Get all albums",
     *   resource = true,
     *   output="Gis\ApiBundle\Entity\Album",
     *   statusCodes = {
     *     200 = "List of all albums",
     *   }
     * )
     *
     * @Get("/")
     *
     * @Rest\View()
     *
     * @return Response
     */
    public function getAlbumsAction()
    {
        /** @var $manager\Dig\ApiBundle\Service\AlbumManager */
        $manager = $this->container->get('dig.album.manager');
        $answer['albums'] = $manager->getAlbums();

        return $answer;
    }

    /**
     * Get images by album.
     *
     * Response example:
     *
     *  {"album":
     *      {"name":"Album 1",
     *       "current":"1",
     *       "next":"1",
     *       "previous":0,
     *       "records":[
     *          {"id":1,"file_name":"1.jpg"},
     *          {"id":2,"file_name":"2.jpg"},
     *          {"id":3,"file_name":"3.jpg"},
     *          {"id":4,"file_name":"4.jpg"},
     *          {"id":5,"file_name":"5.jpg"}
     *       ]}}
     *
     *
     * @ApiDoc(
     *   section = "Albums",
     *   description = "Get images by album id with pagination",
     *   resource = true,
     *   output="Gis\ApiBundle\Utility\Paging",
     *   statusCodes = {
     *     200 = "List of all images in album",
     *     404 = "Album is not found."
     *   }
     * )
     *
     * @Get("/album/{id}", requirements={"id": "\d+"})
     * @Get("/album/{id}/page/{page}", requirements={ "id": "\d+", "page": "\d+"})
     *
     * @Rest\View()
     *
     * @param int $id   Album id
     * @param int $page Requested page in album
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

        $paging = $manager->getAlbumImages($id, $page);
        $paging->setName($album->getName());
        $answer['album'] = $paging;

        return $answer;
    }
}
