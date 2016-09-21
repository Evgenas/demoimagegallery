<?php

namespace Dig\ApiBundle\Service;

use Dig\ApiBundle\Entity\Album;
use Doctrine\Common\Persistence\ObjectManager;
use Knp\Component\Pager\Paginator;
use Dig\ApiBundle\Util\Paging;

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
     * @return Paging
     */
    public function getAlbumImages($albumId, $page)
    {
        $repo = $this->em->getRepository('DigApiBundle:Image');
        $query = $repo->getAlbumWithImagesSearchQuery($albumId);
        $pagination = $this->paginator->paginate($query, $page, self::IMAGES_PER_PAGE);
        $currentPage = (int) $pagination->getCurrentPageNumber();
        $previous = (int) (1 === $currentPage ? 1 : $currentPage - 1);
        $next = $pagination->getTotalItemCount() > (self::IMAGES_PER_PAGE * $page) ? $currentPage + 1 : $currentPage;
        $result = new Paging();
        $result->setCurrent($currentPage);
        $result->setNext($next);
        $result->setPrevious($previous);
        $result->setRecords($pagination->getItems());

        return $result;
    }

    /**
     * @param int $albumId
     *
     * @return Album
     */
    public function getAlbum($albumId)
    {
        return $this->em->getRepository('DigApiBundle:Album')->find($albumId);
    }

    /**
     * @return Album[]
     */
    public function getAlbums()
    {
        return $this->em->getRepository('DigApiBundle:Album')->findAll();
    }
}
