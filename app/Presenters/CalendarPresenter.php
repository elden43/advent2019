<?php

declare(strict_types=1);

namespace App\Presenters;


final class CalendarPresenter extends BasePresenter
{
	public function renderWindows() {
		$this->template->solved = 4;
	}
}
