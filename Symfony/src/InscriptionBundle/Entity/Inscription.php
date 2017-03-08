<?php

namespace InscriptionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Inscription
 *
 * @ORM\Table(name="inscription")
 * @ORM\Entity(repositoryClass="InscriptionBundle\Repository\InscriptionRepository")
 */
class Inscription
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
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=255)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=255)
     */
    private $firstName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birth_date", type="date")
     */
    private $birthDay;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=255)
     */
    private $mail;

    /**
     * @var string
     *
     * @ORM\Column(name="phone_number", type="string", length=255)
     */
    private $phoneNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="nickname", type="string", length=255)
     */
    private $nickname;

    /**
     * @var string
     *
     * @ORM\Column(name="School", type="string", length=255)
     */
    private $School;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="degree_date", type="date")
     * @Assert\Date()
     */
    private $degreeDate;

    /**
     * @var string
     *
     * @ORM\Column(name="major", type="string", length=255)
     */
    private $major;

    /**
     * @var boolean
     *
     * @ORM\Column(name="known", type="boolean")
     */
    private $known;



    /**
     * @ORM\OneToOne(targetEntity="InscriptionBundle\Entity\Dev_cup", inversedBy="Inscription", cascade={"persist"})
     */
    private $dev_cup;

    /**
     * @ORM\OneToOne(targetEntity="TournamentBundle\Entity\Tournament", cascade={"persist"})
     */
    private $tournament;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * @return mixed
     */
    public function getSchool()
    {
        return $this->School;
    }

    /**
     * @param mixed $School
     */
    public function setSchool($School)
    {
        $this->School = $School;
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Inscription
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return Inscription
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Inscription
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set mail
     *
     * @param string $mail
     *
     * @return Inscription
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * Set birthDate
     *
     * @param \DateTime $birthDate
     *
     * @return Inscription
     */
    public function setBirthDay($birthDay)
    {
        $this->birthDay = $birthDay;

        return $this;
    }

    /**
     * Get birthDate
     *
     * @return \DateTime
     */
    public function getBirthDay()
    {
        return $this->birthDay;
    }

    /**
     * Set major
     *
     * @param string $major
     *
     * @return Inscription
     */
    public function setMajor($major)
    {
        $this->major = $major;

        return $this;
    }

    /**
     * Get major
     *
     * @return string
     */
    public function getMajor()
    {
        return $this->major;
    }

    /**
     * Set nickname
     *
     * @param string $nickname
     *
     * @return Inscription
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;

        return $this;
    }

    /**
     * Get nickname
     *
     * @return string
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * Set degreeDate
     *
     * @param \DateTime $degreeDate
     *
     * @return Inscription
     */
    public function setDegreeDate($degreeDate)
    {
        $this->degreeDate = $degreeDate;

        return $this;
    }

    /**
     * Get degreeDate
     *
     * @return \DateTime
     */
    public function getDegreeDate()
    {
        return $this->degreeDate;
    }

    /**
     * @return string
     */
    public function getKnown()
    {
        return $this->known;
    }

    /**
     * @param string $known
     */
    public function setKnown($known)
    {
        $this->known = $known;
    }




}

