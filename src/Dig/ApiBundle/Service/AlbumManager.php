<?php

namespace Dig\ApiBundle\Service;

use Doctrine\Common\Persistence\ObjectManager;
use Knp\Component\Pager\Paginator;

class AlbumManager
{
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
    public function getAlbumWithImages($albumId, $page)
    {
        return ['album' => []];
    }
}