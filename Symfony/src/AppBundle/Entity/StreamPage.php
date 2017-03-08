<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * StreamPage
 *
 * @ORM\Table(name="stream_page")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\StreamPageRepository")
 */
class StreamPage
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
     * @ORM\Column(type="string", length=255)
     */
    public $name;

    /**
     * @var bool
     *
     * @ORM\Column(name="publication", type="boolean")
     */
    private $publication;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Visuel", mappedBy="streampage", cascade={"all"})
     */
    private $visuels;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Streaming", mappedBy="streampage", cascade={"all"})
     */
    private $streamings;

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
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return ArrayCollection
     */
    public function getVisuels()
    {
        return $this->visuels;
    }

    /**
     * @param ArrayCollection $visuels
     */
    public function setVisuels($visuels)
    {
        $this->visuels = $visuels;
    }

    /**
     * @return ArrayCollection
     */
    public function getStreamings()
    {
        return $this->streamings;
    }

    /**
     * @param ArrayCollection $streaming
     */
    public function setStreamings($streaming)
    {
        $this->streamings = $streaming;
    }

    /**
     * Set publication
     *
     * @param string $publication
     *
     * @return StreamPage
     */
    public function setPublication($publication)
    {
        $this->publication = $publication;

        return $this;
    }

    /**
     * Get publication
     *
     * @return string
     */
    public function getPublication()
    {
        return $this->publication;
    }

    /**
     * Add visuels
     *
     * @param \AppBundle\Entity\Visuel $visuel
     *
     * @return StreamPage
     */
    public function addVisuels(\AppBundle\Entity\Visuel $visuel)
    {
        $this->visuels[] = $visuel;
    }

    /**
     * Add streamings
     *
     * @param \AppBundle\Entity\Streaming $streaming
     *
     * @return StreamPage
     */
    public function addStreamings(\AppBundle\Entity\Streaming $streaming)
    {
        $this->streamings[] = $streaming;
    }
}

