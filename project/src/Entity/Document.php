<?php

namespace App\Entity;

use JetBrains\PhpStorm\ArrayShape;
use App\Repository\DocumentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: DocumentRepository::class)]
class Document
{
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;

//	#[Assert\Unique] // TODO нормально не валидирует... попробовать в админке...
	#[ORM\Column(length: 255, unique: true)]
	private ?string $title = null;

	#[ORM\Column(length: 255)]
	#[Gedmo\Slug(fields: ['title'])]
	private ?string $slug = null;

	#[ORM\Column(type: Types::TEXT)]
	private ?string $description = null;

	private const PRIVACY = 'Пользовательское соглашение';
	private const DELIVERY = 'Доставка';
	private const PAYMENT = 'Оплата';
	private const GUARANTY = 'Гарантия';

	public function getId(): ?int
	{
		return $this->id;
	}

	#[ArrayShape([
		'Пользовательское соглашение' => 'string',
		'Доставка' => 'string',
		'Оплата' => 'string',
		'Гарантия' => 'string',
	])]
	public static function getAvailableDocs(): array
	{
		return [
			'Пользовательское соглашение' => self::PRIVACY,
			'Доставка' => self::DELIVERY,
			'Оплата' => self::PAYMENT,
			'Гарантия' => self::GUARANTY,
		];
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

	public function getSlug(): ?string
	{
		return $this->slug;
	}

	public function setSlug(string $slug): self
	{
		$this->slug = $slug;

		return $this;
	}

	public function getDescription(): ?string
	{
		return $this->description;
	}

	public function setDescription(string $description): self
	{
		$this->description = $description;

		return $this;
	}
}
