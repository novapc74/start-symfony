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
		$admin = $manager->getRepository(User::class)->findOneBy(['email' => 'admin@project.net']);

		if (null === $admin) {
			$this->createEntity(User::class, 1, function (User $user) {
				$user
					->setEmail('admin@project.net')
					->setRoles(["ROLE_ADMIN"])
					->setPassword($this->passwordEncoder->hashPassword($user, 'test2020'));
			});

			$manager->flush();
		}
	}
}
