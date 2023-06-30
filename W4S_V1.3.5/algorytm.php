<?php
function debug_echo($msg) {
	$DEBUG = 1;

	if ($DEBUG) echo '<script>console.log(atob("' . base64_encode("[DEBUG] " . $msg)  . '"));</script>';
}

// Funkcja dopasowania godzin studenta do oferty
function algo_dopasowania_godzin($str_student, $str_oferta) {
	$PROG_ODCHYLKI_MINUTOWEJ = 30;
	$WSPOLCZYNNIK_TOLERANCJI_MINUTOWEJ = 15;
	$WSPOLCZYNNIK_REDUKCJI_POZA_ZAKRESEM = 0.875;

	debug_echo("Algorytm dopasowania");
	debug_echo($str_student);
	debug_echo($str_oferta);

	// Konwertuj z typu string
	$student = explode(";", $str_student);
	$oferta = explode(";", $str_oferta);

	// Rozbij na listę, żeby był dostęp do elementów
	$_student = [];
	foreach ($student as $dzien) $_student = array_merge($_student, explode(",", $dzien));

	$_oferta = [];
	foreach ($oferta as $dzien) $_oferta = array_merge($_oferta, explode(",", $dzien));

	if (sizeof($_oferta) == 2) {
		debug_echo("Oferta: caly tydzien - TODO: interpolacja tabeli zeby sie 7 razy powtarzalo\n");

		$_oferta = array_merge($_oferta, $_oferta, $_oferta, $_oferta, $_oferta, $_oferta, $_oferta);
	} else {
		debug_echo("Oferta: dni osobno - OK\n");
	}

	if (sizeof($_student) == 2) {
		debug_echo("Student: caly tydzien - TODO: interpolacja tabeli zeby sie 7 razy powtarzalo\n\n");

		$_student = array_merge($_student, $_student, $_student, $_student, $_student, $_student, $_student);
	} else {
		debug_echo("Student: dni osobno - OK\n\n");
	}

	$wynik = 0;

	if (sizeof($_student) == sizeof($_oferta)) {
		debug_echo("rozmiary ok");
	} else {
		debug_echo("BLAD NIE TE SAME ILOSCI DNI");
		debug_echo(sizeof($_student). " != " . sizeof($_oferta));
	}

	$PRESCALER = 0;

	for ($i = 1; $i < sizeof($_student); $i += 2) {
		debug_echo($_student[$i] . " " . $_oferta[$i] . "\n");

		// Jeśli w ofercie wolne, to nie liczymy tego dnia
		if ($_oferta[$i] != "wolne") $PRESCALER += 1;

		if (
			($_oferta[$i] == "wolne") // Dzień wolny w ofercie, nie liczymy jako dzień pracy
		) {
			$wynik += 0; // Bez zmian
			debug_echo("Dzień wolny");
		} elseif (
			($_student[$i] == $_oferta[$i]) // Pełne dopasowanie godzin
			||
			($_student[$i] == "wolne") && ($_oferta[$i] != "wolne") // Student wolny
		) {
			$wynik += 1;
			debug_echo("Pasuje");
		} else {
			$stud_od_do = explode("-", str_replace(":", "", $_student[$i]));
			$stud_od = intval($stud_od_do[0]);
			$stud_do = intval($stud_od_do[1]);

			$off_od_do = explode("-", str_replace(":", "", $_oferta[$i]));
			$off_od = intval($off_od_do[0]);
			$off_do = intval($off_od_do[1]);

			$godziny_od = $stud_od - $off_od;
			$godziny_do = $stud_do - $off_do;

			$od_ok = 0;
			$do_ok = 0;

			if ($godziny_od <= 0) {
				// Student ma więcej czasu albo godzina pasuje idealnie
				$wynik += 1/2;
				$od_ok = 1;
			} else {
				if ($godziny_od <= $PROG_ODCHYLKI_MINUTOWEJ) {
					// Do pół godziny różnicy
					$wynik += min(1/2, $WSPOLCZYNNIK_TOLERANCJI_MINUTOWEJ/abs($godziny_od));
					$od_ok = 1;
				} else $wynik += 0;
			}

			if ($godziny_do >= 0) {
				// Student ma więcej czasu albo godzina pasuje idealnie
				$wynik += 1/2;
				$do_ok = 1;
			} else {
				if ($godziny_od >= -$PROG_ODCHYLKI_MINUTOWEJ) {
					// Do pół godziny różnicy
					$wynik += min(1/2, $WSPOLCZYNNIK_TOLERANCJI_MINUTOWEJ/abs($godziny_do));
					$do_ok = 1;
				} else $wynik += 0;
			}

			if (!(($od_ok == 1) && ($do_ok == 1))) {
				// Zredukuj procent dostępności, jeśli oba zakresy nie pasują naraz
				$wynik = $wynik * $WSPOLCZYNNIK_REDUKCJI_POZA_ZAKRESEM;
			}
		}

                debug_echo("wynik czastkowy: $wynik");

		debug_echo("\n\n");
	}

	$PRESCALER_SAFE = ($PRESCALER ? $PRESCALER : 1);
	$wynik_koncowy = $wynik / $PRESCALER_SAFE;
	debug_echo($wynik . "/" . $PRESCALER_SAFE . "=" . $wynik_koncowy);
	debug_echo("");

	return $wynik_koncowy*100;
}


