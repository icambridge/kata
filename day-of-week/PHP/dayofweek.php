<?php
date_default_timezone_set("Europe/London");
/**
 * Simple function to find out which day of the week it is. 
 *
 * @param $date the date you wish to find out what day of the week it was.
 * @return string
 */

function kataDayOfWeek($date)
{
    if (!is_string($date)){
        return false;
    }

    $unixTimeStamp = strtotime($date);

    if ($unixTimeStamp === false) {
        return false;
    }

    $dayOfWeek = date("l",$unixTimeStamp);

    return $dayOfWeek;
}