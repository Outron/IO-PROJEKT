<?php
include 'connect.php';
$conn = mysqli_connect($host, $db_user, $db_password, $db_name);

if (isset($_GET['id'])) {
    $kandydat_id = $_GET['id'];

    $sql = "SELECT pracownicy.imie, pracownicy.nazwisko, pracownicy.email, pracownicy.nrtel, aplikacje.kwalifikacje, aplikacje.checi
            FROM pracownicy
            INNER JOIN aplikacje ON pracownicy.id = aplikacje.id_user
            WHERE pracownicy.id = '$kandydat_id';";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        echo "Imię: " . $row['imie'] . "<br>";
        echo "Nazwisko: " . $row['nazwisko'] . "<br>";
        echo "Email: " . $row['email'] . "<br>";
        echo "Numer telefonu: " . $row['nrtel'] . "<br>";
        echo "Kwalifikacje: " . $row['kwalifikacje'] . "<br>";
        echo "Chęci: " . $row['checi'] . "<br>";
    } else {
        echo "Nie znaleziono danych dla tego kandydata.";
    }
} else {
    echo "Brak danych kandydata.";
}
?>