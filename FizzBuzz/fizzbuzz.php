<?php

for ($i = 1; $i < 100; $i++) {
	if ( ($i % 15) == 0 ){
		print 'FizzBuzz';
	} elseif ( ($i % 3) == 0) {
		print 'Fizz';
	} elseif ( ($i % 5) == 0) {
		print 'Buzz';
	} else {
		print $i;
	}
	print PHP_EOL;
}