<?php

declare(strict_types=1);

namespace App\Presenters;


final class Day3Presenter extends BasePresenter
{

	public function renderPuzzleResult(): void {
		$this->template->firstPuzzleResult = $this->firstPuzzleResult();
		$this->template->secondPuzzleResult = $this->secondPuzzleResult();
	}

	private function firstPuzzleResult(): int {
		return 0;
	}

	private function secondPuzzleResult(): int {
		return 0;
	}

}
