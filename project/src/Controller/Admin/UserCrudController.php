<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
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
			->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig');
	}

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'ID')
	        ,
            EmailField::new('email', 'Email')
	        ,
	        CollectionField::new('roles', 'Роли')
	        ->formatValue(fn($value, $entity) => implode(' 😎 ', array_map(fn($role) => $role, $entity->getRoles())))
	        ,
        ];
    }
}
