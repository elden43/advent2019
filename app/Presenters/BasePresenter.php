<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;


abstract class BasePresenter extends Nette\Application\UI\Presenter
{
	protected function loadRowInputIntoArray(string $filename): array {
		$file = file_get_contents('../www/inputs/' . $filename);

		return explode(chr(10), $file);
	}

	protected function loadCommaInputIntoArray(string $filename, bool $toInt = false): array {
		$file = file_get_contents('../www/inputs/' . $filename);

		if($toInt){
			return array_map('intval', explode(',', $file));
		} else {
			return explode(',', $file);
		}
	}

	protected function loadRowInput(string $filename) {
		return file_get_contents('../www/inputs/' . $filename);
	}

}
