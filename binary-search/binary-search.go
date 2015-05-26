package main

import (
  "fmt"
  "math"
)

func binary_search(haystack []int, needle int) int {
  return binary_search_int(haystack, needle, 0, len(haystack))
}

func binary_search_int(haystack []int, needle int, startPoint int, endPoint int) int {

    diff := endPoint - startPoint
    jump :=  int(math.Floor(float64(diff / 2)))
    searchKey := startPoint + jump

    item := haystack[searchKey]
    if (item == needle) {
      return searchKey
    } else if (item > needle) {
      return binary_search_int(haystack, needle, startPoint, searchKey - 1)
    }

    return binary_search_int(haystack, needle, searchKey + 1, endPoint)

}

func main() {
    numbers := []int{1,2,3,4,5,6,7,8,9,10}
    needle := 4
    searchKey := binary_search(numbers, needle)
    fmt.Println(fmt.Sprintf("Number %d found at %d", needle, searchKey))

}
