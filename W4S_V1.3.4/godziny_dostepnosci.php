<META CHARSET="UTF-8" >
<?php
session_start();
if ($_SESSION['user']) {
    if ($_SESSION['typ_uzytkownika'] == "student") {
        include 'connect.php';
        $student_id = $_SESSION['id'];
        $conn = mysqli_connect($host, $db_user, $db_password, $db_name);


	if (isset($_POST["dyspozycyjnosc"])) {
		echo "insert jeszcze";
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
                    echo "Godziny dostepnosci zostały zaktualizowane pomyślnie.";
                } else {
                    echo "Błąd podczas godzin dostepnosci: " . mysqli_error($conn);
                }
	}


        $sql = "SELECT godziny_dostepnosci
                FROM godziny_dostepnosci
                WHERE id_prac = '$student_id';";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $godziny = $row["godziny_dostepnosci"];

            if ($godziny == "") echo "<b>Jeszcze nie wprowadziłeś swoich godzin dostepnosci!</b><br>";
        } else {
            echo "<b>Nie wprowadziłeś swoich godzin dostepnosci!</b><br>";
        }
    }
}
?>
Wprowadź lub edytuj swoje godziny dostępności:
<form method="POST" >
<input type="text" name="dyspozycyjnosc" value="<?php echo $godziny; ?>" >
<input type="submit" >
</form>
