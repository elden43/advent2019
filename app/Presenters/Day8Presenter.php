<?php

declare(strict_types=1);

namespace App\Presenters;


use App\AOC\ImageLayer;

final class Day8Presenter extends BasePresenter
{

	public function renderPuzzleResult(): void {
		$this->template->firstPuzzleResult = $this->firstPuzzleResult();
		$this->template->secondPuzzleResult = $this->secondPuzzleResult();
	}

	private function firstPuzzleResult(): int {
		$layers = $this->getLayers('d8p1.txt', 6, 25);

		$leastZeroDigitsPointer = 0;
		$leastZeroDigitsCounter = -1;
		foreach($layers as $layerKey => $layerValue) {
			if($leastZeroDigitsCounter === -1) {
				$leastZeroDigitsCounter = $layerValue->getCharCount("0");
			} else {
				if($layerValue->getCharCount("0") < $leastZeroDigitsCounter) {
					$leastZeroDigitsPointer = $layerKey;
					$leastZeroDigitsCounter = $layerValue->getCharCount("0");
				}
			}
		}

		return $layers[$leastZeroDigitsPointer]->getCharCount("1") * $layers[$leastZeroDigitsPointer]->getCharCount("2");
	}

	private function secondPuzzleResult(): string {
		$layers = $this->getLayers('d8p1.txt', 6, 25);
		$finalImage = $layers[0];

		foreach($layers as $layer) {
			$this->combineLayers($finalImage, $layer);
		}

		return $finalImage->printHTMLResult();
	}

	/**
	 * @param string $input
	 * @param int $rows
	 * @param int $columns
	 *
	 * @return \App\AOC\ImageLayer[]
	 */
	private function getLayers(string $input, int $rows, int $columns) {
		$input = $this->loadRowInput($input);
		/** @var ImageLayer[] $letters */
		$letters = [];

		for($i = 0; $i < strlen($input) / ($columns * $rows); $i++) {
			$letters[$i] = new ImageLayer(substr($input, $i * $columns * $rows, $columns * $rows), $columns);
		};

		return $letters;
	}

	/**
	 * @param \App\AOC\ImageLayer $finalImage
	 * @param \App\AOC\ImageLayer $letter
	 */
	private function combineLayers(ImageLayer &$finalImage, ImageLayer $letter): void {
		foreach($finalImage->layer as $rowKey => $rowValue) {
			foreach($rowValue as $columnKey => $columnValue) {
				if ($finalImage->layer[$rowKey][$columnKey] === "2") {
					$finalImage->layer[$rowKey][$columnKey] = $letter->layer[$rowKey][$columnKey];
				}
			}
		}
	}

}

namespace App\AOC;

final class ImageLayer {
	const BLACK  = "&#9633;";
	const WHITE = "&#9632;";

	/** @var array $layer */
	public $layer;

	public function __construct(string $inputText, int $columns) {
		$this->layer = [];
		$i = 0;
		$rowCounter = 0;
		$lineCounter = 0;

		while($i < strlen($inputText)) {
			$this->layer[$rowCounter][$lineCounter] = $inputText[$i];

			$i++;
			$lineCounter++;

			if($lineCounter === $columns) {
				$rowCounter++;
				$lineCounter = 0;
			}
		}
	}

	/**
	 * @param string $char
	 *
	 * @return int
	 */
	public function getCharCount(string $char): int {
		$count = [];
		foreach($this->layer as $letterRow) {
			foreach($letterRow as $letterItem) {
				if(!isset($count[$letterItem])){
					$count[$letterItem] = 0;
				}
				$count[$letterItem]++;
			}
		}

		return $count[$char] ?? 0;
	}

	public function printHTMLResult(): string {
		$resultHTML = "";
		foreach($this->layer as $row) {
			$resultHTML .= "<br>";
			foreach($row as $char) {
				if($char === "0") {
					$resultHTML .= self::BLACK;
				} elseif($char === "1") {
					$resultHTML .= self::WHITE;
				} else {
					$resultHTML .= "x";
				}
			}
		}

		return $resultHTML;
	}
}
