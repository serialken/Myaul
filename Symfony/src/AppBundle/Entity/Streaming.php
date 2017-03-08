<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Streaming
 *
 * @ORM\Table(name="streaming")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\StreamingRepository")
 */
class Streaming
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\StreamPage", inversedBy="streamings",cascade={"all"})
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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
     * Set block
     *
     * @param string $block
     *
     * @return Streaming
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
        $this->setName($file_name);
//        // clean up the file property as you won't need it anymore
//        $this->file = null;
    }
}

