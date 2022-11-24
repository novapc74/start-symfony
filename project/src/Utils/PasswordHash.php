<?php

namespace App\Utils;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class PasswordHash
{
	public function __construct(private readonly UserPasswordHasherInterface $userPasswordHasher)
	{
	}

	public function hashPassword(User $user, ?string $plainPassword)
	{
		return $this->userPasswordHasher->hashPassword($user, $user->getPassword());
	}
}