<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Donjohn\MediaBundle\Model\Media as BaseMedia;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\MediaRepository")
 */
class Media extends BaseMedia
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var BlogPost
     * @ORM\OneToMany(targetEntity="App\Entity\BlogPost", mappedBy="media")
     */
    private $blogPostMedia;

    /**
     * @var Media
     * @ORM\ManyToMany(targetEntity="App\Entity\Media", mappedBy="medias")
     */
    private $blogPostMedias;

    public function __construct()
    {
        $this->blogPost = new ArrayCollection();
        $this->blogPostMedia = new ArrayCollection();
        $this->blogPostMedias = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|BlogPost[]
     */
    public function getBlogPostMedia(): Collection
    {
        return $this->blogPostMedia;
    }

    public function addBlogPostMedium(BlogPost $blogPostMedium): self
    {
        if (!$this->blogPostMedia->contains($blogPostMedium)) {
            $this->blogPostMedia[] = $blogPostMedium;
            $blogPostMedium->setMedia($this);
        }

        return $this;
    }

    public function removeBlogPostMedium(BlogPost $blogPostMedium): self
    {
        if ($this->blogPostMedia->contains($blogPostMedium)) {
            $this->blogPostMedia->removeElement($blogPostMedium);
            // set the owning side to null (unless already changed)
            if ($blogPostMedium->getMedia() === $this) {
                $blogPostMedium->setMedia(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Media[]
     */
    public function getBlogPostMedias(): Collection
    {
        return $this->blogPostMedias;
    }

    public function addBlogPostMedia(Media $blogPostMedia): self
    {
        if (!$this->blogPostMedias->contains($blogPostMedia)) {
            $this->blogPostMedias[] = $blogPostMedia;
            $blogPostMedia->addMedia($this);
        }

        return $this;
    }

    public function removeBlogPostMedia(Media $blogPostMedia): self
    {
        if ($this->blogPostMedias->contains($blogPostMedia)) {
            $this->blogPostMedias->removeElement($blogPostMedia);
            $blogPostMedia->removeMedia($this);
        }

        return $this;
    }

}