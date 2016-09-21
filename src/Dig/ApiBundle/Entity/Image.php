<?php

namespace Dig\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * Image.
 *
 * @ORM\Table(name="image")
 * @ORM\Entity(repositoryClass="Dig\ApiBundle\Repository\ImageRepository")
 *
 * @JMS\ExclusionPolicy("all")
 */
class Image
{
    const RELATIVE_ROOT_FILE_PATH = 'images/';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @JMS\Expose
     * @JMS\Type("integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="file_name", type="string", length=100)
     *
     * @JMS\Expose
     * @JMS\Type("string")
     */
    private $fileName;

    /**
     * @ORM\ManyToOne(targetEntity="Album", inversedBy="images")
     * @ORM\JoinColumn(name="album_id", referencedColumnName="id")
     */
    private $album;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fileName.
     *
     * @param string $fileName
     *
     * @return Image
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * Get fileName.
     *
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * Set album.
     *
     * @param \Dig\ApiBundle\Entity\Album $album
     *
     * @return Image
     */
    public function setAlbum(\Dig\ApiBundle\Entity\Album $album = null)
    {
        $this->album = $album;

        return $this;
    }

    /**
     * Get album.
     *
     * @return \Dig\ApiBundle\Entity\Album
     */
    public function getAlbum()
    {
        return $this->album;
    }

    /**
     * Relative web path to image.
     *
     * @return string
     */
    public function getFileUri()
    {
        return self::RELATIVE_ROOT_FILE_PATH.$this->fileName;
    }
}
