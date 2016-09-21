<?php

namespace spec\Dig\ApiBundle\Entity;

use ApiBundle\Entity\Download;
use Dig\ApiBundle\Entity\Image;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AlbumSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Dig\ApiBundle\Entity\Album');
    }

    function it_has_name()
    {
        $this->getName();
    }

    function it_has_related_images()
    {
        $this->getImages();
    }
}
