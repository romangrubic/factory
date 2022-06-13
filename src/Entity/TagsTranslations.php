<?php

namespace App\Entity;

use App\Repository\TagsTranslationsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TagsTranslationsRepository::class)
 */
class TagsTranslations
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Tags::class, inversedBy="tagsTranslations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tags_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $locale;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTagsId(): ?Tags
    {
        return $this->tags_id;
    }

    public function setTagsId(?Tags $tags_id): self
    {
        $this->tags_id = $tags_id;

        return $this;
    }

    public function getLocale(): ?string
    {
        return $this->locale;
    }

    public function setLocale(string $locale): self
    {
        $this->locale = $locale;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }
}
