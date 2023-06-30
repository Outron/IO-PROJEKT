<?php
    session_start();
    require_once "connect.php";
    $connect = @new mysqli($host, $db_user, $db_password, $db_name);
    if($connect->connect_errno!=0){
        echo "Error: ".$connect->connect_errno." Opis: ".$connect->connect_error;
    } else{
        $user = $_POST['user'];
        $haslo = $_POST['haslo'];
        $user = htmlentities($user, ENT_QUOTES, "UTF-8");
        $haslo = htmlentities($haslo, ENT_QUOTES, "UTF-8");
$sqlPracodawcy = "SELECT * FROM pracodawcy WHERE login='$user' AND haslo='$haslo'";
if ($resultPracownicy = $connect->query(sprintf("SELECT * FROM pracownicy WHERE user='%s' AND haslo='%s'",
mysqli_real_escape_string($connect,$user),
mysqli_real_escape_string($connect,$haslo)))) {
    $user_number = $resultPracownicy->num_rows;
    if ($user_number > 0) {
        $_SESSION['zalogowany'] = true;
        $row = $resultPracownicy->fetch_assoc();

        $_SESSION['id'] = $row['id'];
        $_SESSION['user'] = $row['user'];
        $_SESSION['typ_uzytkownika'] = "student";

        unset($_SESSION['blad']);
        $resultPracownicy->free_result();
        header('Location: logowanie.php');
        echo $user;
    } else {
        if ($resultPracodawcy = $connect->query($sqlPracodawcy)) {
            $user_number = $resultPracodawcy->num_rows;
            if ($user_number > 0) {
                $_SESSION['zalogowany'] = true;
                $row = $resultPracodawcy->fetch_assoc();

                $_SESSION['id'] = $row['id'];
                $_SESSION['user'] = $row['login'];
	            $_SESSION['typ_uzytkownika'] = "pracodawca";


                unset($_SESSION['blad']);
                $resultPracodawcy->free_result();
                header('Location: logowanie.php');
                echo $user;
            } else {
                $_SESSION['blad'] = '<span style="color: red">Nieprawidłowy login lub hasło!</span>';
                header('Location: logowanie.php');
            }
        }
    }
}
$connect->close();
    }
?>