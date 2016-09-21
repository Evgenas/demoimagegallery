<?php

namespace spec\Dig\ApiBundle\Entity;

use ApiBundle\Entity\Download;
use Dig\ApiBundle\Entity\Image;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ImageSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Dig\ApiBundle\Entity\Image');
    }

    function it_has_file_name()
    {
        $this->getFilename();
    }

    function it_relates_to_album()
    {
        $this->getAlbum();
    }

    function it_returns_web_image_uri()
    {
        $this->callOnWrappedObject('setFilename', ['test.jpg']);
        $this->getFileUri()->shouldBeEqualTo(Image::RELATIVE_ROOT_FILE_PATH . 'test.jpg');
    }
}
