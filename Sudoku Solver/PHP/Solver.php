<?php

require_once '../Exceptions.php';

class Solver
{
	protected $_puzzle;
	
	public function __construct($puzzle = array())
	{
		if (empty($puzzle)) {
			throw new InvalidAgrument("Empty Puzzle given to the constructor");
		}
		
		if (sizeof($puzzle) !== 9) {
			throw new InvalidAgrument("Puzzle given to the constructor doesn't have 9 rows");
		}
		
		for ($i = 0; $i < 9; $i++) {
			if (!is_array($puzzle[$i])) {
				throw new InvalidAgrument("Puzzle given to the constructor isn't an array filled with arrays");
			}
			if (sizeof($puzzle[$i]) !== 9) {
				throw new InvalidAgrument("Puzzle given to the constructor doesn't have 9 cols in all the rows");
			}
		}
		
		$this->_puzzle = $puzzle;
	}
	
	public function checkRow($row) 
	{	
		if (!isset($this->_puzzle[$row])) {
			throw  new InvalidAgrument("Invalid row number given");
		}
		
		$foundNumbers = array();
		$missingNumbers = array();
		$postitions = array();
		
		for ($col = 0; $col < 9; $col++) {
			if ($this->_puzzle[$row][$col] === null) {
				$postitions[] = $col;
			} else {
				$foundNumbers[] = $this->_puzzle[$row][$col];
			}	
		}
		
		$missingNumbers = $this->getMissingNumbers($foundNumbers);
		
		return array('numbers' => $missingNumbers,
					 'postitions' => $postitions);
	}

	public function getMissingNumbers($foundNumbers) 
	{
		if (!is_array($foundNumbers)) {
			throw new InvalidAgrument("Invalid agrument given to getMissingNumbers array expected");
		}
		
		$missingNumbers = array();
		for ($number = 1; $number <= 9; $number++) {
			if (!in_array($number, $foundNumbers)) {
				$missingNumbers[] = $number;
			}
		}
		return $missingNumbers;
	}
	
	public function checkCol($col) 
	{
		
		$foundNumbers = array();
		$missingNumbers = array();
		$postitions = array();
		
		foreach ($this->_puzzle as $rowNum => $row) {
			if (!array_key_exists($col,$row)) {
				throw new InvalidAgrument("Invalid col number given");
			}
			
			if ($row[$col] === NULL) {
				$postitions[] = $rowNum;
			} else {
				$foundNumbers[] = $row[$col];
			}
		}
		
		$missingNumbers = $this->getMissingNumbers($foundNumbers);
		
		return array('numbers' => $missingNumbers,
					 'postitions' => $postitions);
	}
}