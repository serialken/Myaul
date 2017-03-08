<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Partner
 *
 * @ORM\Table(name="partner")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PartnerRepository")
 */
class Partner
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
     * @ORM\Column(type="string", length=255)
     */
    private $categorie;

    /**
     * @var text
     *
     * @ORM\Column(name="description", type="text", length=10000)
     */
    private $description;

    /**
     * @var text
     *
     * @ORM\Column(name="name", type="text", length=255)
     */
    private $name;

    /**
     *@ORM\OneToOne(targetEntity="AppBundle\Entity\Media", cascade={"all"})
     *@ORM\JoinColumn(name="media_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $media;

    /**
     *@ORM\ManyToOne(targetEntity="AppBundle\Entity\PartnerPage",inversedBy="partners", cascade={"all"})
     *@ORM\JoinColumn(name="partnerpage_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $partnerpage;

    /**
     * @Assert\File(maxSize="6000000")
     */
    private $file;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    public $path;

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
     * @return Partner
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
     * @return text
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param text $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    public function getAbsolutePath()
    {
        return null === $this->path
            ? null
            : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path
            ? null
            : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'pictures';
    }

    public function upload()
    {
        // the file property can be empty if the field is not required
        if (null === $this->getFile()) {
            return;
        }

        // use the original file name here but you should
        // sanitize it at least to avoid any security issues

        // move takes the target directory and then the
        // target filename to move to
        $this->getFile()->move(
            $this->getUploadRootDir(),
            $this->getFile()->getClientOriginalName()
        );

        // set the path property to the filename where you've saved the file
        $this->path = '/'.$this->getUploadDir().'/'.$this->getFile()->getClientOriginalName();
        //get the file name
//        $file = $this->getFile()->getClientOriginalName();
//        $info = pathinfo($file);
//        $file_name =  basename($file,'.'.$info['extension']);
//        $this->name = $file_name ;
//        $this->setName($file_name);
//        // clean up the file property as you won't need it anymore
//        $this->file = null;
    }

    public function lifecycleFileUpload()
    {
        $this->upload();
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * @param string $categorie
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;
    }

    public function __toString()
    {
        return $this->name;
    }


}

