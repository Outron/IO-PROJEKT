<?php
session_start();
include 'connect.php';

$conn = mysqli_connect($host, $db_user, $db_password, $db_name);

if (!$conn) {
    die("Błąd łączenia z bazą danych: " . mysqli_connect_error());
}

if (isset($_SESSION['user']) && $_SESSION['typ_uzytkownika'] == "student" && isset($_GET['id'])) {
    $id_oferty = mysqli_real_escape_string($conn, $_GET['id']);
    $id_uzytkownika = $_SESSION['id']; 

    $sql = "SELECT * FROM aplikacje WHERE id_oferta = $id_oferty AND id_user = $id_uzytkownika";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo "Już aplikowałeś na tę ofertę!";
        header("refresh:3;url=oferty.php");
    } else {
        $sql = "SELECT * FROM pracownicy WHERE id = $id_uzytkownika";
        $result = mysqli_query($conn, $sql);
        $user = mysqli_fetch_assoc($result);

        echo "<h2>Aplikuj na ofertę</h2>";
        echo "<form method='POST' action='zapisz_aplikacje.php'>";
        echo "<input type='hidden' name='id_oferty' value='$id_oferty'>";
        echo "<input type='hidden' name='id_uzytkownika' value='$id_uzytkownika'>";
        echo "Kwalifikacje: <input type='text' name='kwalifikacje'><br>";
        echo "Chęci: <input type='text' name='checi'><br>";
        echo "<input type='submit' value='Aplikuj' name='submit'>";
        echo "</form>";
    }
} else {
    echo "Błąd aplikacji!";
}
mysqli_close($conn);
?>
