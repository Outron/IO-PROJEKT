<?php
session_start();
include 'connect.php';

$conn = mysqli_connect($host, $db_user, $db_password, $db_name);

if (!$conn) {
    die("Błąd łączenia z bazą danych: " . mysqli_connect_error());
}

if (isset($_POST['submit'])) {
    $id_oferty = mysqli_real_escape_string($conn, $_POST['id_oferty']);
    $id_uzytkownika = mysqli_real_escape_string($conn, $_POST['id_uzytkownika']);
    $kwalifikacje = mysqli_real_escape_string($conn, $_POST['kwalifikacje']);
    $checi = mysqli_real_escape_string($conn, $_POST['checi']);

    $sql = "INSERT INTO aplikacje (id_oferta, id_user, kwalifikacje, checi) VALUES ('$id_oferty', '$id_uzytkownika', '$kwalifikacje', '$checi')";

    if (mysqli_query($conn, $sql)) {
        echo "Aplikacja została wysłana!";
        header("refresh:3;url=index.php");
    } else {
        echo "Wystąpił błąd podczas aplikowania!";
        header("refresh:5;url=index.php");
    }
} else {
    echo "Błąd aplikacji!";
}
mysqli_close($conn);
?>
