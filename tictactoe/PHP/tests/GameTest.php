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
}
 
