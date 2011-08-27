<?php

require_once "Exceptions.php";

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

    public function place($type, $column, $row)
    {
        $type = strtolower($type);
        if ($type != "knot" && $type != "cross") {
            throw new InvalidMove("'".$type."' isn't a valid type");
        }

        if (!is_int($column) && !ctype_digit($column)) {
            throw new InvalidMove("Column isn't a number.");
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

        $row--;
        $column--;

        if ($this->layout[$column][$row] !== NULL) {
            throw new InvalidMove("Column:".$column.", Row:".$row." isn't empty");
        }

        $this->layout[$column][$row] = $type;

        return $this->layout;
    }
}