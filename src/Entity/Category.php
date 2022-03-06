<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 * @ORM\Table(name="categories")
 * @UniqueEntity("name",message="The {{ value }} name is repeated.")
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255,unique=true)
     *  @Assert\NotBlank(message="Require Filled Name")
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="subcategoires")
     * @JoinColumn(onDelete="CASCADE")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity=Category::class, mappedBy="parent")
     */
    private $subcategoires;

    /**
     * @ORM\OneToMany(targetEntity=Video::class, mappedBy="categoy")
     */
    private $videos;

    public function __construct()
    {
        $this->subcategoires = new ArrayCollection();
        $this->videos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }
    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getSubcategoires(): Collection
    {
        return $this->subcategoires;
    }

    public function addSubcategoire(self $subcategoire): self
    {
        if (!$this->subcategoires->contains($subcategoire)) {
            $this->subcategoires[] = $subcategoire;
            $subcategoire->setParent($this);
        }

        return $this;
    }

    public function removeSubcategoire(self $subcategoire): self
    {
        if ($this->subcategoires->removeElement($subcategoire)) {
            // set the owning side to null (unless already changed)
            if ($subcategoire->getParent() === $this) {
                $subcategoire->setParent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Video>
     */
    public function getVideos(): Collection
    {
        return $this->videos;
    }

    public function addVideo(Video $video): self
    {
        if (!$this->videos->contains($video)) {
            $this->videos[] = $video;
            $video->setCategoy($this);
        }

        return $this;
    }

    public function removeVideo(Video $video): self
    {
        if ($this->videos->removeElement($video)) {
            // set the owning side to null (unless already changed)
            if ($video->getCategoy() === $this) {
                $video->setCategoy(null);
            }
        }

        return $this;
    }
}
