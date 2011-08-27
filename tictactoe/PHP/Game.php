<?php

require_once "Exceptions.php";

/**
 * 
 *
 * @author Iain Cambridge
 */

class Game
{
    protected $layout;

    protected $lastType;

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

    public function place($type, $column, $row)
    {
        $type = strtolower($type);
        if ($type != "knot" && $type != "cross") {
            throw new InvalidMove("'".$type."' isn't a valid type");
        }

        if ($type == $this->lastType) {
            $expected = ($type == 'knot') ? 'cross' : 'knot';
            throw new InvalidMove("'".$type."' move when '".$expected."' expected");
        }

        if (!is_int($column) && !ctype_digit($column)) {
            throw new InvalidMove("Column isn't a valid number.");
        }

        $column = (int) $column;
        if ($column < 1 || $column > 3) {
            throw new InvalidMove("'".$column."' isn't a valid number for the column, expected between 1 and 3");
        }

        if (!is_int($row) && !ctype_digit($row)) {
            throw new InvalidMove("Row isn't a valid number.");
        }

        $row = (int) $row;
        if ($row < 1 || $row > 3) {
            throw new InvalidMove("'".$row."' isn't a valid number for the row, expected between 1 and 3");
        }

        $arrayRow = $row - 1;
        $arrayColumn = $column - 1;

        if ($this->layout[$arrayColumn][$arrayRow] !== NULL) {
            throw new InvalidMove("Column:".$column.", Row:".$row." isn't empty");
        }

        $this->layout[$arrayColumn][$arrayRow] = $type;
        $this->lastType = $type;
        return $this->layout;
    }
}