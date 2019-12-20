<?php

declare(strict_types=1);

namespace App\Presenters;


use App\AOC\SpaceObject;

final class Day6Presenter extends BasePresenter
{
	/** @var SpaceObject[] */
	private $spaceMap;

	public function renderPuzzleResult(): void {
		$this->template->firstPuzzleResult = $this->firstPuzzleResult();
		$this->template->secondPuzzleResult = $this->secondPuzzleResult();
	}

	private function firstPuzzleResult(): int {
		$this->spaceMap = [];
		$this->prepareSpaceMap($this->loadRowInputIntoArray('d6p1.txt'));

		$orbitCount = 0;
		foreach($this->spaceMap as $spaceObject) {
			$orbitCount = $orbitCount + $this->getOrbitCount($spaceObject);
		}
		return $orbitCount;
	}

	private function secondPuzzleResult(): int {
		$this->spaceMap = [];
		$this->prepareSpaceMap($this->loadRowInputIntoArray('d6p1.txt'));

		$santaIterator = 0;
		foreach (explode('-', $this->getPathToCom($this->spaceMap['SAN'])) as $santasPathStep) {
			$youIterator = 0;
			foreach(explode('-', $this->getPathToCom($this->spaceMap['YOU'])) as $youPathStep) {
				if($santasPathStep === $youPathStep){
					return $santaIterator + $youIterator - 2;
				}
				$youIterator++;
			}
			$santaIterator++;
		}

		return 0;
	}

	/**
	 * @param string $row
	 *
	 * @return string
	 */
	private function getObjectName($row): string {
		preg_match('#.+?(?=[)])#', $row, $matches);

		return $matches[0];
	}

	/**
	 * @param string $row
	 * @return string
	 */
	private function getOrbitName($row): string {
		preg_match('#\)(.*)#', $row, $matches);

		return $matches[1];
	}

	/**
	 * @param array $input
	 */
	private function prepareSpaceMap(array $input): void {
		foreach($input as $inputItem) {
			$objectName = $this->getObjectName($inputItem);
			$orbitName = $this->getOrbitName($inputItem);
			if(!isset($$objectName)) {
				$$objectName = new SpaceObject($objectName);
				$$objectName->addOrbit($orbitName);
				$this->spaceMap[$objectName] = $$objectName;
			}
			else {
				$$objectName->addOrbit($orbitName);
			}
			//create orbit object if needed
			if(!isset($$orbitName)) {
				$$orbitName = new SpaceObject($orbitName);
				$$orbitName->setParentObject($objectName);
				$this->spaceMap[$orbitName] = $$orbitName;
			} else {
				$this->spaceMap[$orbitName]->setParentObject($objectName);
			}
		}
	}

	/**
	 * @param \App\AOC\SpaceObject $source
	 *
	 * @return int
	 */
	private function getOrbitCount(SpaceObject $source): int {
		$orbitCount = 0;
		foreach($source->directOrbits as $orbitName) {
			$orbitCount = $orbitCount + $this->getOrbitCount($this->spaceMap[$orbitName]);
		}
		$orbitCount = $orbitCount + count($source->directOrbits);
		return $orbitCount;
	}

	/**
	 * @param \App\AOC\SpaceObject $object
	 *
	 * @return string
	 */
	private function getPathToCom(SpaceObject $object): string {
		$path = $object->name;
		if($object->name !== 'COM') {
			$path .= '-' . $this->getPathToCom($this->spaceMap[$object->parentObject]);
		}

		return $path;
	}

}

namespace App\AOC;

final class SpaceObject {
	/** @var string[] $directOrbit */
	public $directOrbits;

	/** @var string|null */
	public $parentObject;

	/** @var string $name */
	public $name;

	public function __construct($name) {
		$this->name = $name;
		$this->directOrbits = [];
		$this->parentObject = null;
	}

	public function addOrbit(string $spaceObjectName): void {
		$this->directOrbits[$spaceObjectName] = $spaceObjectName;
	}

	public function setParentObject(string $parentObjectName) {
		$this->parentObject = $parentObjectName;
	}
}
