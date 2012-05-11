#!/usr/bin/env Rscript

for (i in seq(from=1, to=100,by=1)) {
  if (i %% 15 == 0){ 
    print("FizzBuzz")
  } else if (i %% 3 == 0) {
    print("Fizz")
  } else if (i %% 5 == 0) {
    print("Buzz")
  } else {
    print(i)
  }
}