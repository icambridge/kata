// You can edit this code!
// Click here and start typing.
package main

import "fmt"

func main() {
	for counter = 1; counter < 100; counter++ {
		if (counter % 15) == 0 {
			fmt.Println("FizzBuzz")
		} else if (counter % 5) == 0 {
                	fmt.Println("Buzz")
                } else if (counter % 3) == 0 {
                	fmt.Println("Fizz")
                } else {
                	fmt.Println(counter)
                }
	}
}
