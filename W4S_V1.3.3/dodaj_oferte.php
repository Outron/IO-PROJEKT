<!DOCTYPE html>
<html>
<head>
    <title>Dodaj ofertę</title>
</head>
<body>
    <?php
    session_start();
    if ($_SESSION['user']) {
        if ($_SESSION['typ_uzytkownika'] == "pracodawca") {
            include 'connect.php';
            $conn = mysqli_connect($host, $db_user, $db_password, $db_name);
            
            if (isset($_POST['submit'])) {
                $tytul_oferty = $_POST['tytul_oferty'];
                $autor = $_SESSION['user'];
                $data = date('Y-m-d H:i:s');
                $dyspozycyjnosc = $_POST['dyspozycyjnosc'];
                $tresc = $_POST['tresc'];
                $wymagania = $_POST['wymagania'];
                
                $sql = "INSERT INTO oferty (tytul_oferty, autor, data, dyspozycyjnosc, tresc, wymagania)
                        VALUES ('$tytul_oferty', '$autor', '$data', '$dyspozycyjnosc', '$tresc', '$wymagania')";
                
                if (mysqli_query($conn, $sql)) {
                    echo "Oferta została dodana pomyślnie.";
                    header("refresh:3;url=logowanie.php");
                } else {
                    echo "Błąd podczas dodawania oferty: " . mysqli_error($conn);
                    header("refresh:3;url=dodaj_oferte.php");
                }
            }
        }
    }
    ?>
    
    <h2>Dodaj ofertę</h2>
    
    <form method="POST" action="">
        <label for="tytul_oferty">Tytuł oferty:</label><br>
        <input type="text" id="tytul_oferty" name="tytul_oferty" required><br><br>

        <script>
function dost_render(elm) {
	switch (elm.value) {
		case "tak":
			formatka_dostepnosc_dni_tyg.style.display = "none";
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
			formatka_dostepnosc_dni_tyg.style.display = "block";
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
		}
		buf += ";";

		buf += "Środa,";
		if (!dysp_sro_czy_wolne.checked) {
			buf += dysp_sro_od.value + "-" + dysp_sro_do.value;
		}
		buf += ";";

		buf += "Czwartek,";
		if (!dysp_czw_czy_wolne.checked) {
			buf += dysp_czw_od.value + "-" + dysp_czw_do.value;
		}
		buf += ";";

		buf += "Piątek,";
		if (!dysp_pt_czy_wolne.checked) {
			buf += dysp_pt_od.value + "-" + dysp_pt_do.value;
		}
		buf += ";";

		buf += "Sobota,";
		if (!dysp_sob_czy_wolne.checked) {
			buf += dysp_sob_od.value + "-" + dysp_sob_do.value;
		}
		buf += ";";

		buf += "Niedziela,";
		if (!dysp_niedz_czy_wolne.checked) {
			buf += dysp_niedz_od.value + "-" + dysp_niedz_do.value;
		}
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

        <label for="dyspozycyjnosc">Dyspozycyjność:</label><br>
        <input type="hidden" id="dyspozycyjnosc" name="dyspozycyjnosc" required>
	<input type="radio" name="dyspozycyjnosc_caly_tydzien" value="nie" onclick="dost_render(this)" checked="" >rozne godziny na kazdy dzien</input>
	<input type="radio" id="dost_radio_caly_tydz" name="dyspozycyjnosc_caly_tydzien" value="tak" onclick="dost_render(this)" >caly tydzien</input>
	<div id="formatka_dostepnosc_dni_tyg" >
		<table>
			<tr>
				<th>Dzien tygodnia</th>
				<th>Od godziny</th>
				<th>do godziny</th>
				<th>czy wolne?</th>
			</tr>

			<tr>
				<td>Poniedzialek</td>
			        <td><input type="time" oninput="skomponuj_godziny(this)" id="dysp_pon_od" required="" ></td>
6	        		<td><input type="time" oninput="skomponuj_godziny(this)" id="dysp_pon_do" required="" ></td>
			        <td><input type="checkbox" oninput="skomponuj_godziny(this)" id="dysp_pon_czy_wolne" ></td>
			</tr>

			<tr>
				<td>Wtorek</td>
			        <td><input type="time" oninput="skomponuj_godziny(this)" id="dysp_wto_od" required="" ></td>
	        		<td><input type="time" oninput="skomponuj_godziny(this)" id="dysp_wto_do" required="" ></td>
			        <td><input type="checkbox" oninput="skomponuj_godziny(this)" id="dysp_wto_czy_wolne" ></td>
			</tr>

			<tr>
				<td>Sroda</td>
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
				<td>Piatek</td>
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

	<div id="formatka_dostepnosc_caly_tyg" style="display:none" >
<style>
table, th, td {
	border: 1px black solid;
	border-collapse: collapse;
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
        
        <label for="tresc">Treść oferty:</label><br>
        <textarea id="tresc" name="tresc" required></textarea><br>
        
        <label for="wymagania">Wymagania:</label><br>
        <textarea id="wymagania" name="wymagania" required></textarea><br>
        
        <input type="submit" name="submit" value="Dodaj ofertę">
    </form>
</body>
</html>
