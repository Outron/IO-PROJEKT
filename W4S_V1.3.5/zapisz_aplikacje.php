<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Aplikuj</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <?php include 'pasek.php'; ?>
    </header>
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
        echo "<h1 style='text-align:center;margin-top:200px;'>Aplikacja została wysłana!</h1>";
        header("refresh:3;url=index.php");
    } else {
        echo "<h1 style='text-align:center;margin-top:200px;'>Wystąpił błąd podczas aplikowania!</h1>";
        header("refresh:5;url=index.php");
    }
} else {
    echo "<h1 style='text-align:center;'>Błąd aplikacji!</h1>";
}
mysqli_close($conn);
?>
