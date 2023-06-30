<?php
session_start();
if ($_SESSION['user']) {
    include 'connect.php';
    $conn = mysqli_connect($host, $db_user, $db_password, $db_name);

    if (isset($_GET['id_oferty']) && isset($_GET['id_kandydata'])) {
        $id_oferty = $_GET['id_oferty'];
        $id_kandydata = $_GET['id_kandydata'];


        $sql = "SELECT pracownicy.imie, pracownicy.nazwisko, aplikacje.kwalifikacje, aplikacje.checi 
                FROM aplikacje
                INNER JOIN pracownicy ON aplikacje.id_user = pracownicy.id
                WHERE aplikacje.id_oferta = '$id_oferty' AND aplikacje.id_user = '$id_kandydata'";
        
        if ($ret = mysqli_query($conn, $sql)) {
            if ($row = mysqli_fetch_assoc($ret)) {
            echo "<h3>Informacje o kandydacie</h3>";
            echo "Imię: " . $row['imie'] . "<br>";
            echo "Nazwisko: " . $row['nazwisko'] . "<br>";
            echo "Kwalifikacje: " . $row['kwalifikacje'] . "<br>";
            echo "Chęci: " . $row['checi'] . "<br>";
            
        } else {
            echo "Nie znaleziono informacji o kandydacie.";
        }
    } else {
        echo "Nieprawidłowe ID oferty lub ID kandydata.";
    }

    }
} else {
    echo "Użytkownik niezalogowany.";
}
?>
