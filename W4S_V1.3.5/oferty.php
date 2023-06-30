<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>w4s.com – Work for Students</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'pasek.php'; ?>

<main id="test">
    <section class="hero-offers" style="height: 200px">
        <br><br><a>Work for Students</a><br><h1>Jakiej pracy dziś szukasz?</h1>
    </section>

    <section class="offer-container">
	<h2>Oferty pracy</h2>
        <?php
        include 'connect.php';
        include 'algorytm.php';

        $conn = mysqli_connect($host, $db_user, $db_password, $db_name);

        if (!$conn) {
            die("Błąd łączenia z bazą danych: " . mysqli_connect_error());
        }

        //Z TEGO ZROBIC W CSSIE JAKIEGOS FAJNEGO BUTTONA
        if(!isset($_GET["id"])){   
            if (@$_SESSION['typ_uzytkownika'] == "pracodawca") {
              echo '<a href="dodaj_oferte.php">Dodaj nową ofertę!</a>' ;
              echo '<br><hr><br>';
        }
        }


// INTEGRACJA - POBRANIE GODZIN DOSTEPNOSCI PRACOWNIKA PRZED OFERTAMI
if (@$_SESSION['typ_uzytkownika'] == "student") {
        $student_id = $_SESSION['id'];
	$sql = "SELECT godziny_dostepnosci
                FROM godziny_dostepnosci
                WHERE id_prac = '$student_id';";
        $result = mysqli_query($conn, $sql);

	$godziny_dost_stud = "";
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $godziny_dost_stud = $row["godziny_dostepnosci"];
	} else echo "Błąd odpytania bazy danych: " . mysqli_error($conn);
}
// INTEGRACJA END


            $sql = "SELECT * FROM oferty;";
            if ($ret = mysqli_query($conn, $sql)) {

                while ($wiersz = mysqli_fetch_assoc($ret)) {
                    echo "<div class='offer'>";
                    echo "<a href='oferta.php?id=" . $wiersz["id"] . "'><h3>" . $wiersz["tytul_oferty"] . "</h3></a><br>";
                    echo "<p>Zamieścił <i>" . $wiersz["autor"] . "</i> w dniu " . $wiersz["data"];

		if (@$_SESSION['typ_uzytkownika'] == "student") {
                    echo "<br>Dopasowanie: ";
			// echo $godziny_dost_stud ."  <br>      ". $wiersz["dyspozycyjnosc"];

			if ($godziny_dost_stud != "") {
				// TODO: kolorowanie
				echo round(algo_dopasowania_godzin($godziny_dost_stud, $wiersz["dyspozycyjnosc"]), 2) . " %";
			} else {
				echo "<b>ustaw swoje godziny dostępności, aby zobaczyć dopasowanie</b>";
			}
		}

                    echo "</p></div><br>";
                }
            } else {
                echo "Błąd odpytania bazy danych: " . mysqli_error($conn);
            }

        mysqli_close($conn);
        ?>
    </section>
</main>

<footer>
    <p>w4s.com &copy; 2023</p>
</footer>
</body>
</html>
