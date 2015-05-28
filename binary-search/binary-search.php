<?php
// Define keys to illustrate the correct key is being returned.
$numbers = [
    0 => 1,
    1 => 2,
    2 => 3,
    3 => 4,
    4 => 5,
    5 => 6,
    6 => 7,
    8 => 9,
    9 => 10,
    10 => 11,
];

/**
 * Finds the needle in the haystack and returns the key.
 *
 * @param array $haystack
 * @param int $needle
 * @param int $startPoint
 * @param int $endPoint
 * @return int
 */
function binarySearch(array $haystack, $needle, $startPoint = 0, $endPoint = -1)
{
    if ($endPoint === -1) {
        $endPoint = sizeof($haystack) -1;
    }

    $diff =  $endPoint - $startPoint;
    $jump = (int) floor($diff / 2);
    $searchKey = $startPoint +  $jump;
    $item = $haystack[$searchKey];

    if ($needle === $item) {
        return $searchKey;
    } elseif ($item > $needle) {
      return binarySearch($haystack, $needle, $startPoint, $searchKey -1);
    } else {
      return binarySearch($haystack, $needle, $searchKey + 1, $endPoint);
    }
}

var_dump(binarySearch($numbers, 4));
