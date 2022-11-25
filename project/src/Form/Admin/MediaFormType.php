<?php

namespace App\Form\Admin;

use App\Entity\Media;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class MediaFormType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add('imageFile', VichImageType::class, [
				'label' => false,
				'constraints' => [
					new Callback([
						$this,
						'validate',
					]),
				],
			]);
	}

	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
			'data_class' => Media::class,
		]);
	}

	public function validate(?UploadedFile $file, ExecutionContextInterface $context): void
	{
		if (!$file) {
			return;
		}

		$fileNameLength = strlen($file->getClientOriginalName());

		if ($fileNameLength > 150) {
			$context->buildViolation(sprintf('Длина имени файла %s символа, что превышает допустимое значение в 200 символов!', $fileNameLength))
				->atPath('imageFile')
				->addViolation();
		}
	}
}