// Pobierz dostepnosc z bazy dla studenta i z oferty pracy konkretnej
//$g_student = explode(";", "Cały tydzień,08:00-16:01");
//$g_student = explode(";", "pn,08:00-16:00;wt,08:00-16:00;sr,08:00-16:00;cz,08:00-16:00;pt,08:00-16:00;sb,wolne;nd,wolne");
//$g_oferta = explode(";", "Cały tydzień,wolne");
//$g_oferta = explode(";", "Cały tydzień,00:00-16:00;Cały tydzień,03:00-16:00;Cały tydzień,08:00-15:01;Cały tydzień,08:00-15:01;Cały tydzień,08:00-15:01;Cały tydzień,wolne;Cały tydzień,wolne");
//$algowynik = algo_dopasowania_godzin($g_student, $g_oferta);

// echo "Dopasowanie: ". $algowynik ." %";
?>









<?php


			/* Test szaroskrzynkowy - znam/widze kod, ale nie wiem jak dziala

			// student od 10-20
			// praca od 12-14
			// czyli pasuje fajnie

			std_od=10   -    of_od=12        = -2
			std_do=20   -    of_do=14        = +6

			czyli jak od ujemne i do dodatnie to pasuje i dajemy 100%


			// student od 10-15
			// praca od 12-16

			10-12 = -2 OK
			15-16 = -1 NIE OK

			jak OD na minusie to super
			jak 0 to jest ideolo
			jak tylko wieksze od zera to juz zle

			*/

			// TEN ALGORYTM JEDNAK NIE BARDZO Z TEGO ELSE'A
			// trzeba patrzec czy godziny rozp. i zakoncz. sie w miare zazebiaja
			// np.
			/*
			+1h       60%
			+0.5h     80%
			0h        100%
			-0.5h     80%
			-1h       60%
			*/

			// Przyda sie


			/*
			debug_echo($stud_od);
			debug_echo($stud_do);
			debug_echo($stud);

			debug_echo($off_od);
			debug_echo($off_do);
			debug_echo($off); */



			/*
			$dopasuj_godziny_od = $stud_od - $off_od;
			$dopasuj_godziny_do = $stud_do - $off_do;

			debug_echo($dopasuj_godziny_od);
			debug_echo($dopasuj_godziny_do);
			*/

			// $wynik += (1/$dopasuj_godziny_od)+(1/$dopasuj_godziny_od);
			//debug_echo();


			// $dopasowanie = $stud - $off;

			/*
			if ($dopasowanie < 0) {
				// Oferta wymaga wiecej godzin niz ma student
				// Jakis wspolczynnik obrazujacy niedopasowanie
				$wynik += (($stud/$off)/7);
			} else {
				// Student ma wiecej dostepnosci niz oferta
				// czyli OK
				$wynik += 1/7;
			}
			*/

			// debug_echo("$stud - $off => $dopasowanie\n");


/*
	var_dump($_student);
	echo "<br>";
	var_dump($_oferta);
	echo "<br>";

	$wynik = 0.0;

	// Tryby porównań
	if (($_student[0] == "Cały tydzień") && ($_oferta[0] == "Cały tydzień")) {
		echo "Tryb 1: tu i tu caly tydz<br>";
		echo $_student[1]."<br>";
		echo $_oferta[1]."<br>";

		if (
			($_student[1] == $_oferta[1]) // pelne dopasowanie godzin
			||
			($_student[1] == "wolne") && ($_oferta[1] != "wolne") // student wolny
		) {
			$wynik = 1;
		} else {
			$stud_od_do = explode("-", str_replace(":", "", $_student[1]));
			$stud_od = intval($stud_od_do[0]);
			$stud_do = intval($stud_od_do[1]);
			$stud = $stud_do - $stud_od;

			$off_od_do = explode("-", str_replace(":", "", $_oferta[1]));
			$off_od = intval($off_od_do[0]);
			$off_do = intval($off_od_do[1]);
			$off = $off_do - $off_od;

			$dopasowanie = $stud - $off;

			if ($dopasowanie < 0) {
				// Oferta wymaga wiecej godzin niz ma student
				// Jakis wspolczynnik obrazujacy niedopasowanie
				$wynik = ($stud/$off);
			} else {
				// Student ma wiecej dostepnosci niz oferta
				// czyli OK
				$wynik = 1;
			}

			echo "<br><br>$stud - $off => $dopasowanie";
		}
	}

	echo "<br><br>Wynik porownania: " . round($wynik*100, 2) . " %";
*/
?>
