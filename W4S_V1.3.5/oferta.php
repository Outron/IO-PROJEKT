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

        if (isset($_GET["id"])) {
            $sql = "SELECT * FROM oferty WHERE id=" . mysqli_real_escape_string($conn, htmlentities($_GET["id"], ENT_QUOTES, "UTF-8")) . ";";
            if ($ret = mysqli_query($conn, $sql)) {
                if ($wiersz = mysqli_fetch_assoc($ret)) {
                    

                    echo "<div class='offer-info' >";
					echo "<h3>" . $wiersz["tytul_oferty"] . "</h3><br>";
                    echo "Pracodawca: <i>" . $wiersz["autor"] . "</i><br>";
                    echo "Data zamieszczenia oferty: " . $wiersz["data"] . "<br>";
                    echo "Dyspozycyjność: ";
					echo "<br>";
                    if ($wiersz["dyspozycyjnosc"] != "") {
                        echo "<table style='border: 1px solid black'>";
                        foreach (explode(";", $wiersz["dyspozycyjnosc"]) as $pierwszy_poziom) {
                            echo "<tr>";
                            foreach (explode(",", $pierwszy_poziom) as $drugi_poziom) {
                                echo "<td style='border: 1px solid black'>" . $drugi_poziom . "</td>";
                            }
                            echo "</tr>";
                        }
                        echo "</table><br>";
                        echo "<div class='offer-desc'>";
                        echo "Wymagania: " . $wiersz["wymagania"] . "<br><br>";
                    } else {
                        echo "brak danych";
                    }
                    echo $wiersz["tresc"];
					echo "</div>";

                    echo "<div class='offer-button'>";
                    if (@$_SESSION['user']) {
                        if ($_SESSION['typ_uzytkownika'] == "student") {
                            echo "Spodobała ci się ta oferta?<br><a href='aplikuj.php?id=" . $wiersz["id"] . "'>Aplikuj</a>";
                        }
                    } else {
                        echo "Spodobała ci się ta oferta?<br><a href='rejestracja.php'>Zarejestruj się, aby aplikować</a>";
                    }
                } else {
                    echo "Oferta nie istnieje!";
                }
            } else {
                echo "Wystąpił błąd serwera! Przepraszamy za utrudnienia!";
            }
        } else { echo "Nie wybrano zadnej oferty"; }
        echo "</div>";
        mysqli_close($conn);
        ?>
    </section>
</main>

<footer>
    <p>w4s.com &copy; 2023</p>
</footer>
</body>
</html>
