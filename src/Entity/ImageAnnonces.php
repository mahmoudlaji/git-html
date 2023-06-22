<?php

namespace App\Entity;

use App\Repository\ImageAnnoncesRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=ImageAnnoncesRepository::class)
 * @Vich\Uploadable
 */
class ImageAnnonces {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="image_annonces", fileNameProperty="imageName", size="imageSize", mimeType="imageMimeType", originalName="imageOriginalName", dimensions="imageDimensions")
     * @Assert\File(
     *     maxSize = "5M",
     *     mimeTypes = {"image/jpeg", "image/jpg", "image/gif", "image/png", "image/svg+xml"},
     *     mimeTypesMessage = "Ce fichier doit être une image ayant l'extension: jpeg, jpg, gif, svg ou png"
     *     )
     *  @Assert\NotBlank(groups={"create"})
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $imageName;

    /**
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var integer
     */
    private $imageSize;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $imageMimeType;

    /**
     * @ORM\Column(type="string", length=1000, nullable=true)
     */
    private $imageOriginalName;

    /**
     * @ORM\Column(type="simple_array", nullable=true)
     */
    private $imageDimensions;

    /**
     * @var \DateTime $updatedAt
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="Annonce", inversedBy="images")
     */
    private $annonce;

    public function setImageFile(File $imageFile = null) {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile() {
        return $this->imageFile;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getAnnonce(): ?Annonce {
        return $this->annonce;
    }

    public function setAnnonce(?Annonce $annonce): self {
        $this->annonce = $annonce;

        return $this;
    }

    public function getImageName(): ?string {
        return $this->imageName;
    }

    public function setImageName(?string $imageName): self {
        $this->imageName = $imageName;

        return $this;
    }

    public function getImageSize(): ?int {
        return $this->imageSize;
    }

    public function setImageSize(?int $imageSize): self {
        $this->imageSize = $imageSize;

        return $this;
    }

    public function getImageMimeType(): ?string {
        return $this->imageMimeType;
    }

    public function setImageMimeType(?string $imageMimeType): self {
        $this->imageMimeType = $imageMimeType;

        return $this;
    }

    public function getImageOriginalName(): ?string {
        return $this->imageOriginalName;
    }

    public function setImageOriginalName(?string $imageOriginalName): self {
        $this->imageOriginalName = $imageOriginalName;

        return $this;
    }

    public function getImageDimensions(): ?array {
        return $this->imageDimensions;
    }

    public function setImageDimensions(?array $imageDimensions): self {
        $this->imageDimensions = $imageDimensions;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self {
        $this->updatedAt = $updatedAt;

        return $this;
    }

}
