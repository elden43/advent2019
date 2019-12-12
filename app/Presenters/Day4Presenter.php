<?php

declare(strict_types=1);

namespace App\Presenters;


final class Day4Presenter extends BasePresenter
{

	public function renderPuzzleResult(): void {
		$this->template->firstPuzzleResult = $this->firstPuzzleResult();
		$this->template->secondPuzzleResult = $this->secondPuzzleResult();
	}

	private function firstPuzzleResult(): int {
		$minRange = 272091;
		$maxRange = 815432;
		$validPasswordCount = 0;

		for($i = $minRange; $i <= $maxRange; $i++) {
			if ($this->checkPasswordValidity((string) $i)) {
				$validPasswordCount++;
			};
		};

		return $validPasswordCount;
	}

	private function secondPuzzleResult(): int {
		$minRange = 272091;
		$maxRange = 815432;
		$validPasswordCount = 0;

		for($i = $minRange; $i <= $maxRange; $i++) {
			if($this->checkUpdatedPasswordValidity((string) $i)) {
				$validPasswordCount++;
			};
		};

		return $validPasswordCount;
	}

	private function checkPasswordValidity(string $password): bool {
		$maxDigit = 0;
		$doubleDigit = false;

		for($i = 0; $i < strlen($password); $i++) {
			if($i > 0) {
				if($password[$i-1] === $password[$i]) {
					$doubleDigit = true;
				}
			}
			if((int) $password[$i] < $maxDigit) {
				return false;
			}
			else {
				$maxDigit = max((int) $password[$i], $maxDigit);
			}
		}

		return $doubleDigit;
	}

	private function checkUpdatedPasswordValidity(string $password): bool {
		$maxDigit = 0;
		$doubleDigit = false;
		$exactDoubleDigit = false;

		for($i = 0; $i < strlen($password); $i++) {
			if($i > 0) {
				if($password[$i - 1] === $password[$i]) {
					$doubleDigit = true;
					//exact doubledigit check
					if(
						(!isset($password[$i - 2]) || (isset($password[$i - 2]) && $password[$i - 2] !== $password[$i])) &&
						(!isset($password[$i + 1]) || (isset($password[$i + 1]) && $password[$i + 1] !== $password[$i]))
					) {
						$exactDoubleDigit = true;
					}
				}
			}
			if((int) $password[$i] < $maxDigit) {
				return false;
			}
			else {
				$maxDigit = max((int) $password[$i], $maxDigit);
			}
		}

		return ($doubleDigit && $exactDoubleDigit);
	}

}
