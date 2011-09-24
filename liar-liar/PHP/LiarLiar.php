<?php

require_once 'Exceptions.php';

/**
 * A solution to the liar liar puzzle on facebook.com/careers/puzzles.php
 * 
 * @author Iain Cambridge
 * @copyright Iain Cambridge All rights Reserved.
 */
class LiarLiar 
{
	/**
     * @var string the contents from the file that was provided.
	 */
	protected $fileContents;
	/**
	 * @var boolean true or false value stating if the file has been processed, lazy loading in action.
	 */
	protected $beenProcessed = false;
	/**
     * @var integer The number of users that have been stated in the input file.
	 */
	protected $userCount;
	/**
	 * @var array A list of users that have been provided in the input file.
	 */
	protected $userList = array();
	/**
	 * @var array The array saying who voted for who.
	 */
	protected $votedBy = array();
	/**
	 * 
	 * @var array The array saying who users have voted for
	 */
	protected $votedFor = array();
	/**
	 * @var array The array containing users who are deemed to be truthful.
	 */	
	protected $truthfulUsers = array();
	/**
	 * @var array The array containg users who are deemed to be liars.
	 */
	protected $liarUsers = array();
	/**
	 * @var array The array containing users who have been processed either truthful or liars
	 */
	protected $processedUsers = array();
	
	
	/**
	 * Constructor for the class checks to see if a filename has been 
	 * passed and that it is a valid file, if so reads the file 
	 * contents if not throws an exception.
	 * 
	 * @param string $filename
	 * @throws InvalidAgrument
	 */
	
	public function __construct($filename = null)
	{
		if (empty($filename)) {
			throw new InvalidAgrument("No input file was provided.");
		}
	
		if (!file_exists($filename)) {
			throw new InvalidAgrument("Input file doesn't exist.");
		}
	
		$this->fileContents = file_get_contents($filename);
		
	}
	
	protected function _processFile()
	{
		if ($this->beenProcessed === true) {
			return;
		}
		
		$lines = explode(PHP_EOL, $this->fileContents);
		$this->userCount = (int) $lines[0];
		$userVotedFor = false;
		
		for ($i = 1; $i < sizeof($lines); $i++) {
			
			$parts = explode(" ", $lines[$i], 2);
			
			$name = trim($parts[0]) ;
			
			if (!in_array($name, $this->userList)) {
				$this->userList[] = $name;
				$this->votedFor[$name] = array();
				$this->votedBy[$name] = array();
			}
			if (sizeof($parts) === 1) {				
				$this->votedBy[$userVotedFor][] = $name;
				$this->votedFor[$name][] = $userVotedFor;		
			} elseif (sizeof($parts) === 2) {
				$userVotedFor = $name;	
			}
		}
		unset($name);
		unset($parts);
		unset($userVotedFor);		
		
		foreach ($this->userList as $name) {			
			if (sizeof($this->votedFor[$name]) === 0){
				$this->truthfulUsers[] = $name;
				$this->processedUsers[] = $name;
			}
		}
		unset($name);
		
		do {
			foreach ($this->truthfulUsers as $honestUser) {
				foreach ($this->votedBy[$honestUser] as $lyingUser) {
					if (!in_array($lyingUser,$this->processedUsers)) {
						$this->liarUsers[] = $lyingUser;
						$this->processedUsers[] = $lyingUser;
					}
				}
				
			}
			unset($honestUser);
			unset($lyingUser);
			
			foreach ($this->liarUsers as $lyingUser) {
				foreach ($this->votedBy[$lyingUser] as $honestUser) {
					if (!in_array($honestUser, $this->processedUsers)) {
						$this->truthfulUsers[] = $honestUser;
						$this->processedUsers[] = $honestUser;
					}
				}
			}
		} while(sizeof($this->processedUsers) != $this->userCount);
		
		$this->beenProcessed = true;
		
		return;
	}
	
	public function getUserCount()
	{
		$this->_processFile();
		
		return $this->userCount;
	}
	
 	public function getUserList()
 	{
 		$this->_processFile();
 		
 		return $this->userList;
 	}
 	
 	public function getTruthfulUsers()
 	{
 		$this->_processFile();
 	
 		return $this->truthfulUsers;
 	}
 	
 	public function getLyingUsers()
 	{
 		$this->_processFile();
 		
 		return $this->liarUsers;
 	}
 	
 	public function getRequiredOutput()
 	{
 		$this->_processFile();
 		
 		$numberOfHonestUsers = sizeof($this->truthfulUsers);
 		$numberOfLyingUsers = sizeof($this->liarUsers);
 		
 		if ($numberOfHonestUsers > $numberOfLyingUsers) {
 			return $numberOfHonestUsers." ".$numberOfLyingUsers;	
 		} else {
 			return $numberOfLyingUsers." ".$numberOfHonestUsers;
 		}
 		
 	}
}