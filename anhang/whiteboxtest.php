<?php


// Die Function überprüft op die zahl ($zahl) gerade ist.
// Wenn die Zahl ohne Rest durch 2 teilbar ist ($zahl % 2 == 0),
// wird true zurückgegeben.
// Andernfalls wird false zurückgegeben.
function ist_gerade($zahl)
{
    if ($zahl % 2 == 0) {
        return true;
    } else {
        return false;
    }
}

// Wir werden 3 tests machen :

//Test 1: Überprüfen, ob eine gerade Zahl true zurückgibt.
assert(ist_gerade(4) === true); // Erwartet true
//Test 2: Überprüfen, ob eine ungerade Zahl false zurückgibt
assert(ist_gerade(3) === false); // Erwartet false
//Test 3: Überprüfen mit Null (Sonderfall, sollte true zurückgeben).
assert(ist_gerade(0) === true); // Erwartet true

echo "Alle tests bestanden";