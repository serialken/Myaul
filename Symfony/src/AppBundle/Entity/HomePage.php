<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * HomePage
 *
 * @ORM\Table(name="home_page")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\HomePageRepository")
 */
class HomePage
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
     * @ORM\OneToMany(targetEntity="Visuel", mappedBy="homepage", cascade={"all"})
     */
    private $visuels;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Last_edition", mappedBy="homepage", cascade={"all"})
     */
    private $last_editions;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Planning", mappedBy="homepage", cascade={"all"})
     */
    private $plannings;

    /**
     *@ORM\ManyToMany(targetEntity="AppBundle\Entity\Partner", cascade={"persist"})
     * @@ORM\JoinTable(name="partner",
     *      joinColumns={@@ORM\JoinColumn(name="homepage_id", referencedColumnName="id")},
     *      inverseJoinColumns={@@ORM\JoinColumn(name="partner_id", referencedColumnName="id")}
     *      )
     */
    private $partner;


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
     * @return HomePage
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

    public function __construct()
    {
        $this->visuels = new ArrayCollection();
        $this->last_editions = new ArrayCollection();
        $this->plannings = new ArrayCollection();
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

    /**
     * Add plannings
     *
     * @param \AppBundle\Entity\Planning $planning
     *
     * @return HomePage
     */
    public function addPlannings(\AppBundle\Entity\Planning $planning)
    {
        $this->plannings[] = $planning;
    }

    /**
     * Get plannings
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPlannings()
    {
        return $this->plannings;
    }

    /**
     * Add plannings
     *
     * @param \AppBundle\Entity\Last_edition $last_edition
     *
     * @return HomePage
     */
    public function addLastEditions(\AppBundle\Entity\Last_edition $last_edition)
    {
        $this->last_editions[] = $last_edition;
    }

    /**
     * Get last_editions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLastEditions()
    {
        return $this->last_editions;
    }

    /**
     * @return mixed
     */
    public function getPartner()
    {
        return $this->partner;
    }

    /**
     * @param mixed $partner
     */
    public function setPartner($partner)
    {
        $this->partner = $partner;
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


}

