<?php

namespace App\Controller\Admin;

use App\Entity\MediaTab;
use App\Form\Admin\MediaFormType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
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

	public function configureCrud(Crud $crud): Crud
	{
		return $crud
			->setEntityLabelInSingular('Медиа Таб')
			->setEntityLabelInPlural('Медиа Табы')
			->setPaginatorPageSize(20)
			->setPaginatorRangeSize(3)
			;
	}

	public function configureFields(string $pageName): iterable
	{
		return [
			TextField::new('picture', 'Картинка')
				->setTemplatePath('admin/crud/assoc_image.html.twig')
			->hideOnForm()
			,
			FormField::addPanel('Картинка')
				->setProperty('image')
				->setFormType(MediaFormType::class)
				->setFormTypeOptions([
					'error_bubbling' => false,
					'mapped' => true,
					'by_reference' => false,
				])
				->setColumns('col-sm-6 col-lg-5 col-xxl-3')
			->setHelp('<span style="color:red">З</span>агрузите необходимое изображение с Вашего устройства.')
			,
			FormField::addRow()
			,
			IntegerField::new('position', 'Позиция')
				->setFormTypeOption('attr', ['placeholder' => ' укажите позицию'])
				->setHelp('<span style="color:red">П</span>озиция задает порядок расположения изображения в коллекции.')
				->setColumns('col-sm-6 col-lg-5 col-xxl-3')
			,
			FormField::addRow()
			,
			TextEditorField::new('description', 'Описание')
				->setTemplatePath('admin/crud/assoc_description.html.twig')
				->setHelp('<span style="color:red">О</span>писание будет доступно под изображением.')
				->setColumns('col-sm-6 col-lg-5 col-xxl-3')
			,
		];
	}
}
