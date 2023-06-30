<META CHARSET="UTF-8" >
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
Wprowadź lub edytuj swoje godziny dostępności:
<form method="POST" >
<input type="text" name="dyspozycyjnosc" value="<?php echo $godziny; ?>" >
<input type="submit" >
</form>
