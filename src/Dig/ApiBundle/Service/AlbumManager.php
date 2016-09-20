<?php

namespace Dig\ApiBundle\Service;

use Doctrine\Common\Persistence\ObjectManager;
use Knp\Component\Pager\Paginator;

class AlbumManager
{
    const IMAGES_PER_PAGE = 10;

    /**
     * @var Paginator
     */
    private $paginator;

    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(Paginator $paginator, ObjectManager $em)
    {
        $this->paginator = $paginator;
        $this->em = $em;
    }

    /**
     * @param int $albumId
     * @param int $page
     *
     * @return array
     */
    public function getAlbumImages($albumId, $page)
    {
        $offset = $page * self::IMAGES_PER_PAGE;
        $repo = $this->em->getRepository('DigApiBundle:Image');
        $result = $repo->getAlbumWithImagesSearchQuery($albumId);

        return ['images' => array_values($result)];
    }
}
