<?php

declare(strict_types=1);

namespace App\Presenters;


final class Day1Presenter extends BasePresenter
{
	public function renderPuzzleResult(): void {
		$this->template->firstPuzzleResult = $this->firstPuzzleResult();
		$this->template->secondPuzzleResult = $this->secondPuzzleResult();
	}

	private function firstPuzzleResult(): int {
		$result = 0;
		$components = $this->loadRowInputIntoArray('d1p1.txt');

		foreach($components as $componentMass) {
			$result += $this->getFuelByMass((int) $componentMass);
		}

		return $result;
	}

	private function secondPuzzleResult(): int {
		$result = 0;
		$components = $this->loadRowInputIntoArray('d1p1.txt');

		foreach($components as $componentMass) {
			$result += $fuelMass = $this->getFuelByMass((int) $componentMass);
			$result += $this->getFuelForFuel($fuelMass);
		}

		return $result;
	}

	private function getFuelByMass(int $mass): int {
		return (int) max(floor($mass/ 3) - 2,0);
	}

	private function getFuelForFuel(int $fuelMass): int {
		$fuelForFuel = 0;
		$newFuel = $fuelMass;
		while($newFuel > 0) {
			$newFuel = $this->getFuelByMass($newFuel);
			$fuelForFuel += $newFuel;
		}

		return $fuelForFuel;
	}

}
