<?php

declare(strict_types=1);

namespace App\Presenters;


final class CalendarPresenter extends BasePresenter
{
	public function renderWindows() {
		$puzzlesSolved = [];
		for($i = 1; $i <= 25; $i++) {
			if(class_exists('App\Presenters\Day' . $i . 'Presenter')) {
				$puzzlesSolved[$i] = true;
			}
		}

		$this->template->puzzlesSolved = $puzzlesSolved;
	}

}
