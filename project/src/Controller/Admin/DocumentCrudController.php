<?php

namespace App\Controller\Admin;

use App\Entity\Document;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class DocumentCrudController extends AbstractCrudController
{
	public static function getEntityFqcn(): string
	{
		return Document::class;
	}

	public function configureFields(string $pageName): iterable
	{
		return [
			TextField::new('title', 'Заголовок')
				->hideOnForm(),
			// TODO валидацию для уникальности title...
			ChoiceField::new('title')
				->hideOnIndex()
				->setFormTypeOptions([
					'label' => 'Документ',
					'attr' => [
						'placeholder' => 'Виберите тип документа'
					],
				])
				->setChoices(Document::getAvailableDocs())
				->setHelp('Укажите тип создаваемого документа')
				->setColumns('col-sm-6 col-lg-5 col-xxl-3')
			,
			SlugField::new('slug', 'Слаг')
				->setTargetFieldName('title')
				->setHelp('Название на латинице, отображается в строке бразуера. Для рекдактирования нажмите на &#128275;')
				->setColumns('col-sm-6 col-lg-5 col-xxl-3 text-danger')
			,
			TextEditorField::new('description', 'Описание')
				->setHelp('В текущем поле заполните содержание тела документа.')
			,
			BooleanField::new('isVisible', 'Видимый.')
			,
		];
	}
}
