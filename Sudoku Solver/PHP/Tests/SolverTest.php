<?php
require_once '../Solver.php';

class SolverTest extends PHPUnit_Framework_TestCase
{
	public function testInvalidEmptyConstructor()
	{
		$this->setExpectedException("InvalidAgrument", "Empty Puzzle given to the constructor");
		$solver = new Solver();
	}
	
	public function testInvalidPuzzleNot9RowsConstructor()
	{
		$this->setExpectedException("InvalidAgrument", "Puzzle given to the constructor doesn't have 9 rows");
		$puzzle = array(0 => array(null,null,null,null,null,null,null,null,null),
						1 => array(null,null,null,null,null,null,null,null,null));
		$solver = new Solver($puzzle);				
	}
	
	public function testInvalidPuzzleItemsNotArraysGivenToConstructor()
	{
		$this->setExpectedException("InvalidAgrument", "Puzzle given to the constructor isn't an array filled with arrays");
		$puzzle = array(0 => null,
						1 => null,
						2 => null,
						3 => null,
						4 => null,
						5 => null,
						6 => null,
						7 => null,
						8 => null
					);
		$solver = new Solver($puzzle);
	}
	
	public function testInvalidPuzzleNot9ColsGivenToConstructor()
	{
		$this->setExpectedException("InvalidAgrument", "Puzzle given to the constructor doesn't have 9 cols in all the rows");
		$puzzle = array(0 => array(null,null,null,null,null,null,null,null,null),
						1 => array(null,null,null,null,null,null,null,null,null),
						2 => array(null,null,null,null,null,null,null,null,null),
						3 => array(null,null,null,null,null,null,null,null,null),
						4 => array(null,null,null,null,null,null,null,null,null),
						5 => array(null,null,null,null,null,null,null,null,null),
						6 => array(null,null,null,null,null,null,null,null),
						7 => array(null,null,null,null,null,null,null,null,null),
						8 => array(null,null,null,null,null,null,null,null,null)
					);
		$solver = new Solver($puzzle);				
	}
	
	public function testValidPuzzleSizeGivenToConstructor()
	{
		$puzzle = array(0 => array(null,null,null,null,null,null,null,null,null),
						1 => array(null,null,null,null,null,null,null,null,null),
						2 => array(null,null,null,null,null,null,null,null,null),
						3 => array(null,null,null,null,null,null,null,null,null),
						4 => array(null,null,null,null,null,null,null,null,null),
						5 => array(null,null,null,null,null,null,null,null,null),
						6 => array(null,null,null,null,null,null,null,null,null),
						7 => array(null,null,null,null,null,null,null,null,null),
						8 => array(null,null,null,null,null,null,null,null,null)
					);
		$solver = new Solver($puzzle);		
	}
	
	protected function _getPuzzle()
	{
		return array(0 => array(5,2,7,4,6,1,null,8,9),
						1 => array(4,null,6,null,null,8,7,null,5),
						2 => array(8,9,3,null,5,7,6,1,4),
						3 => array(7,null,9,8,2,4,null,6,1),
						4 => array(null,4,1,6,9,5,8,7,3),
						5 => array(6,null,5,1,null,null,4,9,2),
						6 => array(1,7,null,3,8,2,null,5,null),
						7 => array(9,5,null,null,4,6,null,null,8),
						8 => array(3,6,8,5,1,9,null,4,7)
					);	
	}
	
	public function testCheckRowInvalidRowGiven()
	{	
		$this->setExpectedException("InvalidAgrument", "Invalid row number given");
		$puzzle = $this->_getPuzzle();
		$solver = new Solver($puzzle);
		
		$missing = $solver->checkRow(10);
	}
	
	public function testCheckRowFind3IsRequired()
	{	
		$puzzle = $this->_getPuzzle();
		$solver = new Solver($puzzle);
		
		$missing = $solver->checkRow(0);
		$this->assertTrue(is_array($missing), "Missing isn't an array");
		$this->assertEquals(2, sizeof($missing), "There should only be one result");
		$this->assertArrayHasKey("numbers", $missing, "The key 'numbers' doesn't exists in the array");
		$this->assertArrayHasKey("postitions", $missing, "The key 'postitions' doesn't exist in the array");
		$this->assertSame(sizeof($missing['numbers']), sizeof($missing['postitions']), "The number of numbers missing and the number of postitions aren't the same");
		
		$missingNumbers = $missing['numbers'];
		$this->assertTrue(is_array($missingNumbers), "The missing number isn't an array");
		$this->assertEquals(1, sizeof($missingNumbers), "More than one number missing");
		$this->assertContains(3, $missingNumbers, "Missing Numbers doesn't contain '2'");
		
		$missingPostitions = $missing['postitions'];
		$this->assertTrue(is_array($missingPostitions), "The postitions isn't an array");
		$this->assertEquals(1, sizeof($missingPostitions), "More than one position is empty");
		$this->assertContains(6, $missingPostitions, "Missing Postitions doesn't contain '9'");
	}
}