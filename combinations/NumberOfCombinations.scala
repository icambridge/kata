def factorial(number: Int) = {
  1.to(number).reduceRight(_ * _) 
}

def getNumberOfCombinations(numberOfItems: Int, numberInSet: Int ) = {
    val numberOfCombinations = factorial(numberOfItems) / (factorial(numberInSet) * 
                                                           factorial(numberOfItems - numberInSet))
    numberOfCombinations
}

println(getNumberOfCombinations(10,3))