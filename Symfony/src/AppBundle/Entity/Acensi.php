<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Acensi
 *
 * @ORM\Table(name="acensi")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AcensiRepository")
 */
class Acensi
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
     * @ORM\Column(name="image", type="text", length=10000)
     */
    private $image;

    /**
     * @var text
     *
     * @ORM\Column(name="description", type="text", length=10000)
     */
    private $description;

    /**
     * @var text
     *
     * @ORM\Column(name="logo", type="text", length=10000)
     */
    private $logo;

    /**
     * @var text
     *
     * @ORM\Column(name="legal_notice", type="text", length=10000)
     */
    private $legalNotice;

    /**
     *@ORM\OneToOne(targetEntity="AppBundle\Entity\Media", cascade={"all"})
     *@ORM\JoinColumn(name="media_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $media;

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
     * Set image
     *
     * @param string $image
     *
     * @return Acensi
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

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Acensi
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
     * Set logo
     *
     * @param string $logo
     *
     * @return Acensi
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set legalNotice
     *
     * @param string $legalNotice
     *
     * @return Acensi
     */
    public function setLegalNotice($legalNotice)
    {
        $this->legalNotice = $legalNotice;

        return $this;
    }

    /**
     * Get legalNotice
     *
     * @return string
     */
    public function getLegalNotice()
    {
        return $this->legalNotice;
    }

    public function __toString()
    {
        return $this->description;
    }
}

