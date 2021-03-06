<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * TVShow
 * @ORM\Entity
 * @UniqueEntity(fields="id", message="This ID already exists")
 */

class TVShow
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer", unique=true)
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $summary;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * TVShow constructor.
     * @param int $id
     * @param string $name
     * @param string $summary
     * @param string $image
     */
    public function __construct($id, $name, $summary, $image)
    {
        $this->id = $id;
        $this->name = $name;
        $this->summary = $summary;
        $this->image = $image;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return TVShow
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set summary
     *
     * @param string $summary
     *
     * @return TVShow
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;

        return $this;
    }

    /**
     * Get summary
     *
     * @return string
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return TVShow
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }
}

