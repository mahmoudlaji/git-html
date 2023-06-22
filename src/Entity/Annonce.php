<?php

namespace App\Entity;

use App\Repository\AnnonceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=AnnonceRepository::class)
 * @UniqueEntity("titre")

 */
class Annonce {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(max = 255)
     */
    private $titre;

    /**
     * @Gedmo\Slug(fields={"titre"}, updatable=true)
     * @ORM\Column(length=100, unique=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     * @Assert\Length(max = 255)
     */
    private $discreption;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreation;

    /**
     * @ORM\Column(type="boolean",nullable=true)
     */
    private $enabled;

    /**
     * @ORM\OneToMany(targetEntity="ImageAnnonces", mappedBy="annonce", cascade={"persist", "remove"})
     * @Assert\Valid()
     * @Assert\Count(
     *      min = 1,
     *      minMessage = "1 tag est obligatoire"
     * )
     */
    private $images;

    /**
     * @ORM\ManyToOne(targetEntity="Categorie", inversedBy="annonces")
     * @ORM\JoinColumn(nullable=true)

     */
    private $categorie;

    /**
     * @ORM\ManyToMany(targetEntity="Tag", inversedBy="annonces")
     * @ORM\JoinTable(name="annonces_tags",
     *      joinColumns={@ORM\JoinColumn(name="annonce_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id")}
     * )
     * @Assert\Count(
     *      min = 1,
     *      minMessage = "1 tag est obligatoire"
     * )
     */
    private $tags;

    /**
     * @ORM\ManyToOne(targetEntity="Utilisateur", inversedBy="annonces")

     */
    private $utilisateur;

    public function __construct() {
        $this->images = new ArrayCollection();
        $this->tags = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getTitre(): ?string {
        return $this->titre;
    }

    public function setTitre(string $titre): self {
        $this->titre = $titre;

        return $this;
    }

    public function getDiscreption(): ?string {
        return $this->discreption;
    }

    public function setDiscreption(string $discreption): self {
        $this->discreption = $discreption;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * @return Collection<int, ImageAnnonces>
     */
    public function getImages(): Collection {
        return $this->images;
    }

    public function addImage(ImageAnnonces $image): self {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setAnnonce($this);
        }

        return $this;
    }

    public function removeImage(ImageAnnonces $image): self {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getAnnonce() === $this) {
                $image->setAnnonce(null);
            }
        }

        return $this;
    }

    public function getSlug(): ?string {
        return $this->slug;
    }

    public function setSlug(string $slug): self {
        $this->slug = $slug;

        return $this;
    }

    public function getCategorie(): ?Categorie {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return Collection<int, Tag>
     */
    public function getTags(): Collection {
        return $this->tags;
    }

    public function addTag(Tag $tag): self {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self {
        $this->tags->removeElement($tag);

        return $this;
    }

    public function isEnabled(): ?bool {
        return $this->enabled;
    }

    public function setEnabled(?bool $enabled): self {
        $this->enabled = $enabled;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

}
