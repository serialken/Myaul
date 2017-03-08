<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * PartnerPage
 *
 * @ORM\Table(name="partner_page")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PartnerPageRepository")
 */
class PartnerPage
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
     * @ORM\OneToMany(targetEntity="Visuel", mappedBy="partnerpage", cascade={"all"})
     */
    private $visuels;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Partner", mappedBy="partnerpage", cascade={"all"})
     */
    private $partners;


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
     * Set publication
     *
     * @param boolean $publication
     *
     * @return PartnerPage
     */
    public function setPublication($publication)
    {
        $this->publication = $publication;

        return $this;
    }

    /**
     * Get publication
     *
     * @return bool
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
     * @return HomePage
     */
    public function addVisuels(\AppBundle\Entity\Visuel $visuel)
    {
        $this->visuels[] = $visuel;
    }

    /**
     * Get visuels
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVisuels()
    {
        return $this->visuels;
    }

    public function addPartners(\AppBundle\Entity\Partner $partner)
    {
        $this->partners[] = $partner;
    }

    /**
     * Get visuels
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPartners()
    {
        return $this->partners;
    }

    /**
     * Set partner
     *
     * @param boolean $partner
     *
     * @return PartnerPage
     */
    public function setPartners($partner)
    {
        $this->partners = $partner;

        return $this;
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

    public function __construct()
    {
        $this->visuels = new ArrayCollection();
        $this->partners = new ArrayCollection();
    }
}

