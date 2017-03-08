<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Visuel
 *
 * @ORM\Table(name="visuel")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VisuelRepository")
 */
class Visuel
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
     * @ORM\Column(name="block", type="string", length=255)
     */
    private $block;

    /**
     *@ORM\OneToOne(targetEntity="AppBundle\Entity\Media", cascade={"all"})
     *@ORM\JoinColumn(name="media_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $media;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\HomePage", inversedBy="visuels",cascade={"all"})
     * @ORM\JoinColumn(name="homepage_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $homepage;

    /**
     * @ORM\ManyToOne(targetEntity="TournamentBundle\Entity\Tournament", inversedBy="visuels",cascade={"all"})
     * @ORM\JoinColumn(name="tournament_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $tournament;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PartnerPage", inversedBy="visuels",cascade={"all"})
     * @ORM\JoinColumn(name="partnerpage_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $partnerpage;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\StreamPage", inversedBy="visuels",cascade={"all"})
     * @ORM\JoinColumn(name="streampage_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $streampage;

    /**
     * @return mixed
     */
    public function getStreampage()
    {
        return $this->streampage;
    }

    /**
     * @param mixed $streampage
     */
    public function setStreampage($streampage)
    {
        $this->streampage = $streampage;
    }

    /**
     * @return mixed
     */
    public function getPartnerpage()
    {
        return $this->partnerpage;
    }

    /**
     * @param mixed $partnerpage
     */
    public function setPartnerpage($partnerpage)
    {
        $this->partnerpage = $partnerpage;
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
     * Set block
     *
     * @param string $block
     *
     * @return Visuel
     */
    public function setBlock($block)
    {
        $this->block = $block;

        return $this;
    }

    /**
     * Get block
     *
     * @return string
     */
    public function getBlock()
    {
        return $this->block;
    }

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

    /**
     * @return mixed
     */
    public function getTournament()
    {
        return $this->tournament;
    }

    /**
     * @param mixed $tournament
     */
    public function setTournament($tournament)
    {
        $this->tournament = $tournament;
    }
}

