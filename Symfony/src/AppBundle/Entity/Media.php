<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * Media
 *
 * @ORM\Table(name="media")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MediaRepository")
 */
class Media
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
     * @ORM\Column(name="title", type="text", length=10000)
     */
    private $title;

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
     * @var text
     *
     * @ORM\Column(name="link", type="text", length=10000, nullable = true)
     */
    private $link;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;

    /**
     * @var text
     *
     * @ORM\Column(name="page", type="text", length=10000)
     */
    private $page;

    /**
     * @var int
     *
     * @ORM\Column(name="num_order", type="integer")
     */
    private $num_order;

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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Media
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Media
     */

    /**
     * Set link
     *
     * @param string $link
     *
     * @return Media
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set status
     *
     * @param binary $status
     *
     * @return Media
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return binary
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set page
     *
     * @param string $page
     *
     * @return Media
     */
    public function setPage($page)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * Get page
     *
     * @return string
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @return int
     */
    public function getNumOrder()
    {
        return $this->num_order;
    }

    /**
     * @param int $num_order
     */
    public function setNumOrder($num_order)
    {
        $this->num_order = $num_order;
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
        $file = $this->getFile()->getClientOriginalName();
        $info = pathinfo($file);
        $file_name =  basename($file,'.'.$info['extension']);
        $this->name = $file_name ;
        $this->setTitle($file_name);
//        // clean up the file property as you won't need it anymore
//        $this->file = null;

    }

    public function lifecycleFileUpload()
    {
        $this->upload();
    }

    public function __toString(){
        return $this->getTitle();
    }
    public function __construct()
    {
        $this->last_edition = new ArrayCollection();
        $this->acensi = new ArrayCollection();
        $this->partner = new ArrayCollection();
        $this->planning = new ArrayCollection();
        $this->social_network = new ArrayCollection();
    }
}

