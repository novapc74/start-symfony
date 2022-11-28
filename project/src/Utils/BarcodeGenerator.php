<?php

namespace App\Utils;

use Picqer\Barcode\BarcodeGeneratorSVG; // Vector based SVG
use Picqer\Barcode\BarcodeGeneratorPNG; // Pixel based PNG
use Picqer\Barcode\BarcodeGeneratorJPG; // Pixel based JPG
use Picqer\Barcode\BarcodeGeneratorHTML; // Pixel based HTML
use Picqer\Barcode\BarcodeGeneratorDynamicHTML; // Vector based HTML

class BarcodeGenerator
{
	private const DIR_BARCODE = 'uploads/barcode/';

	public function generateCode(string $code): void
	{
		$generator = new BarcodeGeneratorPNG();

		$barcode   = $generator->getBarcode($code, $generator::TYPE_CODE_128, 3, 50);
		file_put_contents(self::DIR_BARCODE . $code . '_barcode.png', $barcode);
	}

	public function generateCodeByType($code, $type = 'png'): void
	{
		$mapping = [
			'svg' => fn() => '',
			'png' => fn() => $this->getPngFormat($code),
			'jpg' => fn() => '',
			'html' => fn() => '',
			'dynamicHtml' => fn() => '',
		];

		$mapping[$type]() ?? $this->getPngFormat($code);
	}

	private function getPngFormat($code): void
	{
		$generator = new BarcodeGeneratorPNG();

		$barcode   = $generator->getBarcode($code, $generator::TYPE_CODE_128, 3, 50);
		file_put_contents(self::DIR_BARCODE . $code . '_barcode.png', $barcode);
	}

	//TODO https://github.com/picqer/php-barcode-generator генератор штрих кодов

}