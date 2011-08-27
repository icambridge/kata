<?php

/**
 * 
 *
 * @author Iain Cambridge
 */

class Game
{
    private $layout;

    public function __construct()
    {
        $this->layout = array(0 => array(null,null,null),
                              1 => array(null,null,null),
                              2 => array(null,null,null));
    }

    public function getLayout()
    {
        return $this->layout;
    }
}