<?php

require_once "../Game.php";

class GameTest extends PHPUnit_Framework_TestCase
{
    public function testGetCurrentLayout()
    {
        $game = new Game();
        $layout = $game->getLayout();

        $this->assertTrue(is_array($layout), "The layout isn't an array");
        $this->assertEquals(3, sizeof($layout), "The layout doesn't have three accross");
        for ($i = 0; $i <= 2; $i++) {
            $this->assertTrue(isset($layout[$i]),"The layout column ".$i." isn't set");
            $this->assertEquals(3, sizeof($layout[$i]), "The layout column ".$i." doesn't have three high");
        }
    }

    public function testInsertKnot()
    {
        $game = new Game();
        $layout = $game->place('knot',3,1);
        $this->assertTrue(is_array($layout), "The layout isn't an array");
        $this->assertTrue(isset($layout[2][0]), "The bottom right hand corner isn't set");
        $this->assertEquals('knot',$layout[2][0], "The bottom right hand corner doesn't have a knot in it");
    }

    public function testInvalidType()
    {
        $this->setExpectedException("InvalidMove", "'fake' isn't a valid type");
        $game = new Game();
        $game->place("fake",1,1);
    }

    public function testInvalidColumnType()
    {
        $this->setExpectedException("InvalidMove", "Column isn't a valid number.");
        $game = new Game();
        $game->place("cross","FAKE",1);
    }

    public function testInvalidColumnNumber()
    {
        $this->setExpectedException("InvalidMove", "'2323' isn't a valid number for the column, expected between 1 and 3");
        $game = new Game();
        $game->place("cross",2323,1);
    }

    public function testInvalidRowType()
    {
        $this->setExpectedException("InvalidMove", "Row isn't a valid number.");
        $game = new Game();
        $game->place("cross",1,"FAKE");
    }

    public function testInvalidRowNumber()
    {
        $this->setExpectedException("InvalidMove", "'321' isn't a valid number for the row, expected between 1 and 3");
        $game = new Game();
        $game->place("cross",1,321);
    }

    public function testStringColumnAndRowNumbers()
    {
        $game = new Game();
        $layout = $game->place('knot',"3","1");
        $this->assertTrue(is_array($layout), "The layout isn't an array");
        $this->assertTrue(isset($layout[2][0]), "The bottom right hand corner isn't set");
        $this->assertEquals('knot',$layout[2][0], "The bottom right hand corner doesn't have a knot in it");
    }

    public function testMoveAlreadyDone()
    {
        $this->setExpectedException("InvalidMove", "Column:1, Row:1 isn't empty");
        $game = new Game();
        $game->place("cross",1,1);
        $game->place("knot",1,1);
    }

    public function testOneMoveEachAtATime()
    {
        $this->setExpectedException("InvalidMove", "'knot' move when 'cross' expected");
        $game = new Game();
        $game->place('knot',1,1);
        $game->place('knot',1,2);
    }
}
 
