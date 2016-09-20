<?php

namespace spec\Dig\ApiBundle\Service;

use Dig\ApiBundle\Repository\ImageRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Knp\Component\Pager\Paginator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AlbumManagerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Dig\ApiBundle\Service\AlbumManager');
    }

    function let(Paginator $paginator, ObjectManager $entityManager, ImageRepository $repo)
    {
        //$repo->findImagesByAlbumId(Argument::any())->willReturn(new Download());
        $this->beConstructedWith($paginator, $entityManager);
    }

    function it_return_album_with_its_images()
    {
        $this->getAlbumWithImages(Argument::any(), Argument::any())->shouldHaveKey('album');
    }
}
