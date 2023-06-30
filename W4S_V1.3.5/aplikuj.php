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

<div class="wrapper-app">
  <div class="container-app">
    <div class="col-left-app">
      <div class="login-text-app">
        <h2>Work<br>For<br>Students</h2><br>
        
            <h3>
            Aplikuj 
</h3>
      </div>
    </div>
    <div class="col-right-app">
      <div class="login-form-app">
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
        echo "<h1 style='text-align:center;'>Już aplikowałeś na tę ofertę!</h1>";
        header("refresh:3;url=oferty.php");
    } else {
        $sql_oferty = "SELECT * FROM oferty WHERE id = $id_oferty";
        $result_oferty = mysqli_query($conn, $sql_oferty);
        $oferta = mysqli_fetch_assoc($result_oferty);
        $tytul_oferty = $oferta['tytul_oferty'];

        $sql = "SELECT * FROM pracownicy WHERE id = $id_uzytkownika";
        $result = mysqli_query($conn, $sql);
        $user = mysqli_fetch_assoc($result);

        echo "<h2>Aplikuj na ofertę o ID ".$id_oferty." - ".$tytul_oferty."</h2>";
        echo "<form method='POST' action='zapisz_aplikacje.php'>";
        echo "<input type='hidden' name='id_oferty' value='$id_oferty'>";
        echo "<input type='hidden' name='id_uzytkownika' value='$id_uzytkownika'>";
        echo "Kwalifikacje: <input type='text' name='kwalifikacje'><br>";
        echo "Chęci: <input type='text' name='checi'><br>";
        echo "Pracodawca będzie mógł zobaczyć twoje imię, nazwisko, numer telefonu oraz adres email.<br><br>";
        echo "<input type='submit' value='Aplikuj' name='submit'>";
        echo "</form>";
    }
} else {
    echo "<h1 style='text-align:center;'>Błąd aplikacji!</h1>";
}
mysqli_close($conn);
?>

</div>
    </div>
  </div>
</div>
<footer>
      <p>w4s.com &copy; 2023</p>
    </footer>
</body>
</html>