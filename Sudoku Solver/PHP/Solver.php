<?php

require_once '../Exceptions.php';

class Solver
{
	protected $_puzzle;
	protected $_tmpNumber;
	
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
	
	public function checkSquare($squareNumber)
	{
		if ($squareNumber < 1 || $squareNumber > 9) {
			throw new InvalidAgrument("Invalid square number given");
		}
		
		$postitions = array();
		$foundNumbers = array();
		$gird = $this->getSquareColsAndRows($squareNumber);
		extract($gird);
		
		foreach ($rows as $row) {
			foreach ($cols as $col) {
				if ($this->_puzzle[$row][$col] === NULL) {
					$postitions[] = array('row' => $row, 
										 'col' => $col); 
				} else {
					$foundNumbers[] = $this->_puzzle[$row][$col];
				}
			}
		}
		
		$missingNumbers = $this->getMissingNumbers($foundNumbers);
		
		return array('numbers' => $missingNumbers,
					 'postitions' => $postitions);
	}
	
	public function getNumber($row, $col)
	{
		if (!isset($this->_puzzle[$row])) {
			throw new InvalidAgrument("Invalid row given");
		}
		
		if (!array_key_exists($col, $this->_puzzle[$row])) {
			throw new InvalidAgrument("Invalid col given");
		}
		
		return $this->_puzzle[$row][$col];
	}
	
	public function colHasNumber($col, $number)
	{
		if ($number < 0 || $number > 8) {
			throw new InvalidAgrument("Invalid number given");
		}
		
		foreach($this->_puzzle as $rowNum => $row) {
			if (!array_key_exists($col,$row)) {
				throw new InvalidAgrument("Invalid col given");
			}
			
			if ($row[$col] === $number) {
				return true;
			}
		}
		
		return false;
	}
	
	public function rowHasNumber($row, $number)
	{
		if ($number < 0 || $number > 8) {
			throw new InvalidAgrument("Invalid number given");
		}
		
		if (!isset($this->_puzzle[$row])) {
			throw new InvalidAgrument("Invalid row given");
		}
		
		foreach($this->_puzzle[$row] as $col) {
			if ($col === $number) {
				return true;
			}
		}
		
		return false;
	}
	
	public function squareAccordingToRowAndCol($row, $col)
	{
		if (!isset($this->_puzzle[$row])) {
			throw new InvalidAgrument("Invalid row given");
		}
		
		if (!array_key_exists($col,$this->_puzzle[$row])) {
			throw new InvalidAgrument("Invalid col given");
		}
		$start = array(0,3,6);
		foreach ($start as $startNum) {
			$endNum = $startNum+2;
			if ($row >= $startNum &&  $row <= $endNum) { 
				if ($col >= 0 && $col <= 2) {
					$returnNumber = $startNum+1;
				} elseif ($col >= 3 && $col <= 5) {
					$returnNumber = $startNum+2;
				} elseif ($col >= 6 && $col <= 8) {
					$returnNumber = $startNum+3;
				}
			} 
		}
		
		return $returnNumber;
	}
	
	public function getOtherSquares($number)
	{
		if ($number < 1 || $number > 9) {
			throw new InvalidAgrument("Invalid square number given");
		}
		$squares = array();
		$squares['rows'] = array( range(1,3),
							 range(4,6),
							 range(7,9));
		$squares['cols'] = array( array(1,4,7),
							 array(2,5,8),
							 array(3,6,9));
							 
		$output = array();					 
		$squareKey = 0;
		$this->_tmpNumber = $number;
		foreach ($squares as $type => $squareSet) {
			foreach($squareSet as $numbers) {
				if (in_array($number,$numbers)) {
					$output[$type] = array_filter($numbers, array($this, '_checkTheNumbersAreTheSame'));
				}
			}
		}
		$this->_tmpNumber = 0;
		return $output;
	}
	
	public function _checkTheNumbersAreTheSame($val)
	{
		return ($val !== $this->_tmpNumber);
	}
	
	public function getSquareColsAndRows($squareNumber)
	{
		if ($squareNumber < 1 || $squareNumber > 9) {
			throw new InvalidAgrument("Invalid square number given");
		}
		
		$output = array();
		if ($squareNumber >= 1 && $squareNumber <= 3) {
			$output['rows'] = array(0,1,2);
		} elseif ($squareNumber >= 4 && $squareNumber <= 6) {
			$output['rows'] = array(3,4,5);
		} elseif ($squareNumber >= 7 && $squareNumber <= 9) {
			$output['rows'] = array(6,7,8);
		}
		
		if (in_array($squareNumber, array(1,4,7))) {
			$output['cols'] = array(0,1,2);
		} elseif (in_array($squareNumber, array(2,5,8))) {
			$output['cols'] = array(3,4,5);
		} elseif (in_array($squareNumber, array(3,6,9))) {
			$output['cols'] = array(6,7,8);
		}
		return $output;
	}
	
	public function locationOfNumberInSquare($squareNumber, $number, $type) 
	{
		if ($squareNumber < 1 || $squareNumber > 9) {
			throw new InvalidAgrument("Invalid square number given");
		}
		
		if ($type != "row" && $type != "col") {
			throw new InvalidAgrument("Invalid type given");
		}
		
		if ($number < 1 || $number > 9) {
			throw new InvalidAgrument("Invalid number given");
		}
		
		$girdNumbers = $this->getSquareColsAndRows($squareNumber);
		$found = false;
		
		foreach ($girdNumbers['rows'] as $rowKey => $rowNum ) {
			foreach ($girdNumbers['cols'] as $colKey => $colNum) {
				if ($this->_puzzle[$rowNum][$colNum] === $number) {
					$found = true;
					break 2;
				}
			}
		}
		if ($found == true) {
			if ($type == "row") {
				if ($rowKey === 0) {
					$type = "top";
				} elseif ($rowKey === 1) {
					$type = "middle";
				} elseif ($rowKey === 2) {
					$type = "bottom";
				}
			} elseif ($type == "col") {
				if ($colKey === 0) {
					$type = "left";
				} elseif ($colKey === 1) {
					$type = "center";
				} elseif ($colKey === 2) {
					$type = "right";
				}
			}
		} else {
			$type = "missing";
		}
		
		return $type;
	}
}