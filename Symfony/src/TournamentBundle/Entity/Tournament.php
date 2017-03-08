<?php

namespace TournamentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * Tournament
 *
 * @ORM\Table(name="tournament")
 * @ORM\Entity(repositoryClass="TournamentBundle\Repository\TournamentRepository")
 */
class Tournament
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
     * @var integer
     *
     * @ORM\Column(name="year", type="integer")
     */
    private $year;

    /**
     * @var boolean
     *
     * @ORM\Column(name="devcup", type="boolean")
     */
    private $dev_cup;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="rank", type="string", length=255, nullable=true)
     */
    private $rank;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"game"})
     * @ORM\Column(name="game", type="string", length=255, nullable=false, unique=true)
     */
    private $game;

    /**
     * @var \DateTime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $datetime;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Few_word", mappedBy="tournament", cascade={"all"})
     */
    private $few_words;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Event", mappedBy="tournament", cascade={"all"})
     */
    private $events;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Edition", mappedBy="tournament", cascade={"all"})
     */
    private $editions;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Visuel", mappedBy="tournament", cascade={"all"})
     */
    private $visuels;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Pastille", mappedBy="tournament", cascade={"all"})
     */
    private $pastilles;

    /**
     *@ORM\ManyToMany(targetEntity="AppBundle\Entity\Partner", cascade={"persist"})
     * @@ORM\JoinTable(name="partner",
     *      joinColumns={@@ORM\JoinColumn(name="tournament_id", referencedColumnName="id")},
     *      inverseJoinColumns={@@ORM\JoinColumn(name="partner_id", referencedColumnName="id")}
     *      )
     */
    private $partner;

    /**
     * @var boolean
     *
     * @ORM\Column(name="publication", type="boolean")
     */
    private $publication;

    /**
     * @return date
     */
    public function getDatetime()
    {
        return $this->datetime;
    }

    public function addDatetime()
    {
        return $this->datetime->format('j, m, Y');
    }

    /**
     * @param date $datetime
     */
    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;
    }

    /**
     * @return boolean
     */
    public function isDevCup()
    {
        return $this->dev_cup;
    }

    /**
     * @param boolean $dev_cup
     */
    public function setDevCup($dev_cup)
    {
        $this->dev_cup = $dev_cup;
    }

    /**
     * @return mixed
     */
    public function getGame()
    {
        return $this->game;
    }

    /**
     * @param mixed $game
     */
    public function setGame($game)
    {
        $this->game = $game;
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
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param int $year
     */
    public function setYear($year)
    {
        $this->year = $year;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Tournament
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
     * Set rank
     *
     * @param integer $rank
     *
     * @return Tournament
     */
    public function setRank($rank)
    {
        $this->rank = $rank;

        return $this;
    }

    /**
     * Get rank
     *
     * @return int
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * @return boolean
     */
    public function isPublication()
    {
        return $this->publication;
    }

    /**
     * @param boolean $publication
     */
    public function setPublication($publication)
    {
        $this->publication = $publication;
    }

    /**
     * Get Partner
     *
     * @return \AppBundle\Entity\Partner $partner
     */
    public function getPartner()
    {
        return $this->partner;
    }

    /**
     * Set Partner
     *
     * @param \AppBundle\Entity\Partner $partner
     * @return Partner
     */
    public function setPartner(\AppBundle\Entity\Partner $partner  = null)
    {
        $this->partner = $partner;
    }

    /**
     * @param mixed $pastille
     */
    public function setPastilles($pastille)
    {
        $this->pastilles = $pastille;
    }

    public function __toString()
    {
        return $this->getName();
    }

    public function __construct()
    {
        $this->visuels = new ArrayCollection();
        $this->few_words = new ArrayCollection();
        $this->editions = new ArrayCollection();
        $this->events = new ArrayCollection();
        $this->partner = new ArrayCollection();
    }

    /**
     * Add visuels
     *
     * @param \AppBundle\Entity\Visuel $visuel
     *
     * @return Tournament
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
     * Get pastilles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPastilles()
    {
        return $this->pastilles;
    }

    /**
     * Add pastilles
     *
     * @param \TournamentBundle\Entity\Pastille $pastille
     *
     * @return Tournament
     */
    public function addPastilles(\TournamentBundle\Entity\Pastille $pastille)
    {
        $this->pastilles[] = $pastille;
    }

    /**
     * Add few_words
     *
     * @param \TournamentBundle\Entity\Few_word $few_word
     *
     * @return Tournament
     */
    public function addFewWords(\TournamentBundle\Entity\Few_word $few_word)
    {
        $this->few_words[] = $few_word;
    }

    /**
     * Get few_words
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFewWords()
    {
        return $this->few_words;
    }

    /**
     * Add editions
     *
     * @param \TournamentBundle\Entity\Edition $edition
     * @return Tournament
     */
    public function addEditions(\TournamentBundle\Entity\Edition $edition)
    {
        $this->editions[] = $edition;
    }

    /**
     * Get editions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEditions()
    {
        return $this->editions;
    }

    /**
     * Add events
     *
     * @param \TournamentBundle\Entity\Event $event
     * @return Tournament
     */
    public function addEvents(\TournamentBundle\Entity\Event $event)
    {
        $this->events[] = $event;
    }

    /**
     * Get events
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEvents()
    {
        return $this->events;
    }

}

