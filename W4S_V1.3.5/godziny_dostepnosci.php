<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>w4s.com – Work for Students</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
        <?php include 'pasek.php'; ?>
    </header>

<main id="test">
    <section class="hero-offers" style="height: 200px">
        <br><br><a>Work for Students</a><br><h1>Jakiej pracy dziś szukasz?</h1> 
    </section>

    <section class="offer-container">
		<h1 style = 'text-align:center; font-size: 36px;'>Ustaw swoje godziny dostępności<br><br></h1>


<?php
session_start();
if ($_SESSION['user']) {
    if ($_SESSION['typ_uzytkownika'] == "student") {
        include 'connect.php';
        $student_id = $_SESSION['id'];
        $conn = mysqli_connect($host, $db_user, $db_password, $db_name);


	if (isset($_POST["dyspozycyjnosc"])) {
		$godz_dost = $_POST["dyspozycyjnosc"];

		// do zmiany, kolumna w  tabeli pracowqnicy
		// choc wg specyfikacji mialo byc chyba osobno
                $sql = "UPDATE godziny_dostepnosci
                        SET godziny_dostepnosci = '$godz_dost'
                        WHERE id_prac = '$student_id'";

/*
		// lepiej chyba tak bedzie

                $sql = "UPDATE pracownicy
                        SET godziny_dostepnosci = '$godz_dost'
                        WHERE id = '$student_id'";
*/

                if (mysqli_query($conn, $sql)) {
                    echo "<b>Godziny dostepnosci zostały zaktualizowane pomyślnie.</b><br><br>";

                } else {
                    echo "<b>Błąd podczas godzin dostepnosci: " . mysqli_error($conn) . "</b><br><br>";
                }
	}

	// Zeby nie dublowac komunikatow
	$flaga_brak_godz_dost = 0;

        $sql = "SELECT godziny_dostepnosci
                FROM godziny_dostepnosci
                WHERE id_prac = '$student_id';";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $godziny = $row["godziny_dostepnosci"];

            if ($godziny == "") $flaga_brak_godz_dost = 1;
        } else {
		$flaga_brak_godz_dost = 1;

                $sql = "INSERT INTO godziny_dostepnosci(id_prac, godziny_dostepnosci)
                        VALUES($student_id, '')";

                if (!mysqli_query($conn, $sql)) {
                    echo "<b>Błąd podczas inicjalizacji godzin dostepnosci: " . mysqli_error($conn) . "</b><br><br>";
                }
        }

	if ($flaga_brak_godz_dost == 1) echo "<b>Jeszcze nie wprowadziłeś swoich godzin dostepnosci!</b><br><br>";
    }
}
?>



<!-- INTEGRACJA 1 -->

<?php
if ($godziny != "") {
	echo "<h1>Twoje obecne prefenencje dostępnosci:</h1><br>";
	echo "<table style='border: 1px solid black'>";

	foreach (explode(";", $godziny) as $pierwszy_poziom) {
		echo "<tr>";

		foreach (explode(",", $pierwszy_poziom) as $drugi_poziom) {
			echo "<td style='border: 1px solid black;
			width:70px;
			height:20px;
			transform: scale(1);
			padding:7px;'>" . $drugi_poziom . "</td>";
		}

		echo "</tr>";
	}

	echo "</table><br>";
}
?>

<!-- INTEGRACJA 1 KONIEC -->




<form method="POST" >
<!-- <input type="text" name="dyspozycyjnosc" value="<?php echo $godziny; ?>" > -->



<!-- INTEGRACJA -->

        <script>
function dost_render(elm) {
	switch (elm.value) {
		case "tak":
			formatka_dostepnosc_dni_tyg_2.style.display = "none";
			formatka_dostepnosc_caly_tyg.style.display = "block";

			dysp_caly_tydz_od.setAttribute("required", "");
			dysp_caly_tydz_do.setAttribute("required", "");

			dysp_pon_od.removeAttribute("required", "");
			dysp_pon_do.removeAttribute("required", "");
			dysp_wto_od.removeAttribute("required", "");
			dysp_wto_do.removeAttribute("required", "");
			dysp_sro_od.removeAttribute("required", "");
			dysp_sro_do.removeAttribute("required", "");
			dysp_czw_od.removeAttribute("required", "");
			dysp_czw_do.removeAttribute("required", "");
			dysp_pt_od.removeAttribute("required", "");
			dysp_pt_do.removeAttribute("required", "");
			dysp_sob_od.removeAttribute("required", "");
			dysp_sob_do.removeAttribute("required", "");
			dysp_niedz_od.removeAttribute("required", "");
			dysp_niedz_do.removeAttribute("required", "");

			break;

		case "nie":
			formatka_dostepnosc_dni_tyg_2.style.display = "block";
			formatka_dostepnosc_caly_tyg.style.display = "none";

			dysp_caly_tydz_od.removeAttribute("required", "");
			dysp_caly_tydz_do.removeAttribute("required", "");

			dysp_pon_od.setAttribute("required", "");
			dysp_pon_do.setAttribute("required", "");
			dysp_wto_od.setAttribute("required", "");
			dysp_wto_do.setAttribute("required", "");
			dysp_sro_od.setAttribute("required", "");
			dysp_sro_do.setAttribute("required", "");
			dysp_czw_od.setAttribute("required", "");
			dysp_czw_do.setAttribute("required", "");
			dysp_pt_od.setAttribute("required", "");
			dysp_pt_do.setAttribute("required", "");
			dysp_sob_od.setAttribute("required", "");
			dysp_sob_do.setAttribute("required", "");
			dysp_niedz_od.setAttribute("required", "");
			dysp_niedz_do.setAttribute("required", "");

			break;
	}
}

