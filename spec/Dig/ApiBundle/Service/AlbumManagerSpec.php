<?php

namespace spec\Dig\ApiBundle\Service;

use Dig\ApiBundle\Entity\Album;
use Dig\ApiBundle\Entity\Image;
use Dig\ApiBundle\Repository\AlbumRepository;
use Dig\ApiBundle\Repository\ImageRepository;
use Dig\ApiBundle\Service\AlbumManager;
use Doctrine\Common\Persistence\ObjectManager;
use Knp\Component\Pager\Pagination\AbstractPagination;
use Knp\Component\Pager\Paginator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;

class AlbumManagerSpec extends ObjectBehavior
{
    const TEST_ALBUM_ID = 1;
    const FIRST_PAGE_NUMBER = 1;

    function it_is_initializable()
    {
        $this->shouldHaveType('Dig\ApiBundle\Service\AlbumManager');
    }

    function let(
        Paginator $paginator,
        ObjectManager $entityManager,
        ImageRepository $imageRepo,
        AlbumRepository $albumRepo,
        Image $image,
        SlidingPagination $pagination
    )
    {
        $pagination->getCurrentPageNumber()->willReturn(self::FIRST_PAGE_NUMBER);
        $pagination->getTotalItemCount()->willReturn(1);
        $pagination->getItems()->willreturn([$image]);

        // it is impossible to mock final class of Doctrine\ORM\Query so using Argument::any
        // @link: https://github.com/phpspec/prophecy/issues/102
        //$iamgeRepo->getAlbumWithImagesSearchQuery(self::TEST_ALBUM_ID)->willReturn($searchQuery);
        $paginator->paginate(Argument::any(), self::FIRST_PAGE_NUMBER, AlbumManager::IMAGES_PER_PAGE)->willReturn($pagination);

        $entityManager->getRepository("DigApiBundle:Image")->willReturn($imageRepo);
        $entityManager->getRepository("DigApiBundle:Album")->willReturn($albumRepo);

        $this->beConstructedWith($paginator, $entityManager);
    }

    function it_returns_list_of_all_albums(AlbumRepository $albumRepo, Album $album)
    {
        $albumRepo->findAll()->willReturn([$album]);

        $this->getAlbums()->shouldBeArray();
        $this->getAlbums()->shouldHaveAlbums();
    }

    function it_returns_album_by_its_id(AlbumRepository $albumRepo, Album $album)
    {
        $albumRepo->find(self::TEST_ALBUM_ID)->willReturn($album);

        $this->getAlbum(self::TEST_ALBUM_ID)->shouldBeAnInstanceOf('\Dig\ApiBundle\Entity\Album');
    }

    function it_returns_album_images_paginated(ImageRepository $imageRepo, Paginator $paginator, AbstractPagination $pagination)
    {
        $imageRepo->getAlbumWithImagesSearchQuery(self::TEST_ALBUM_ID)->shouldBeCalled();
        $paginator->paginate(Argument::any(), self::FIRST_PAGE_NUMBER, AlbumManager::IMAGES_PER_PAGE)->shouldBeCalled();
        $pagination->getCurrentPageNumber()->shouldBeCalled();
        $pagination->getTotalItemCount()->shouldBeCalled();
        $pagination->getItems()->shouldBeCalled();

        $this->getAlbumImages(self::TEST_ALBUM_ID, self::FIRST_PAGE_NUMBER)->shouldBeAnInstanceOf('\Dig\ApiBundle\Util\Paging');
        $this->getAlbumImages(self::TEST_ALBUM_ID, self::FIRST_PAGE_NUMBER)->shouldHaveNextPage(1);
        $this->getAlbumImages(self::TEST_ALBUM_ID, self::FIRST_PAGE_NUMBER)->shouldHavePreviousPage(1);
        $this->getAlbumImages(self::TEST_ALBUM_ID, self::FIRST_PAGE_NUMBER)->shouldHaveCurrentPage(1);
        $this->getAlbumImages(self::TEST_ALBUM_ID, self::FIRST_PAGE_NUMBER)->shouldHaveImages();
    }

    /**
     * Our custom matchers
     *
     * @return array
     */
    public function getMatchers()
    {
        return [
            'haveNextPage' => function ($subject, $key) {
                return $subject->getNext() == $key;
            },
            'haveCurrentPage' => function ($subject, $key) {
                return $subject->getCurrent() == $key;
            },
            'havePreviousPage' => function ($subject, $key) {
                return $subject->getPrevious() == $key;
            },
            'haveImages' => function ($subject) {
                $images = $subject->getRecords();
                return ($images[0] instanceof Image) ? true : false;
            },
            'haveAlbums' => function ($subject) {
                return ($subject[0] instanceof Album) ? true : false;
            },
        ];
    }
}
