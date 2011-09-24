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
						3 => array(7,null,9, 8,2,4 ,null,6,1),
						4 => array(null,4,1, 6,9,5 ,8,7,3),
						5 => array(6,null,5, 1,null,null,  4,9,2),
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
		$this->assertContains(3, $missingNumbers, "Missing Numbers doesn't contain '3'");
		
		$missingPostitions = $missing['postitions'];
		$this->assertTrue(is_array($missingPostitions), "The postitions isn't an array");
		$this->assertEquals(1, sizeof($missingPostitions), "More than one position is empty");
		$this->assertContains(6, $missingPostitions, "Missing Postitions doesn't contain '6'");
	}

	public function testCheckColInvalidColGiven()
	{	
		$this->setExpectedException("InvalidAgrument", "Invalid col number given");
		$puzzle = $this->_getPuzzle();
		$solver = new Solver($puzzle);
		
		$missing = $solver->checkCol(10);
	}
	
	public function testGetMissingNumbersInvalidInput()
	{
		$this->setExpectedException("InvalidAgrument", "Invalid agrument given to getMissingNumbers array expected");
		$puzzle = $this->_getPuzzle();
		$solver = new Solver($puzzle);

		$numbers = $solver->getMissingNumbers(1);
	}
	
	public function testGetMissingNumbers()
	{
		$puzzle = $this->_getPuzzle();
		$solver = new Solver($puzzle);

		$numbers = $solver->getMissingNumbers(array(1,2,4,5,6,7,8,9));
		
		$this->assertTrue(is_array($numbers), "Numbers isn't an array");
		$this->assertContains(3, $numbers, "Doesn't contain 3");
		$this->assertEquals(1, sizeof($numbers), "Numbers doesn't contain only 1 item");
		
	}
	
	public function testCheckColFind2IsRequired()
	{
		$puzzle = $this->_getPuzzle();
		$solver = new Solver($puzzle);
		
		$missing = $solver->checkCol(0);
		$this->assertTrue(is_array($missing), "Missing isn't an array");
		$this->assertEquals(2, sizeof($missing), "There should only be one result");
		$this->assertArrayHasKey("numbers", $missing, "The key 'numbers' doesn't exists in the array");
		$this->assertArrayHasKey("postitions", $missing, "The key 'postitions' doesn't exist in the array");
		$this->assertSame(sizeof($missing['numbers']), sizeof($missing['postitions']), "The number of numbers missing and the number of postitions aren't the same");
		
		$missingNumbers = $missing['numbers'];
		$this->assertTrue(is_array($missingNumbers), "The missing number isn't an array");
		$this->assertEquals(1, sizeof($missingNumbers), "More than one number missing");
		$this->assertContains(2, $missingNumbers, "Missing Numbers doesn't contain '2'");
		
		$missingPostitions = $missing['postitions'];
		$this->assertTrue(is_array($missingPostitions), "The postitions isn't an array");
		$this->assertEquals(1, sizeof($missingPostitions), "More than one position is empty");
		$this->assertContains(4, $missingPostitions, "Missing Postitions doesn't contain '4'");
	}
	
	public function testCheckSquareInvalidInputZero()
	{		
		$this->setExpectedException("InvalidAgrument", "Invalid square number given");
		$puzzle = $this->_getPuzzle();
		$solver = new Solver($puzzle);
		
		$missing = $solver->checkSquare(0);	
	}
	
	public function testCheckSquareInvalidInputTen()
	{		
		$this->setExpectedException("InvalidAgrument", "Invalid square number given");
		$puzzle = $this->_getPuzzle();
		$solver = new Solver($puzzle);
		
		$missing = $solver->checkSquare(10);	
	}
	

	public function testCheckSquareProperInput()
	{		
		$puzzle = $this->_getPuzzle();
		$solver = new Solver($puzzle);
		
		$missing = $solver->checkSquare(1);	
		$this->assertTrue(is_array($missing), "Missing isn't an array");
		$this->assertEquals(2, sizeof($missing), "There should only be one result");
		$this->assertArrayHasKey("numbers", $missing, "The key 'numbers' doesn't exists in the array");
		$this->assertArrayHasKey("postitions", $missing, "The key 'postitions' doesn't exist in the array");
		$this->assertSame(sizeof($missing['numbers']), sizeof($missing['postitions']), "The number of numbers missing and the number of postitions aren't the same");
		
		$missingNumbers = $missing['numbers'];
		$this->assertTrue(is_array($missingNumbers), "The missing number isn't an array");
		$this->assertEquals(1, sizeof($missingNumbers), "More than one number missing");
		$this->assertContains(1, $missingNumbers, "Missing Numbers doesn't contain '2'");
		
		$missingPostitions = $missing['postitions'];
		$this->assertTrue(is_array($missingPostitions), "The postitions isn't an array");
		$this->assertEquals(1, sizeof($missingPostitions), "More than one position is empty");
		
		$missingPostion = $missingPostitions[0];
		$this->assertEquals(1, $missingPostion['col'], "Missing Postitions Col doesn't equal '1'");
		$this->assertEquals(1, $missingPostion['row'], "Missing Postitions Row doesn't equal '1'");
		
		
		$missing = $solver->checkSquare(5);	
		$missingNumbers = $missing['numbers'];
		$this->assertEquals(2, sizeof($missingNumbers), "Doesn't just contain 2 numbers that are missing");
		$this->assertContains(3, $missingNumbers, "Missing Numbers doesn't contain '3'");
		$this->assertContains(7, $missingNumbers, "Missing Numbers doesn't contain '7'");
		
		$missing = $solver->checkSquare(9);	
		$missingNumbers = $missing['numbers'];
		$this->assertEquals(5, sizeof($missingNumbers), "Doesn't just contain 5 numbers that are missing");
		$this->assertContains(1, $missingNumbers, "Missing Numbers doesn't contain '1'");
		$this->assertContains(2, $missingNumbers, "Missing Numbers doesn't contain '2'");
		$this->assertContains(3, $missingNumbers, "Missing Numbers doesn't contain '3'");
		$this->assertContains(6, $missingNumbers, "Missing Numbers doesn't contain '6'");
		$this->assertContains(9, $missingNumbers, "Missing Numbers doesn't contain '9'");
	}
	
	public function testGetNumberInvalidRow()
	{
		$this->setExpectedException("InvalidAgrument", "Invalid row given");		
		$puzzle = $this->_getPuzzle();
		$solver = new Solver($puzzle);
		
		$number = $solver->getNumber(10,0);
	}
	
	public function testGetNumberInvalidCol()
	{
		$this->setExpectedException("InvalidAgrument", "Invalid col given");
		$puzzle = $this->_getPuzzle();
		$solver = new Solver($puzzle);
		
		$number = $solver->getNumber(0,10);		
	}
	
	public function testGetNumber()
	{
		$puzzle = $this->_getPuzzle();
		$solver = new Solver($puzzle);
		
		$number = $solver->getNumber(0,0);
		$this->assertEquals(5, $number);
		
		$number = $solver->getNumber(1,1);
		$this->assertNull($number);
		
		$number = $solver->getNumber(8,8);
		$this->assertEquals(7, $number);
	}
	
	public function testColHasNumberInvalidCol()
	{
		$this->setExpectedException("InvalidAgrument", "Invalid col given");
		$puzzle = $this->_getPuzzle();
		$solver = new Solver($puzzle);
		$solver->colHasNumber(10,1);			
	}
	
	public function testColHasNumberInvalidNumber()
	{
		$this->setExpectedException("InvalidAgrument", "Invalid number given");
		$puzzle = $this->_getPuzzle();
		$solver = new Solver($puzzle);
		$solver->colHasNumber(0,10);
	}
	
	public function testColHasNumberValid()
	{
		$puzzle = $this->_getPuzzle();
		$solver = new Solver($puzzle);
		$numberDoesExist = $solver->colHasNumber(0,1);
		$numberDoesntExist = $solver->colHasNumber(0, 2);
		
		$this->assertTrue($numberDoesExist);
		$this->assertFalse($numberDoesntExist);
	}
	
	public function testRowHasNumberInvalidRow()
	{
		$this->setExpectedException("InvalidAgrument", "Invalid row given");
		$puzzle = $this->_getPuzzle();
		$solver = new Solver($puzzle);
		$solver->rowHasNumber(10,1);
	}
	
	public function testRowHasNumberInvalidNumber()
	{
		$this->setExpectedException("InvalidAgrument", "Invalid number given");
		$puzzle = $this->_getPuzzle();
		$solver = new Solver($puzzle);
		$solver->rowHasNumber(0,10);
	}
	
	public function testRowHasNumberValid()
	{
		$puzzle = $this->_getPuzzle();
		$solver = new Solver($puzzle);
		$numberDoesExist = $solver->rowHasNumber(0,1);
		$numberDoesntExist = $solver->rowHasNumber(0, 3);
		
		$this->assertTrue($numberDoesExist);
		$this->assertFalse($numberDoesntExist);		
	}
	
	public function testSquareAccordingToRowAndColInvalidRow()
	{
		$this->setExpectedException("InvalidAgrument", "Invalid row given");
		$puzzle = $this->_getPuzzle();
		$solver = new Solver($puzzle);
		$solver->squareAccordingToRowAndCol(10,1);
	}
	
	public function testSquareAccordingToRowAndColInvalidCol()
	{
		$this->setExpectedException("InvalidAgrument", "Invalid col given");
		$puzzle = $this->_getPuzzle();
		$solver = new Solver($puzzle);
		$solver->squareAccordingToRowAndCol(1,10);
	}

	public function testSquareAccordingToRowAndColValid()
	{
		$puzzle = $this->_getPuzzle();
		$solver = new Solver($puzzle);
		$squareNumber = $solver->squareAccordingToRowAndCol(1,1);
		$this->assertEquals(1, $squareNumber);
		$squareNumber = $solver->squareAccordingToRowAndCol(0,5);
		$this->assertEquals(2, $squareNumber);
		$squareNumber = $solver->squareAccordingToRowAndCol(0,8);
		$this->assertEquals(3, $squareNumber);
		$squareNumber = $solver->squareAccordingToRowAndCol(5,0);
		$this->assertEquals(4, $squareNumber);
		$squareNumber = $solver->squareAccordingToRowAndCol(5,5);
		$this->assertEquals(5, $squareNumber);
		$squareNumber = $solver->squareAccordingToRowAndCol(5,8);
		$this->assertEquals(6, $squareNumber);
		$squareNumber = $solver->squareAccordingToRowAndCol(8,0);
		$this->assertEquals(7, $squareNumber);
		$squareNumber = $solver->squareAccordingToRowAndCol(8,5);
		$this->assertEquals(8, $squareNumber);
		$squareNumber = $solver->squareAccordingToRowAndCol(8,8);
		$this->assertEquals(9, $squareNumber);	
	}
	
	public function testGetOtherSquaresInvalidNumber()
	{
		$this->setExpectedException("InvalidAgrument", "Invalid square number given");
		$puzzle = $this->_getPuzzle();
		$solver = new Solver($puzzle);
		$solver->getOtherSquares(10);
	}
	
	public function testGetOtherSquaresValid()
	{
		// TODO remove so much code dupilcation.
		$puzzle = $this->_getPuzzle();
		$solver = new Solver($puzzle);
		$otherSquares = $solver->getOtherSquares(1);
		$this->assertEquals(2, sizeof($otherSquares), "Number of types isn't two");
		$this->assertEquals(2, sizeof($otherSquares['rows']), "Number of rows isn't two");
		$this->assertEquals(2, sizeof($otherSquares['cols']), "Number of cols isn't two");
		$this->assertContains(2, $otherSquares['rows'], "Number 2 isn't in rows for square 1");
		$this->assertContains(3, $otherSquares['rows'], "Number 3 isn't in rows for square 1");
		$this->assertContains(4, $otherSquares['cols'], "Number 4 isn't in cols for square 1");
		$this->assertContains(7, $otherSquares['cols'], "Number 7 isn't in cols for square 1");
		
		$otherSquares = $solver->getOtherSquares(2);
		$this->assertContains(1, $otherSquares['rows'], "Number 1 isn't in rows for square 2");
		$this->assertContains(3, $otherSquares['rows'], "Number 3 isn't in rows for square 2");
		$this->assertContains(5, $otherSquares['cols'], "Number 5 isn't in cols for square 2");
		$this->assertContains(8, $otherSquares['cols'], "Number 8 isn't in cols for square 2");
		
		$otherSquares = $solver->getOtherSquares(3);
		$this->assertContains(1, $otherSquares['rows'], "Number 1 isn't in rows for square 3");
		$this->assertContains(2, $otherSquares['rows'], "Number 2 isn't in rows for square 3");
		$this->assertContains(6, $otherSquares['cols'], "Number 6 isn't in cols for square 3");
		$this->assertContains(9, $otherSquares['cols'], "Number 9 isn't in cols for square 3");
		
		$otherSquares = $solver->getOtherSquares(4);
		$this->assertContains(5, $otherSquares['rows'], "Number 5 isn't in rows for square 4");
		$this->assertContains(6, $otherSquares['rows'], "Number 6 isn't in rows for square 4");
		$this->assertContains(1, $otherSquares['cols'], "Number 1 isn't in cols for square 4");
		$this->assertContains(7, $otherSquares['cols'], "Number 7 isn't in cols for square 4");
		
		$otherSquares = $solver->getOtherSquares(5);
		$this->assertContains(4, $otherSquares['rows'], "Number 4 isn't in rows for square 5");
		$this->assertContains(6, $otherSquares['rows'], "Number 6 isn't in rows for square 5");
		$this->assertContains(2, $otherSquares['cols'], "Number 2 isn't in cols for square 5");
		$this->assertContains(8, $otherSquares['cols'], "Number 8 isn't in cols for square 5");
		
		$otherSquares = $solver->getOtherSquares(6);
		$this->assertContains(4, $otherSquares['rows'], "Number 4 isn't in rows for square 6");
		$this->assertContains(5, $otherSquares['rows'], "Number 5 isn't in rows for square 6");
		$this->assertContains(3, $otherSquares['cols'], "Number 3 isn't in cols for square 6");
		$this->assertContains(9, $otherSquares['cols'], "Number 9 isn't in cols for square 6");
		
		$otherSquares = $solver->getOtherSquares(7);
		$this->assertContains(8, $otherSquares['rows'], "Number 8 isn't in rows for square 7");
		$this->assertContains(9, $otherSquares['rows'], "Number 9 isn't in rows for square 7");
		$this->assertContains(1, $otherSquares['cols'], "Number 1 isn't in cols for square 7");
		$this->assertContains(4, $otherSquares['cols'], "Number 4 isn't in cols for square 7");
		
		$otherSquares = $solver->getOtherSquares(8);
		$this->assertContains(7, $otherSquares['rows'], "Number 7 isn't in rows for square 8");
		$this->assertContains(9, $otherSquares['rows'], "Number 9 isn't in rows for square 8");
		$this->assertContains(2, $otherSquares['cols'], "Number 2 isn't in cols for square 8");
		$this->assertContains(5, $otherSquares['cols'], "Number 5 isn't in cols for square 8");
		
		$otherSquares = $solver->getOtherSquares(9);
		$this->assertContains(7, $otherSquares['rows'], "Number 7 isn't in rows for square 9");
		$this->assertContains(8, $otherSquares['rows'], "Number 8 isn't in rows for square 9");
		$this->assertContains(3, $otherSquares['cols'], "Number 3 isn't in rows for square 9");
		$this->assertContains(6, $otherSquares['cols'], "Number 6 isn't in rows for square 9");
	}
	
	public function testGetSquareRowsAndColsInvalidNumber()
	{
		$this->setExpectedException("InvalidAgrument", "Invalid square number given");
		$puzzle = $this->_getPuzzle();
		$solver = new Solver($puzzle);
		$solver->getSquareColsAndRows(10);
	}
	
	public function testGetSquareRowsAndColsValid()
	{
		$puzzle = $this->_getPuzzle();
		$solver = new Solver($puzzle);
		$gird = $solver->getSquareColsAndRows(1);
		
		$this->assertEquals(2, sizeof($gird));
		$this->assertArrayHasKey('rows', $gird);
		$this->assertArrayHasKey('cols', $gird);
		$this->assertEquals(3, sizeof($gird['rows']));
		$this->assertEquals(3, sizeof($gird['cols']));
		$this->assertContains(0, $gird['rows']);
		$this->assertContains(1, $gird['rows']);
		$this->assertContains(2, $gird['rows']);
		$this->assertContains(0, $gird['cols']);
		$this->assertContains(1, $gird['cols']);
		$this->assertContains(2, $gird['cols']);
	}
	
	public function testLocationOfNumberInvalidSquareNumberGiven()
	{
		$this->setExpectedException("InvalidAgrument", "Invalid square number given");
		$puzzle = $this->_getPuzzle();
		$solver = new Solver($puzzle);
		$solver->locationOfNumberInSquare(10,1,'rows');
	}
	
	public function testLocationOfNumberInvalidNumberGiven()
	{
		$this->setExpectedException("InvalidAgrument", "Invalid number given");
		$puzzle = $this->_getPuzzle();
		$solver = new Solver($puzzle);
		$solver->locationOfNumberInSquare(1,10,'rows');
	}
	
	public function testLocationOfNumberInvalidTypeGiven()
	{
		$this->setExpectedException("InvalidAgrument", "Invalid type given");
		$puzzle = $this->_getPuzzle();
		$solver = new Solver($puzzle);
		$solver->locationOfNumberInSquare(1,1,'n/a');
	}
	
	public function testLocationOfNumberValidButMissing()
	{		
		$puzzle = $this->_getPuzzle();
		$solver = new Solver($puzzle);
		$location = $solver->locationOfNumberInSquare(1,1,'rows');
		$this->assertEquals('missing', $location);
	}

	public function testLocationOfNumberValidAndPresentRow()
	{		
		$puzzle = $this->_getPuzzle();
		$solver = new Solver($puzzle);
		$location = $solver->locationOfNumberInSquare(1,2,'rows');
		$this->assertEquals('top', $location);
		$location = $solver->locationOfNumberInSquare(1,4,'rows');
		$this->assertEquals('middle', $location);
		$location = $solver->locationOfNumberInSquare(1,3,'rows');
		$this->assertEquals('bottom', $location);
	}
	
	public function testLocationOfNumberValidAndPresentCol()
	{
		$puzzle = $this->_getPuzzle();
		$solver = new Solver($puzzle);
		$location = $solver->locationOfNumberInSquare(1,2,'cols');
		$this->assertEquals('center', $location);
		$location = $solver->locationOfNumberInSquare(1,4,'cols');
		$this->assertEquals('left', $location);
		$location = $solver->locationOfNumberInSquare(1,3,'cols');
		$this->assertEquals('right', $location);
	}
	
	public function testGetMissingLocationInvalidSquareNumber()
	{
		$this->setExpectedException("InvalidAgrument", "Invalid square number given");
		$puzzle = $this->_getPuzzle();
		$solver = new Solver($puzzle);
		$location = $solver->getMissingLocation(10,1);
	}
	
	public function testGetMissingLocationInvalidNumber()
	{
		$this->setExpectedException("InvalidAgrument", "Invalid number given");
		$puzzle = $this->_getPuzzle();
		$solver = new Solver($puzzle);
		$location = $solver->getMissingLocation(1,10);
	}
	
	public function testGetMissingLocationValid()
	{		
		$puzzle = $this->_getPuzzle();
		$solver = new Solver($puzzle);
		$location = $solver->getMissingLocation(7,4);
		$this->assertTrue(is_array($location));
		$this->assertEquals(2,sizeof($location));
		$this->assertArrayHasKey('cols', $location);
		$this->assertArrayHasKey('rows', $location);
		$this->assertEquals('right', $location['cols']);
		$this->assertEquals('top', $location['rows']);
	}
	
}