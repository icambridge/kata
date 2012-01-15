fizzBuzz := Object clone;
fizzBuzz run := for(x, 0, 100, 1, 
	if(x % 15 == 0, "FizzBuzz" println;continue);
	if(x % 5 == 0, "Buzz" println;continue);
	if(x % 3 == 0, "Fizz" println;continue);
	x println
);
fizzBuzz run