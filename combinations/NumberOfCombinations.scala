
def factorial(number: Int) = {
  1.to(number).reduceRight(_ * _) 
}

val numberOfItems        = 10
val numberInSet          = 3

val numberOfCombinations = factorial(numberOfItems) / (factorial(numberInSet) * factorial(numberOfItems - numberInSet))

println(numberOfCombinations)
