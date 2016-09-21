<?php

namespace LiveLife\MainBundle\DataFixtures\ORM;

use Dig\ApiBundle\Entity\Album;
use Dig\ApiBundle\Entity\Image;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadAlbumsWithImagesData extends AbstractFixture implements OrderedFixtureInterface
{
    private $fixtures = [
        0 => [
            'id' => 1,
            'name' => 'Album 1',
            'images' => [
                '1.jpg',
                '2.jpg',
                '3.jpg',
                '4.jpg',
                '5.jpg',
            ],
        ],
        1 => [
            'id' => 2,
            'name' => 'Album 2',
            'images' => 'randImages(20)',
        ],
        2 => [
            'id' => 3,
            'name' => 'Album 3',
            'images' => 'randImages(22)',
        ],
        3 => [
            'id' => 4,
            'name' => 'Album 4',
            'images' => 'randImages(22)',
        ],
        4 => [
            'id' => 5,
            'name' => 'Album 5',
            'images' => 'randImages(30)',
        ],
        5 => [
            'id' => 6,
            'name' => 'Empty Test Album 6',
            'images' => [],
        ],
    ];

    public function getOrder()
    {
        return 10;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        //despite of the autoincrement generator is reset with schema recreate action, we will stick to defined ids via direct setter (important for Behat tests)
        $metadata = $manager->getClassMetaData('Dig\ApiBundle\Entity\Album');
        $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);

        foreach ($this->fixtures as $album) {
            $newAlbum = $this->createAlbum($album);
            $manager->persist($newAlbum);
        }
        $manager->flush();
    }

    /**
     * @param array $albumData
     *
     * @return Album
     */
    public function createAlbum($albumData)
    {
        $album = new Album();
        $album->setId($albumData['id']);
        $album->setName($albumData['name']);

        if (!is_array($albumData['images']) && preg_match('/randImages\((\d+)\)/', $albumData['images'], $m)) {
            $albumData['images'] = [];
            for ($i = 0; $i < $m[1]; ++$i) {
                $albumData['images'][] = rand(1, 100).'.jpg';
            }
        }

        if (is_array($albumData['images'])) {
            foreach ($albumData['images'] as $imageName) {
                $image = new Image();
                $image->setFileName($imageName);
                $image->setAlbum($album);
                $album->addImage($image);
            }
        }

        return $album;
    }
}
