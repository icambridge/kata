<?php
// Based on what I understood from wikipedia. :S
// This is probably done horribly horribly wrong/badly.
function selection_sort(array $items) {

	$turns = sizeof($items) - 1;
	for ($startingKey = 0; $startingKey < $turns; $startingKey++) {
		$lowestKey = $startingKey;
		$lowestValue = $items[$startingKey];
		for ($key = $startingKey+1; $key < sizeOf($items); $key++) {
			if ($items[$key] < $lowestValue) {
				$lowestValue = $items[$key];
				$lowestKey = $key;
			}
		}
		if ($lowestKey != $startingKey) {
			$temp = $items[$startingKey];
			$items[$startingKey] = $items[$lowestKey];
			$items[$lowestKey] = $temp;
		}
	} 


	return $items;
}

