<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Zarządzaj ofertami</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .oferta {
            cursor: pointer;
            margin-bottom: 10px;
        }
        
        .opcje-oferty {
            display: none;
        }
    </style>
    <script>
        $(document).ready(function() {
            $(".oferta").click(function() {
                $(this).next().slideToggle();
            });

		setTimeout(function() { $(".oferta").click(); }, 500);
        });
    </script>
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
        <h2 style='font-size: 36px;'>Zarządzaj swoimi ofertami</h2>
    <?php
    if ($_SESSION['user']) {
        if ($_SESSION['typ_uzytkownika'] == "pracodawca") {
            include 'connect.php';
            $conn = mysqli_connect($host, $db_user, $db_password, $db_name);
            $user = $_SESSION['user'];
            
            if (isset($_POST['update'])) {
                $id = $_POST['id'];
                $tytul_oferty = $_POST['tytul_oferty'];
                $dyspozycyjnosc = $_POST['dyspozycyjnosc'];
                $tresc = $_POST['tresc'];
                $wymagania = $_POST['wymagania'];
                
                $sql = "UPDATE oferty
                        SET tytul_oferty = '$tytul_oferty', dyspozycyjnosc = '$dyspozycyjnosc', tresc = '$tresc', wymagania = '$wymagania'
                        WHERE id = '$id' AND autor = '$user'";
                
                if (mysqli_query($conn, $sql)) {
                    echo "<h1 style='text-align:left; padding: 30px;'>Oferta została zaktualizowana pomyślnie.</h1>";
                    header("refresh:3;url=zarzadzaj_ofertami.php");
                } else {
                    echo "<h1 style='text-align:left;padding: 30px;'>Błąd podczas aktualizacji oferty: </h1>" . mysqli_error($conn);
                    header("refresh:3;url=zarzadzaj_ofertami.php");
                }
            }
            
            if (isset($_POST['delete'])) {
                $id = $_POST['id'];
                
                // Usunięcie rekordów powiązanych z daną ofertą w tabeli "aplikacje"
                $deleteAplikacje = "DELETE FROM aplikacje WHERE id_oferta = '$id'";
                mysqli_query($conn, $deleteAplikacje);
                
                // Usunięcie danej oferty
                $deleteOferta = "DELETE FROM oferty WHERE id = '$id' AND autor = '$user'";
                
                if (mysqli_query($conn, $deleteOferta)) {
                    echo "<h1 style='text-align:left; padding: 30px;'>Oferta została usunięta pomyślnie.</h1>";
                    header("refresh:3;url=zarzadzaj_ofertami.php");
                } else {
                    echo "<h1 style='text-align:left; padding: 30px;'>Błąd podczas usuwania oferty: </h1>" . mysqli_error($conn);
                    header("refresh:3;url=zarzadzaj_ofertami.php");
                }
            }

      if (isset($_GET['id'])) {
            $id_oferty = $_GET['id'];

            $sql = "SELECT * FROM oferty WHERE id = '$id_oferty' AND autor = '$user'";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $id = $row['id'];
                    $tytul_oferty = $row['tytul_oferty'];
                    $dyspozycyjnosc = $row['dyspozycyjnosc'];
                    $tresc = $row['tresc'];
                    $wymagania = $row['wymagania'];

                    echo "<div class='oferta'><h3 style='font-size: 22px;'>Oferta nr: " . $id . "</h3>";
                    echo "<p>Tytuł oferty: " . $tytul_oferty . "</p></div>";

                    echo "<div class='opcje-oferty'>";
                    echo "<form method='POST' action=''>";
                    echo "<input type='hidden' name='id' value='" . $id . "'>";
                    echo "<label for='tytul_oferty'>Tytuł oferty:</label><br>";
                    echo "<input type='text' id='tytul_oferty' name='tytul_oferty' value='" . $tytul_oferty . "' required><br>";
                    //echo "<label for='dyspozycyjnosc'>Dyspozycyjność:</label><br>";
                    //echo "<input type='text' id='dyspozycyjnosc' name='dyspozycyjnosc' value='" . $dyspozycyjnosc . "' required><br>";


// INTEGRACJA

if ($dyspozycyjnosc != "") {
	echo "<label>Obecne prefenencje dostępnosci:</label><br>";
	echo "<table style='border: 1px solid black'>";

	foreach (explode(";", $dyspozycyjnosc) as $pierwszy_poziom) {
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

// INTEGRACJA 1 KONIEC


// INTEGRACJA
?>
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
	<label>Ustaw nowe prefenencje dostępnosci:</label><br>
	<!-- <h1>Wprowadź lub edytuj swoje godziny dostępności:<br></h1><br> -->
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



<!-- FIXUP wolne -->
<script>
dysp_pon_czy_wolne.addEventListener("click", function(){
	if (this.checked) {
		dysp_pon_od.value = "00:00";
		dysp_pon_do.value = "00:00";
		dysp_pon_od.disabled = true;
		dysp_pon_do.disabled = true;
	} else {
		dysp_pon_od.value = "";
		dysp_pon_do.value = "";
		dysp_pon_od.disabled = false;
		dysp_pon_do.disabled = false;
	}
});

dysp_wto_czy_wolne.addEventListener("click", function(){
	if (this.checked) {
		dysp_wto_od.value = "00:00";
		dysp_wto_do.value = "00:00";
		dysp_wto_od.disabled = true;
		dysp_wto_do.disabled = true;
	} else {
		dysp_wto_od.value = "";
		dysp_wto_do.value = "";
		dysp_wto_od.disabled = false;
		dysp_wto_do.disabled = false;
	}
});

dysp_sro_czy_wolne.addEventListener("click", function(){
	if (this.checked) {
		dysp_sro_od.value = "00:00";
		dysp_sro_do.value = "00:00";
		dysp_sro_od.disabled = true;
		dysp_sro_do.disabled = true;
	} else {
		dysp_sro_od.value = "";
		dysp_sro_do.value = "";
		dysp_sro_od.disabled = false;
		dysp_sro_do.disabled = false;
	}
});

dysp_czw_czy_wolne.addEventListener("click", function(){
	if (this.checked) {
		dysp_czw_od.value = "00:00";
		dysp_czw_do.value = "00:00";
		dysp_czw_od.disabled = true;
		dysp_czw_do.disabled = true;
	} else {
		dysp_czw_od.value = "";
		dysp_czw_do.value = "";
		dysp_czw_od.disabled = false;
		dysp_czw_do.disabled = false;
	}
});

dysp_pt_czy_wolne.addEventListener("click", function(){
	if (this.checked) {
		dysp_pt_od.value = "00:00";
		dysp_pt_do.value = "00:00";
		dysp_pt_od.disabled = true;
		dysp_pt_do.disabled = true;
	} else {
		dysp_pt_od.value = "";
		dysp_pt_do.value = "";
		dysp_pt_od.disabled = false;
		dysp_pt_do.disabled = false;
	}
});

dysp_sob_czy_wolne.addEventListener("click", function(){
	if (this.checked) {
		dysp_sob_od.value = "00:00";
		dysp_sob_do.value = "00:00";
		dysp_sob_od.disabled = true;
		dysp_sob_do.disabled = true;
	} else {
		dysp_sob_od.value = "";
		dysp_sob_do.value = "";
		dysp_sob_od.disabled = false;
		dysp_sob_do.disabled = false;
	}
});

dysp_niedz_czy_wolne.addEventListener("click", function(){
	if (this.checked) {
		dysp_niedz_od.value = "00:00";
		dysp_niedz_do.value = "00:00";
		dysp_niedz_od.disabled = true;
		dysp_niedz_do.disabled = true;
	} else {
		dysp_niedz_od.value = "";
		dysp_niedz_do.value = "";
		dysp_niedz_od.disabled = false;
		dysp_niedz_do.disabled = false;
	}
});
</script>
<!-- FIXUP wolne -->


<?php

                    echo "<label for='tresc'>Treść:</label><br>";
                    echo "<textarea id='tresc' name='tresc' required>" . $tresc . "</textarea><br>";
                    echo "<label for='wymagania'>Wymagania:</label><br>";
                    echo "<textarea id='wymagania' name='wymagania' required>" . $wymagania . "</textarea><br>";
                    echo "<input type='submit' name='update' value='Zaktualizuj'>";
                    echo "<input type='submit' name='delete' value='Usuń' onclick='return confirm(\"Czy na pewno chcesz usunąć tę ofertę?\")'>";
                    echo "</form>";
                    echo "</div>";
            } else {
                echo "<h1 style='text-align:center; padding: 30px;'>Oferta nie istnieje.</h1>";
            }
        
      } else {
                echo "<h1 style='text-align:center; padding: 30px;'>Nie podano numeru oferty do edycji.</h1>";
      }
}
    }
    ?>
    
</body>
</html>