function skomponuj_godziny(elm) {
	if (dost_radio_caly_tydz.checked) {
		var g_od = dysp_caly_tydz_od.value;
		var g_do = dysp_caly_tydz_do.value;

		if ((g_od.length > 0) && (g_do.length > 0)) {
			dyspozycyjnosc.value = "Caly tydzien," + g_od + "-" + g_do;
		}
	} else {
		var buf = "";

		buf += "Poniedziałek,";
		if (!dysp_pon_czy_wolne.checked) {
			buf += dysp_pon_od.value + "-" + dysp_pon_do.value;
		} else { buf += "wolne"; }
		buf += ";";

		buf += "Wtorek,";
		if (!dysp_wto_czy_wolne.checked) {
			buf += dysp_wto_od.value + "-" + dysp_wto_do.value;
		} else { buf += "wolne"; }
		buf += ";";

		buf += "Środa,";
		if (!dysp_sro_czy_wolne.checked) {
			buf += dysp_sro_od.value + "-" + dysp_sro_do.value;
		} else { buf += "wolne"; }
		buf += ";";

		buf += "Czwartek,";
		if (!dysp_czw_czy_wolne.checked) {
			buf += dysp_czw_od.value + "-" + dysp_czw_do.value;
		} else { buf += "wolne"; }
		buf += ";";

		buf += "Piątek,";
		if (!dysp_pt_czy_wolne.checked) {
			buf += dysp_pt_od.value + "-" + dysp_pt_do.value;
		} else { buf += "wolne"; }
		buf += ";";

		buf += "Sobota,";
		if (!dysp_sob_czy_wolne.checked) {
			buf += dysp_sob_od.value + "-" + dysp_sob_do.value;
		} else { buf += "wolne"; }
		buf += ";";

		buf += "Niedziela,";
		if (!dysp_niedz_czy_wolne.checked) {
			buf += dysp_niedz_od.value + "-" + dysp_niedz_do.value;
		} else { buf += "wolne"; }
		// buf += ";";

		console.log(buf);
		dyspozycyjnosc.value = buf;

		/* if (
			(pon_od.length > 0) && (pon_do.length > 0) &&
			(niedz_od.length > 0) && (niedz_do.length > 0)
		) {
			dyspozycyjnosc.value = "Poniedzialek," + pon_od + "-" + pon_do + ";Niedziela," + niedz_od + "-" + niedz_do;
		} */
	}

	console.log(dyspozycyjnosc.value);
}
</script>

	<h1>Wprowadź lub edytuj swoje godziny dostępności:<br></h1><br>
        <label for="dyspozycyjnosc_caly_tydzien" >Wybierz typ dyspozycyjności:</label>
		<div class='check-type'>
        <input type="hidden" id="dyspozycyjnosc" name="dyspozycyjnosc" required>
	<input type="radio" name="dyspozycyjnosc_caly_tydzien" value="nie" onclick="dost_render(this)" checked="" >Dniowa</input>
	<input type="radio" id="dost_radio_caly_tydz" name="dyspozycyjnosc_caly_tydzien" value="tak" onclick="dost_render(this)" >Tygodniowa</input>
