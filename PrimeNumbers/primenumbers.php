<?php
$rulledOut = array();
$limit = 1000;

for ( $start = 2; $start <= $limit; $start++ ){
	for ($acclumator = $start+1; $acclumator <= $limit; $acclumator++) {
		if (in_array($acclumator, $rulledOut)) {
			continue;
		}
		if (($acclumator % $start) == 0 && $acclumator !== $start) {
			$rulledOut[] = $acclumator;
		}		
	}
	
}

for ( $start = 2; $start <= $limit; $start++  ) {
	if (!in_array($start, $rulledOut)) {
		print $start.PHP_EOL;
	}
}