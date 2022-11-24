<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;

	#[ORM\Column(length: 180, unique: true)]
	private ?string $email = null;

	#[ORM\Column]
	private array $roles = [];

	#[ORM\Column]
	private ?string $password = null;

	#[ORM\Column(type: 'boolean')]
	private ?bool $isVerified = false;

	private const ADMIN = 'ROLE_ADMIN';
	private const USER = 'ROLE_USER';

	#[ArrayShape(['Admin' => "string", 'User' => "string"])]
	public static function getAvailableRoles(): array
	{
		return [
			'Admin' => self::ADMIN,
			'User' => self::USER,
		];
	}

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getEmail(): ?string
	{
		return $this->email;
	}

	public function setEmail(string $email): self
	{
		$this->email = $email;

		return $this;
	}

	/**
	 * A visual identifier that represents this user.
	 *
	 * @see UserInterface
	 */
	public function getUserIdentifier(): string
	{
		return (string)$this->email;
	}

	/**
	 * @see UserInterface
	 */
	public function getRoles(): array
	{
		$roles = $this->roles;
		// guarantee every user at least has ROLE_USER
		$roles[] = 'ROLE_USER';

		return array_unique($roles);
	}

	public function setRoles(array $roles): self
	{
		$this->roles = $roles;

		return $this;
	}

	/**
	 * @see PasswordAuthenticatedUserInterface
	 */
	public function getPassword(): string
	{
		return $this->password;
	}

	public function setPassword(string $password): self
	{
		$this->password = $password;

		return $this;
	}

	/**
	 * @see UserInterface
	 */
	public function eraseCredentials()
	{
		// If you store any temporary, sensitive data on the user, clear it here
		// $this->plainPassword = null;
	}

	public function setHashPassword(string $plainPassword): self
	{
		$passwordHasherFactory = new PasswordHasherFactory([
			PasswordAuthenticatedUserInterface::class => ['algorithm' => 'auto'],
		]);
		$passwordHasher        = new UserPasswordHasher($passwordHasherFactory);


		$hashedPassword = $passwordHasher->hashPassword($this, $plainPassword);
		$this->setPassword($hashedPassword);

		return $this;
	}

	public function getHashPassword(): string
	{
		return $this->password;
	}

	public function isVerified(): bool
	{
		return $this->isVerified;
	}

	public function setIsVerified(bool $isVerified): self
	{
		$this->isVerified = $isVerified;

		return $this;
	}
}
