<?php

namespace InscriptionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InscriptionDev
 *
 * @ORM\Table(name="inscription_dev")
 * @ORM\Entity(repositoryClass="InscriptionBundle\Repository\InscriptionDevRepository")
 */
class InscriptionDev
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
     * @ORM\Column(name="lastName", type="string", length=255)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=255)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=255)
     */
    private $mail;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthDay", type="date")
     */
    private $birthDay;

    /**
     * @var string
     *
     * @ORM\Column(name="major", type="string", length=255)
     */
    private $major;

    /**
     * @var string
     *
     * @ORM\Column(name="nickname", type="string", length=255)
     */
    private $nickname;

    /**
     * @var string
     *
     * @ORM\Column(name="phoneNumber", type="string", length=255)
     */
    private $phoneNumber;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="degreeDate", type="date")
     */
    private $degreeDate;

    /**
     * @var string
     *
     * @ORM\Column(name="school", type="string", length=255)
     */
    private $school;


    /**
     * @var string
     *
     * @ORM\Column(name="known", type="string")
     */
    private $known;

    /**
     * @var string
     *
     * @ORM\Column(name="mean", type="string", length=255)
     */
    private $mean;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * @var string
     *
     * @ORM\Column(name="tongue", type="string", length=255)
     */
    private $tongue;

    /**
     * @return string
     */
    public function getTongue()
    {
        return $this->tongue;
    }

    /**
     * @param string $tongue
     */
    public function setTongue($tongue)
    {
        $this->tongue = $tongue;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getStringCreatedAt()
    {
        return $this->createdAt->format('d/m/Y');
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
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
     * Set lastName
     *
     * @param string $lastName
     *
     * @return InscriptionDev
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
     * @return InscriptionDev
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
     * @return InscriptionDev
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
     * Set birthDay
     *
     * @param \DateTime $birthDay
     *
     * @return InscriptionDev
     */
    public function setBirthDay($birthDay)
    {
        $this->birthDay = $birthDay;

        return $this;
    }

    /**
     * Get birthDay
     *
     * @return \DateTime
     */
    public function getBirthDay()
    {
        return $this->birthDay;
    }

    public function getStringBirthDay()
    {
        return $this->birthDay->format('d/m/Y');
    }
    /**
     * Set major
     *
     * @param string $major
     *
     * @return InscriptionDev
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
     * @return InscriptionDev
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
     * Set phoneNumber
     *
     * @param string $phoneNumber
     *
     * @return InscriptionDev
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get phoneNumber
     *
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Set degreeDate
     *
     * @param \DateTime $degreeDate
     *
     * @return InscriptionDev
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
    public function getStringDegreeDate()
    {
        return $this->degreeDate->format('d/m/Y');
    }

    /**
     * Set school
     *
     * @param string $school
     *
     * @return InscriptionDev
     */
    public function setSchool($school)
    {
        $this->school = $school;

        return $this;
    }

    /**
     * Get school
     *
     * @return string
     */
    public function getSchool()
    {
        return $this->school;
    }

    /**
     * Set known
     *
     * @param boolean $known
     *
     * @return InscriptionDev
     */
    public function setKnown($known)
    {
        $this->known = $known;

        return $this;
    }

    /**
     * Get known
     *
     * @return bool
     */
    public function getKnown()
    {
        return $this->known;
    }

    /**
     * Set mean
     *
     * @param string $mean
     *
     * @return InscriptionDev
     */
    public function setMean($mean)
    {
        $this->mean = $mean;

        return $this;
    }

    /**
     * Get mean
     *
     * @return string
     */
    public function getMean()
    {
        return $this->mean;
    }
}