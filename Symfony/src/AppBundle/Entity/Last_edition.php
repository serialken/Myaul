<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Last_edition
 *
 * @ORM\Table(name="last_edition")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Last_editionRepository")
 */
class Last_edition
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
     * @var text
     *
     * @ORM\Column(name="description", type="text", length=10000)
     */
    private $description;

    /**
     *@ORM\OneToOne(targetEntity="AppBundle\Entity\Media", cascade={"all"})
     *@ORM\JoinColumn(name="media_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $media;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\HomePage", inversedBy="last_editions",cascade={"all"})
     * @ORM\JoinColumn(name="homepage_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $homepage;


    /**
     * @return mixed
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * @param mixed $media
     */
    public function setMedia($media)
    {
        $this->media = $media;
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
     * Set description
     *
     * @param string $description
     *
     * @return Last_edition
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getHomepage()
    {
        return $this->homepage;
    }

    /**
     * @param mixed $homepage
     */
    public function setHomepage($homepage)
    {
        $this->homepage = $homepage;
    }


    public function __toString()
    {
        return $this->description;
    }

}

