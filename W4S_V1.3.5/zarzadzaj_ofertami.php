<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Zarządzaj ofertami</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .oferta {
            cursor: pointer;
            margin-bottom: 10px;
        }
        
        .opcje-oferty {
            display: none;
        }
    </style>
    <script>
        $(document).ready(function() {
            $(".oferta").click(function() {
                //$(this).next().slideToggle();
		location.href = "zarzadzaj_oferta.php?id=" + $(this)[0].attributes.x_idoferty.value;
            });
        });
    </script>
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
        <h2 style='font-size: 36px;'>Zarządzaj swoimi ofertami</h2>
    <?php
    if ($_SESSION['user']) {
        if ($_SESSION['typ_uzytkownika'] == "pracodawca") {
            include 'connect.php';
            $conn = mysqli_connect($host, $db_user, $db_password, $db_name);
            $user = $_SESSION['user'];
            
            if (isset($_POST['update'])) {
                $id = $_POST['id'];
                $tytul_oferty = $_POST['tytul_oferty'];
                $dyspozycyjnosc = $_POST['dyspozycyjnosc'];
                $tresc = $_POST['tresc'];
                $wymagania = $_POST['wymagania'];
                
                $sql = "UPDATE oferty
                        SET tytul_oferty = '$tytul_oferty', dyspozycyjnosc = '$dyspozycyjnosc', tresc = '$tresc', wymagania = '$wymagania'
                        WHERE id = '$id' AND autor = '$user'";
                
                if (mysqli_query($conn, $sql)) {
                    echo "<h1 style='text-align:left; padding: 30px;'>Oferta została zaktualizowana pomyślnie.</h1>";
                    header("refresh:3;url=zarzadzaj_ofertami.php");
                } else {
                    echo "<h1 style='text-align:left;padding: 30px;'>Błąd podczas aktualizacji oferty: </h1>" . mysqli_error($conn);
                    header("refresh:3;url=zarzadzaj_ofertami.php");
                }
            }
            
            if (isset($_POST['delete'])) {
                $id = $_POST['id'];
                
                // Usunięcie rekordów powiązanych z daną ofertą w tabeli "aplikacje"
                $deleteAplikacje = "DELETE FROM aplikacje WHERE id_oferta = '$id'";
                mysqli_query($conn, $deleteAplikacje);
                
                // Usunięcie danej oferty
                $deleteOferta = "DELETE FROM oferty WHERE id = '$id' AND autor = '$user'";
                
                if (mysqli_query($conn, $deleteOferta)) {
                    echo "<h1 style='text-align:left; padding: 30px;'>Oferta została usunięta pomyślnie.</h1>";
                    header("refresh:3;url=zarzadzaj_ofertami.php");
                } else {
                    echo "<h1 style='text-align:left; padding: 30px;'>Błąd podczas usuwania oferty: </h1>" . mysqli_error($conn);
                    header("refresh:3;url=zarzadzaj_ofertami.php");
                }
            }
            
            $sql = "SELECT * FROM oferty WHERE autor = '$user'";
            $result = mysqli_query($conn, $sql);
            
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $id = $row['id'];
                    $tytul_oferty = $row['tytul_oferty'];
                    $dyspozycyjnosc = $row['dyspozycyjnosc'];
                    $tresc = $row['tresc'];
                    $wymagania = $row['wymagania'];
                    
                    echo "<div class='oferta' x_idoferty='" . $id . "' ><h3 style='font-size: 22px;'>Oferta nr: " . $id . "</h3>";
                    echo "<p>Tytuł oferty: " . $tytul_oferty . "</p></div>";
                    
                    echo "<div class='opcje-oferty'>";
                    echo "<form method='POST' action=''>";
                    echo "<input type='hidden' name='id' value='" . $id . "'>";
                    echo "<label for='tytul_oferty'>Tytuł oferty:</label><br>";
                    echo "<input type='text' id='tytul_oferty' name='tytul_oferty' value='" . $tytul_oferty . "' required><br>";
                    echo "<label for='dyspozycyjnosc'>Dyspozycyjność:</label><br>";
                    echo "<input type='text' id='dyspozycyjnosc' name='dyspozycyjnosc' value='" . $dyspozycyjnosc . "' required><br>";
                    echo "<label for='tresc'>Treść:</label><br>";
                    echo "<textarea id='tresc' name='tresc' required>" . $tresc . "</textarea><br>";
                    echo "<label for='wymagania'>Wymagania:</label><br>";
                    echo "<textarea id='wymagania' name='wymagania' required>" . $wymagania . "</textarea><br>";
                    echo "<input type='submit' name='update' value='Zaktualizuj'>";
                    echo "<input type='submit' name='delete' value='Usuń' onclick='return confirm(\"Czy na pewno chcesz usunąć tę ofertę?\")'>";
                    echo "</form>";
                    echo "</div>";
                }
            } else {
                echo "<h1 style='text-align:center; padding: 30px;'>Brak ofert do wyświetlenia.</h1>";
            }
        }
    }
    ?>
    
</body>
</html>
