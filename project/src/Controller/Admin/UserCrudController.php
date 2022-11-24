<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use Symfony\Component\Validator\Constraints\Length;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use Symfony\Component\Validator\Constraints\NotBlank;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserCrudController extends AbstractCrudController
{
	public static function getEntityFqcn(): string
	{
		return User::class;
	}

	public function configureCrud(Crud $crud): Crud
	{
		return $crud
			->setEntityLabelInSingular('Пользователь')
			->setEntityLabelInPlural('Пользователи')
			->setEntityLabelInSingular(
				fn(?User $user, ?string $pageName) => $user ? $user->getUserIdentifier() : 'Пользователь'
			)
			->setPaginatorPageSize(20)
			->setPaginatorRangeSize(3)
			->setEntityPermission('ROLE_ADMIN');
	}

	public function configureActions(Actions $actions): Actions
	{
		return $actions
			->setPermission(Action::EDIT, User::getAvailableRoles()['Admin'])
			->setPermission(Action::DELETE, User::getAvailableRoles()['Admin'])
			->remove(Crud::PAGE_INDEX, Action::NEW)
			->remove(Crud::PAGE_EDIT, Action::SAVE_AND_CONTINUE)
			;
	}

	public function configureFields(string $pageName): iterable
	{
		return [
			IdField::new('id', 'ID')
				->hideOnForm()
			,
			EmailField::new('email', 'Email')
				->hideWhenUpdating()
				->setColumns('col-sm-6 col-lg-5 col-xxl-3')
			,
			FormField::addRow()
			,
			ChoiceField::new('roles', 'Роль')
				->formatValue(fn($value, $entity) => implode('<span style="color:red"> & </span>', array_map(fn($role) => $role, $entity->getRoles())))
				->setChoices([
					'Администратор' => User::getAvailableRoles()['Admin'],
					'Менеджер' => User::getAvailableRoles()['Manager'],
					'Пользователь' => User::getAvailableRoles()['User'],
				])
				->allowMultipleChoices()
				->renderExpanded()
			,
		];
	}
}
