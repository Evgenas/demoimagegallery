<?php

namespace spec\Dig\ApiBundle\Service;

use Dig\ApiBundle\Entity\Image;
use Dig\ApiBundle\Repository\ImageRepository;
use Dig\ApiBundle\Service\AlbumManager;
use Doctrine\Common\Persistence\ObjectManager;
use Knp\Component\Pager\Paginator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
#use Doctrine\ORM\Query;
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
        ImageRepository $repo,
        Image $image,
        SlidingPagination $pagination
    )
    {
        $pagination->getCurrentPageNumber()->willReturn(self::FIRST_PAGE_NUMBER);
        $pagination->getTotalItemCount()->willReturn(1);
        $pagination->getItems()->willreturn([$image]);

        // it is impossible to mock final class
        //$repo->getAlbumWithImagesSearchQuery(self::TEST_ALBUM_ID)
        //      ->willReturn($searchQuery);

        $entityManager->getRepository("DigApiBundle:Image")->willReturn($repo);
        $paginator->paginate(Argument::any(), self::FIRST_PAGE_NUMBER, AlbumManager::IMAGES_PER_PAGE)->willReturn($pagination);

        $this->beConstructedWith($paginator, $entityManager);
    }

    function it_return_album_images()
    {
        $this->getAlbumImages(self::TEST_ALBUM_ID, self::FIRST_PAGE_NUMBER)->shouldBeAnInstanceOf('\Dig\ApiBundle\Util\Paging');
    }
}
