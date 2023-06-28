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
    <section class="hero" style="height: 200px">
        <h1>w4s.com – Work for Students</h1>
        <h2>Oferty pracy</h2>
    </section>

    <section class="how-it-works">
        <?php
        include 'connect.php';

        $conn = mysqli_connect($host, $db_user, $db_password, $db_name);

        if (!$conn) {
            die("Błąd łączenia z bazą danych: " . mysqli_connect_error());
        }

        //Z TEGO ZROBIC W CSSIE JAKIEGOS FAJNEGO BUTTONA
        if(!isset($_GET["id"])){   
            if ($_SESSION['typ_uzytkownika'] == "pracodawca") {
              echo '<a href="dodaj_oferte.php">Dodaj oferte</a>' ;
              echo '<br><hr><br>';
        }
        }


        if (isset($_GET["id"])) {

            $sql = "SELECT * FROM oferty WHERE id=" . mysqli_real_escape_string($conn, htmlentities($_GET["id"], ENT_QUOTES, "UTF-8")) . ";";
            if ($ret = mysqli_query($conn, $sql)) {
                if ($wiersz = mysqli_fetch_assoc($ret)) {
                    echo "<h3>" . $wiersz["tytul_oferty"] . "</h3><br>";

                    echo "<div class='ogloszenie_formatka' >";
                    echo "Pracodawca: <i>" . $wiersz["autor"] . "</i><br>";
                    echo "Data zamieszczenia oferty: " . $wiersz["data"] . "<br>";
                    echo "Dyspozycyjność: ";
                    if ($wiersz["dyspozycyjnosc"] != "") {
                        echo "<table style='border: 1px solid black'>";
                        foreach (explode(";", $wiersz["dyspozycyjnosc"]) as $pierwszy_poziom) {
                            echo "<tr>";
                            foreach (explode(",", $pierwszy_poziom) as $drugi_poziom) {
                                echo "<td style='border: 1px solid black'>" . $drugi_poziom . "</td>";
                            }
                            echo "</tr>";
                        }
                        echo "</table>";
                        echo "Wymagania: " . $wiersz["wymagania"] . "<br>";
                    } else {
                        echo "brak danych";
                    }
                    echo "<br>";
                    echo "</div><br>";

                    echo "<div class='ogloszenie_tresc'>";
                    echo $wiersz["tresc"];
                    echo "</div><br><br>";

                    if (@$_SESSION['user']) {
                        if ($_SESSION['typ_uzytkownika'] == "student") {
                            echo "Spodobała ci się ta oferta?<br><br><a href='aplikuj.php?id=" . $wiersz["id"] . "' class='hero_btn_oferta'>Aplikuj</a>";
                        }
                    } else {
                        echo "Spodobała ci się ta oferta?<br><br><a href='aplikuj.php?id=" . $wiersz["id"] . "' class='hero_btn_oferta'>Zarejestruj się, aby aplikować</a>";
                    }
                } else {
                    echo "Oferta nie istnieje!";
                }
            } else {
                echo "Wystąpił błąd serwera! Przepraszamy za utrudnienia!";
            }
        } else {
            $sql = "SELECT * FROM oferty;";
            if ($ret = mysqli_query($conn, $sql)) {

                while ($wiersz = mysqli_fetch_assoc($ret)) {
                    echo "<div class='oferta' style='border: 1px solid black; border-radius: 1em 0 0 0; padding: 0.5em; margin: 0.5em'>";
                    echo "<a href='oferty.php?id=" . $wiersz["id"] . "'><h3>" . $wiersz["tytul_oferty"] . "</h3></a><br>";
                    echo "Zamieścił <i>" . $wiersz["autor"] . "</i> w dniu " . $wiersz["data"];
                    echo "</div><br>";
                }
            } else {
                echo "Błąd odpytania bazy danych: " . mysqli_error($conn);
            }
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