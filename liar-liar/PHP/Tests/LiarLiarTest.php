<?php
require '../LiarLiar.php';

class LiarLiarTest extends PHPUnit_Framework_TestCase 
{
	protected $filename;
	
	
	public function setUp()
	{	
		// Same file used on the facebook puzzle specs
		$this->filename = time().".txt";
		$fp = fopen($this->filename, "w+");
		fwrite($fp, "5".PHP_EOL);
		fwrite($fp, "Stephen   1".PHP_EOL);
		fwrite($fp, "Tommaso".PHP_EOL);
		fwrite($fp, "Tommaso   1".PHP_EOL);
		fwrite($fp, "Galileo".PHP_EOL);
		fwrite($fp, "Isaac     1".PHP_EOL);
		fwrite($fp, "Tommaso".PHP_EOL);
		fwrite($fp, "Galileo   1".PHP_EOL);
		fwrite($fp, "Tommaso".PHP_EOL);
		fwrite($fp, "George    2".PHP_EOL);
		fwrite($fp, "Isaac".PHP_EOL);
		fwrite($fp, "Stephen");		
	}
	
	public function tearDown()
	{
		unlink($this->filename);
	}
	
	public function testNoInputFile()
	{
		$this->setExpectedException("InvalidAgrument", "No input file was provided.");
		$liarLiar = new LiarLiar();
	}
	
	public function testInputFileDoesntExist()
	{
		$this->setExpectedException("InvalidAgrument", "Input file doesn't exist.");
		$liarLiar = new LiarLiar("Input file doesn't exist.");
	}
	
	public function testInputFileDoesExistAndgetUserCountWorks()
	{
		$liarLiar = new LiarLiar($this->filename);
		$userCount = $liarLiar->getUserCount();
		$this->assertEquals(5, $userCount, "User count doesn't match what the test file should have.");
	}
	
	public function testReadsAllUsernames()
	{
		$liarLiar = new LiarLiar($this->filename);
		$userList = $liarLiar->getUserList();
		$userCount = $liarLiar->getUserCount();
		
		$this->assertEquals($userCount, sizeof($userList), "The number of users provided in the user list doesn't match those stated in the input file");
		
		foreach ( array("Tommaso", "George", "Isaac", "Stephen", "Galileo") as $name ){
			$this->assertContains($name,$userList, "The name '".$name."' isn't in the user list that was returned.");
		}
		
	}
	
	public function testThatUserWhoDoesntReplyIsTruthful()
	{
		$liarLiar = new LiarLiar($this->filename);		
		$truthfulUsers = $liarLiar->getTruthfulUsers();
		
		$this->assertContains("George", $truthfulUsers, "George isn't in the list of truthful users");		
	}
	
	public function testThatUsersWhoVotedForUserWhoDoesntReplyIsLiar()
	{
		$liarLiar = new LiarLiar($this->filename);
		$liarUsers = $liarLiar->getLyingUsers();
		
		foreach( array("Isaac", "Stephen") as $name ) {
			$this->assertContains($name, $liarUsers, "The name '".$name."' isn't in the user list that was return with liars in it.");
		}
	}
	
	public function testThatUserwhoVotedForLiarsIsTruthful()
	{
		$liarLiar = new LiarLiar($this->filename);
		$truthfulUsers = $liarLiar->getTruthfulUsers();
		
		$this->assertContains("Tommaso", $truthfulUsers, "Tommaso isn't in the list of truthful users");
	}
	
	public function testThatUserWhoVotedForTruthfulUserIsNowALiar()
	{
		$liarLiar = new LiarLiar($this->filename);
		$lyingUsers = $liarLiar->getLyingUsers();
		
		$this->assertContains("Galileo", $lyingUsers, "Galileo isn't in the list of lying users");
	}
	
	public function testThatRequiredOutputIs3Space2()
	{
		$liarLiar = new LiarLiar($this->filename);
		$output = $liarLiar->getRequiredOutput();
		
		$this->assertEquals("3 2",$output,"The required output isn't '3 2'");
	}
}