<?php

namespace App\Entity;

use App\Repository\TagsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TagsRepository::class)
 */
class Tags
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity=TagsTranslations::class, mappedBy="tags_id", fetch="EAGER")
     */
    private $tagsTranslations;

    public function __construct()
    {
        $this->tagsTranslations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection<int, TagsTranslations>
     */
    public function getTagsTranslations(): Collection
    {
        return $this->tagsTranslations;
    }

    public function addTagsTranslation(TagsTranslations $tagsTranslation): self
    {
        if (!$this->tagsTranslations->contains($tagsTranslation)) {
            $this->tagsTranslations[] = $tagsTranslation;
            $tagsTranslation->setTagsId($this);
        }

        return $this;
    }

    public function removeTagsTranslation(TagsTranslations $tagsTranslation): self
    {
        if ($this->tagsTranslations->removeElement($tagsTranslation)) {
            // set the owning side to null (unless already changed)
            if ($tagsTranslation->getTagsId() === $this) {
                $tagsTranslation->setTagsId(null);
            }
        }

        return $this;
    }
}
