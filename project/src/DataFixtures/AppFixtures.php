<?php

namespace App\DataFixtures;

use App\Entity\User;

use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class AppFixtures extends BaseFixture
{
	public function __construct(private readonly UserPasswordHasherInterface $passwordEncoder)
	{
	}

	public function loadData(ObjectManager $manager)
	{
		$admin = $manager->getRepository(User::class)->findOneBy(['email' => 'novapc@ukr.net']);

		if (null === $admin) {
			$this->createEntity(User::class, 1, function (User $user) {
				$user
					->setEmail('novapc@ukr.net')
					->setRoles(["ROLE_ADMIN"])
					->setPassword($this->passwordEncoder->hashPassword($user, 'rerecz2009'));
			});

			$manager->flush();
		}
	}
}
