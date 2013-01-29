<?php

function bubble_sort(array $items) {

	$endPoint = sizeof($items) - 1;

	do {
		
		for ($counter = 0; $counter < $endPoint; $counter++) {
			$nextCounter = $counter + 1;
			if ($items[$counter] > $items[$nextCounter]) {
				$temp = $items[$counter];
				$items[$counter] = $items[$nextCounter];
				$items[$nextCounter] = $temp;
			}
		}
		$endPoint--;		
	} while ($endPoint != 0);
	return $items;
}

