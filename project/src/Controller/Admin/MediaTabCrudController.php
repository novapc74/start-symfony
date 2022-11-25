<?php

namespace App\Controller\Admin;

use App\Entity\MediaTab;
use App\Form\Admin\MediaFormType;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class MediaTabCrudController extends AbstractCrudController
{
	public static function getEntityFqcn(): string
	{
		return MediaTab::class;
	}

	public function configureFields(string $pageName): iterable
	{
		return [
			TextField::new('picture', 'Картинка')
				->setTemplatePath('admin/crud/assoc_image.html.twig')
			->hideOnForm()
			,
			TextEditorField::new('description')
				->setTemplatePath('admin/crud/assoc_description.html.twig')
			,
			IntegerField::new('position', 'Позиция')
			,
			FormField::addPanel('Картинка')
				->setProperty('image')
				->setFormType(MediaFormType::class)
				->setFormTypeOptions([
					'error_bubbling' => false,
					'mapped' => true,
					'by_reference' => false,
				])
			,
		];
	}
}
