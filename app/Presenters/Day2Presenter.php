<?php

declare(strict_types=1);

namespace App\Presenters;


final class Day2Presenter extends BasePresenter
{
	/** @var array $program */
	private $program;

	public function renderPuzzleResult(): void {
		$this->template->firstPuzzleResult = $this->firstPuzzleResult();
		$this->template->secondPuzzleResult = $this->secondPuzzleResult();
	}

	private function firstPuzzleResult(): int {
		$this->program = $this->loadCommaInputIntoArray('d2p1.txt', true);
		//restore last program state
		$this->program[1] = 12;
		$this->program[2] = 2;

		$this->doProgramStep(0);
		return $this->program[0];
	}

	private function secondPuzzleResult(): string {
		$baseProgram = $this->loadCommaInputIntoArray('d2p1.txt', true);
		for($noun = 0; $noun < 100; $noun++) {
			for($verb = 0; $verb < 100; $verb++) {
				$this->program = $baseProgram;
				$this->program[1] = $noun;
				$this->program[2] = $verb;
				$this->doProgramStep(0);
				if($this->program[0] === 19690720) {
					return str_pad((string) $noun, 2, '0', STR_PAD_LEFT) . str_pad((string) $verb, 2, '0', STR_PAD_LEFT);
				}
			}
		}
	}

	private function doProgramStep($position): void {
		if(!isset($this->program[$position])) {
			exit('not defined program offset');
		}
		if($this->program[$position] === 1) {
			$this->program[$this->program[$position + 3]] = $this->program[$this->program[$position + 1]] + $this->program[$this->program[$position + 2]];
			$this->doProgramStep($position + 4);
		}
		elseif($this->program[$position] === 2) {
			$this->program[$this->program[$position + 3]] = $this->program[$this->program[$position + 1]] * $this->program[$this->program[$position + 2]];
			$this->doProgramStep($position + 4);
		}
		elseif($this->program[$position] === 99) {
			//program finished
		}
		else {
			exit('invalid command');
		}
	}

}
