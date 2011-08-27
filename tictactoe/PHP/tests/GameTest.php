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
}
 
