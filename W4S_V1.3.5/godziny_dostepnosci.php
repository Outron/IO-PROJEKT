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
		//echo "insert jeszcze";
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
                    echo "<p style='font-size: 24px;'>Godziny dostepnosci zostały zaktualizowane pomyślnie.</p>";
                } else {
                    echo "<p style='font-size: 24px;'>Błąd podczas godzin dostepnosci: </p>" . mysqli_error($conn);
                }
	}


        $sql = "SELECT godziny_dostepnosci
                FROM godziny_dostepnosci
                WHERE id_prac = '$student_id';";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $godziny = $row["godziny_dostepnosci"];

            if ($godziny == "") echo "<b><h1 style='text-align:left; font-size: 28px;'>Jeszcze nie wprowadziłeś swoich godzin dostepnosci!</b><br><br>";
        } else {
            echo "<p style='font-size: 24px;'><b>Nie wprowadziłeś swoich godzin dostepnosci!</b></p><br>";

                $sql = "INSERT INTO godziny_dostepnosci(id_prac, godziny_dostepnosci)
                        VALUES($student_id, '')";

                if (mysqli_query($conn, $sql)) {
                    echo "<p style='font-size: 24px;'>Godziny dostepnosci zostały zainicjowane pomyślnie.</p>";
                } else {
                    echo "<p style='font-size: 24px;'>>Błąd podczas inicjalizacji godzin dostepnosci: </p>" . mysqli_error($conn);
                }
        }
    }
}
?>

<p style='font-size: 24px;'>Wprowadź lub edytuj swoje godziny dostępności: </p><br>
<form method="POST" >
<input type="text" name="dyspozycyjnosc" value="<?php echo $godziny; ?>" >
<input type="submit" >
</form>
