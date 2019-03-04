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
    private $blogPost;

    public function __construct()
    {
        $this->blogPost = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|BlogPost[]
     */
    public function getBlogPost(): Collection
    {
        return $this->blogPost;
    }

    public function addBlogPost(BlogPost $blogPost): self
    {
        if (!$this->blogPost->contains($blogPost)) {
            $this->blogPost[] = $blogPost;
            $blogPost->setMedia($this);
        }

        return $this;
    }

    public function removeBlogPost(BlogPost $blogPost): self
    {
        if ($this->blogPost->contains($blogPost)) {
            $this->blogPost->removeElement($blogPost);
            // set the owning side to null (unless already changed)
            if ($blogPost->getMedia() === $this) {
                $blogPost->setMedia(null);
            }
        }

        return $this;
    }
}