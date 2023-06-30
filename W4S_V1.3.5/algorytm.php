<pre><?php
	// Narazie suorwy skrypt do ogarniecia tego algorytmu jak to ma dzialac

	// Docelowo wykonywanie w oferty.php
	// Pokazywanie w liscie ofert przy danej ofercie jako duzym drukiem procent

	// Pobierz dostepnosc z bazy dla studenta i z oferty pracy konkretnej
	//$student = explode(";", "Cały tydzień,08:00-16:00");
	$student = explode(";", "pn,08:00-16:00;wt,08:00-16:00;sr,08:00-16:00;cz,08:00-16:00;pt,08:00-16:00;sb,wolne;nd,wolne");
	// $oferta = explode(";", "Cały tydzień,08:00-15:01");
	$oferta = explode(";", "Cały tydzień,08:00-16:00;Cały tydzień,08:00-16:00;Cały tydzień,08:00-15:01;Cały tydzień,08:00-15:01;Cały tydzień,08:00-15:01;Cały tydzień,08:00-15:01;Cały tydzień,08:00-15:01");

	// Rozbij na listę, żeby był dostęp do elementów
	$_student = [];
	foreach ($student as $dzien) $_student = array_merge($_student, explode(",", $dzien));

	$_oferta = [];
	foreach ($oferta as $dzien) $_oferta = array_merge($_oferta, explode(",", $dzien));

	if (sizeof($_oferta) == 2) {
		echo "Oferta: caly tydzien - TODO: interpolacja tabeli zeby sie 7 razy powtarzalo\n";
	} else {
		echo "Oferta: dni osobno - OK\n";
	}

	if (sizeof($_student) == 2) {
		echo "Student: caly tydzien - TODO: interpolacja tabeli zeby sie 7 razy powtarzalo\n";
	} else {
		echo "Student: dni osobno - OK\n";
	}

	$wynik = 0;

	for ($i = 1; $i < sizeof($_student); $i += 2) {
		echo $_student[$i] . " " . $_oferta[$i] . "\n";

		if (
			($_student[$i] == $_oferta[$i]) // pelne dopasowanie godzin
			||
			($_student[$i] == "wolne") && ($_oferta[$i] != "wolne") // student wolny
		) {
			$wynik += 1;
		} else {}

                echo "wynik czastkowy: $wynik";

		echo "\n";
	}
	echo "\nwynik = ". $wynik*100 ." %    --------------------------------------------------";
	exit();

















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
?>

</pre>