</div>
	<div id="formatka_dostepnosc_dni_tyg_2" >
		<table>
			<tr>
				<th>Dzień tygodnia</th>
				<th>Od godziny</th>
				<th>do godziny</th>
				<th>czy wolne?</th>
			</tr>

			<tr>
				<td>Poniedziałek</td>
			        <td><input type="time" oninput="skomponuj_godziny(this)" id="dysp_pon_od" required="" ></td>
	        		<td><input type="time" oninput="skomponuj_godziny(this)" id="dysp_pon_do" required="" ></td>
			        <td><input type="checkbox" oninput="skomponuj_godziny(this)" id="dysp_pon_czy_wolne" ></td>
			</tr>

			<tr>
				<td>Wtorek</td>
			        <td><input type="time" oninput="skomponuj_godziny(this)" id="dysp_wto_od" required="" ></td>
	        		<td><input type="time" oninput="skomponuj_godziny(this)" id="dysp_wto_do" required="" ></td>
			        <td><input type="checkbox" oninput="skomponuj_godziny(this)" id="dysp_wto_czy_wolne" ></td>
			</tr>

			<tr>
				<td>Środa</td>
			        <td><input type="time" oninput="skomponuj_godziny(this)" id="dysp_sro_od" required="" ></td>
	        		<td><input type="time" oninput="skomponuj_godziny(this)" id="dysp_sro_do" required="" ></td>
			        <td><input type="checkbox" oninput="skomponuj_godziny(this)" id="dysp_sro_czy_wolne" ></td>
			</tr>

			<tr>
				<td>Czwartek</td>
			        <td><input type="time" oninput="skomponuj_godziny(this)" id="dysp_czw_od" required="" ></td>
	        		<td><input type="time" oninput="skomponuj_godziny(this)" id="dysp_czw_do" required="" ></td>
			        <td><input type="checkbox" oninput="skomponuj_godziny(this)" id="dysp_czw_czy_wolne" ></td>
			</tr>

			<tr>
				<td>Piątek</td>
			        <td><input type="time" oninput="skomponuj_godziny(this)" id="dysp_pt_od" required="" ></td>
	        		<td><input type="time" oninput="skomponuj_godziny(this)" id="dysp_pt_do" required="" ></td>
			        <td><input type="checkbox" oninput="skomponuj_godziny(this)" id="dysp_pt_czy_wolne" ></td>
			</tr>

			<tr>
				<td>Sobota</td>
			        <td><input type="time" oninput="skomponuj_godziny(this)" id="dysp_sob_od" required="" ></td>
	        		<td><input type="time" oninput="skomponuj_godziny(this)" id="dysp_sob_do" required="" ></td>
			        <td><input type="checkbox" oninput="skomponuj_godziny(this)" id="dysp_sob_czy_wolne" ></td>
			</tr>

			<tr>
				<td>Niedziela</td>
			        <td><input type="time" oninput="skomponuj_godziny(this)" id="dysp_niedz_od" required="" ></td>
	        		<td><input type="time" oninput="skomponuj_godziny(this)" id="dysp_niedz_do" required="" ></td>
			        <td><input type="checkbox" oninput="skomponuj_godziny(this)" id="dysp_niedz_czy_wolne" ></td>
			</tr>
		</table>
</div>

	<div id="formatka_dostepnosc_caly_tyg" style="display:none;" >
<style>
table, th, td {
	border: 1px black solid;
	border-collapse: collapse;
	padding:7px;
}
input#dysp_pon_czy_wolne {
    width: 22px;
    margin-left:22px;
	margin-top:3px;
    height: 22px;
}
input#dysp_wto_czy_wolne {
    width: 22px;
    margin-left:22px;
	margin-top:3px;
    height: 22px;
}
input#dysp_sro_czy_wolne {
	width: 22px;
    margin-left:22px;
	margin-top:3px;
    height: 22px;
}
input#dysp_czw_czy_wolne {
	width: 22px;
    margin-left:22px;
	margin-top:3px;
    height: 22px;
}
input#dysp_pt_czy_wolne {
	width: 22px;
	margin-left:22px;
	margin-top:3px;
    height: 22px;
}
input#dysp_sob_czy_wolne {
	width: 22px;
    margin-left:22px;
	margin-top:3px;
    height: 22px;
}
input#dysp_niedz_czy_wolne {
	width: 22px;
    margin-left:22px;
	margin-top:3px;
    height: 22px;
}


</style>

		<table>
			<tr>
				<th>Dzien tygodnia</th>
				<th>Od godziny</th>
				<th>do godziny</th>
			</tr>

			<tr>
				<td>Caly tydzien</td>
			        <td><input type="time" oninput="skomponuj_godziny(this)" id="dysp_caly_tydz_od" ></td>
	        		<td><input type="time" oninput="skomponuj_godziny(this)" id="dysp_caly_tydz_do" ></td>
			</tr>
		</table>
	</div>
	<br><br>




<!-- INTEGRACJA KONIEC -->



<br><br>
<input type="submit" value="Aktualizuj" >
</form>
</main>
<footer>
    <p>w4s.com &copy; 2023</p>
</footer>
</body>
</html>
