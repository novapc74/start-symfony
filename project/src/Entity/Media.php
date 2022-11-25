<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use App\Repository\MediaRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use DateTimeInterface;
use DateTimeImmutable;

#[ORM\Entity(repositoryClass: MediaRepository::class)]
#[Vich\Uploadable]
class Media
{
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;

	#[Vich\UploadableField(
		mapping: 'product_images',
		fileNameProperty: 'imageName',
		size: 'imageSize',
		mimeType: 'mime_type',
	)]
	private ?File $imageFile = null;

	#[ORM\Column(length: 255, nullable: true)]
	private ?string $imageName = null;

	#[ORM\Column(nullable: true)]
	private ?int $imageSize = null;

	#[ORM\Column(length: 40, nullable: true)]
	private ?string $mime_type = null;

	#[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
	private ?DateTimeInterface $updatedAt = null;

	public function getId(): ?int
	{
		return $this->id;
	}

	public function setImageFile(?File $imageFile = null): self
	{
		$this->imageFile = $imageFile;

		if (null !== $imageFile) {
			$this->updatedAt = new DateTimeImmutable('now');
		}

		return $this;
	}

	public function getImageFile(): ?File
	{
		return $this->imageFile;
	}

	public function getImageName(): ?string
	{
		return $this->imageName;
	}

	public function setImageName(?string $imageName): self
	{
		$this->imageName = $imageName;

		return $this;
	}

	public function getImageSize(): ?int
	{
		return $this->imageSize;
	}

	public function setImageSize(?int $imageSize): self
	{
		$this->imageSize = $imageSize;

		return $this;
	}

	public function getUpdatedAt(): ?DateTimeInterface
	{
		return $this->updatedAt;
	}

	public function setUpdatedAt(?DateTimeInterface $updatedAt): self
	{
		$this->updatedAt = $updatedAt;

		return $this;
	}

	public function getMimeType(): ?string
	{
		return $this->mime_type;
	}

	public function setMimeType(?string $mime_type): self
	{
		$this->mime_type = $mime_type;

		return $this;
	}
}
