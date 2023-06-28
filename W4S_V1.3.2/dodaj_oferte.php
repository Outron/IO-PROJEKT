<!DOCTYPE html>
<html>
<head>
    <title>Dodaj ofertę</title>
</head>
<body>
    <?php
    session_start();
    if ($_SESSION['user']) {
        if ($_SESSION['typ_uzytkownika'] == "pracodawca") {
            include 'connect.php';
            $conn = mysqli_connect($host, $db_user, $db_password, $db_name);
            
            if (isset($_POST['submit'])) {
                $tytul_oferty = $_POST['tytul_oferty'];
                $autor = $_SESSION['user'];
                $data = date('Y-m-d H:i:s');
                $dyspozycyjnosc = $_POST['dyspozycyjnosc'];
                $tresc = $_POST['tresc'];
                $wymagania = $_POST['wymagania'];
                
                $sql = "INSERT INTO oferty (tytul_oferty, autor, data, dyspozycyjnosc, tresc, wymagania)
                        VALUES ('$tytul_oferty', '$autor', '$data', '$dyspozycyjnosc', '$tresc', '$wymagania')";
                
                if (mysqli_query($conn, $sql)) {
                    echo "Oferta została dodana pomyślnie.";
                    header("refresh:3;url=logowanie.php");
                } else {
                    echo "Błąd podczas dodawania oferty: " . mysqli_error($conn);
                    header("refresh:3;url=dodaj_oferte.php");
                }
            }
        }
    }
    ?>
    
    <h2>Dodaj ofertę</h2>
    
    <form method="POST" action="">
        <label for="tytul_oferty">Tytuł oferty:</label><br>
        <input type="text" id="tytul_oferty" name="tytul_oferty" required><br>
        
        <label for="dyspozycyjnosc">Dyspozycyjność:</label><br>
        <input type="text" id="dyspozycyjnosc" name="dyspozycyjnosc" required><br>
        
        <label for="tresc">Treść oferty:</label><br>
        <textarea id="tresc" name="tresc" required></textarea><br>
        
        <label for="wymagania">Wymagania:</label><br>
        <textarea id="wymagania" name="wymagania" required></textarea><br>
        
        <input type="submit" name="submit" value="Dodaj ofertę">
    </form>
</body>
</html>