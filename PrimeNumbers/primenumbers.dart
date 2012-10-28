main() {
    int total    = 100;
    var notPrime = [];
    for (int a = 2; a < total; a++) {
       if (-1 != notPrime.indexOf(a)) {
         continue;
       }
       for (int b = (a+1); b < total; b++) {
           if ((b % a) == 0) {
              notPrime.add(b);
           }
       }

    }



    for (int a = 1; a < total; a++) {
        if (-1 == notPrime.indexOf(a)) {
            print(a);
        }
    }

}