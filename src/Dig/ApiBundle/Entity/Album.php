<?php

namespace Dig\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Album.
 *
 * @ORM\Table(name="album")
 * @ORM\Entity(repositoryClass="Dig\ApiBundle\Repository\AlbumRepository")
 */
class Album
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Image", mappedBy="image")
     */
    private $images;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set name.
     *
     * @param string $name
     *
     * @return Album
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add image.
     *
     * @param \Dig\ApiBundle\Entity\Image $image
     *
     * @return Album
     */
    public function addImage(\Dig\ApiBundle\Entity\Image $image)
    {
        $this->images[] = $image;

        return $this;
    }

    /**
     * Remove image.
     *
     * @param \Dig\ApiBundle\Entity\Image $image
     */
    public function removeImage(\Dig\ApiBundle\Entity\Image $image)
    {
        $this->images->removeElement($image);
    }

    /**
     * Get images.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImages()
    {
        return $this->images;
    }
}
