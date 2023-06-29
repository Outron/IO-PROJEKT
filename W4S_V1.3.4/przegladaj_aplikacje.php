<?php
session_start();
if ($_SESSION['user']) {
    if ($_SESSION['typ_uzytkownika'] == "pracodawca") {
        include 'connect.php';
        $conn = mysqli_connect($host, $db_user, $db_password, $db_name);

        $user = $_SESSION['user'];

        $sql = "SELECT oferty.id, oferty.tytul_oferty, aplikacje.id_user, CONCAT(pracownicy.imie, ' ', pracownicy.nazwisko) AS aplikujacy
                FROM oferty
                LEFT JOIN aplikacje ON oferty.id = aplikacje.id_oferta
                LEFT JOIN pracownicy ON aplikacje.id_user = pracownicy.id
                WHERE oferty.autor = '$user'
                GROUP BY oferty.id, aplikacje.id_user;";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $currentOfferId = null;

            while ($row = mysqli_fetch_assoc($result)) {
                $offerId = $row["id"];
                $kandydatId = $row["id_user"];

                if ($offerId != $currentOfferId) {
                    $currentOfferId = $offerId;
                    echo "<h3>Zgłoszenia dla oferty nr: " . $row["id"] . "</h3>";
                    echo "Oferta: " . $row["tytul_oferty"] . "<br>";
                }

                if($kandydatId){
                    $link = "kandydat.php?id_oferty=$offerId&id_kandydata=$kandydatId";
                    echo "Kandydat: <a href='#' onclick='loadKandydatContent(\"$link\")'>" . $row["aplikujacy"] . "</a>";
    
                    echo "<br>";
                } else{
                    echo "Brak kandydatów!";
                }

            }
        } else {
            echo "Brak ofert.";
        }

        echo "<div id='kandydatContentDiv'></div>"; 

        echo "<div id='buttonsDiv' style='display: none;'>"; 
        echo "<button id='przyjmijBtn' onclick='przyjmijKandydata()'>Przyjmij</button>"; 
        echo "<button id='zamknijBtn' onclick='closeKandydatContent()'>Zamknij</button>"; 
        echo "</div>";
    } elseif ($_SESSION['typ_uzytkownika'] == "student") {
        include 'connect.php';
        $student_id = $_SESSION['id'];
        $conn = mysqli_connect($host, $db_user, $db_password, $db_name);
        $sql = "SELECT oferty.*
                FROM oferty
                INNER JOIN aplikacje ON oferty.id = aplikacje.id_oferta
                WHERE aplikacje.id_user = '$student_id';";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<h3>" . $row["tytul_oferty"] . "</h3><br>";

                echo "<div class='ogloszenie_formatka' >";
                echo "Pracodawca: <i>" . $row["autor"] . "</i><br>";
                echo "Data zamieszczenia oferty: " . $row["data"] . "<br>";
                echo "Dyspozycyjność: ";
                if ($row["dyspozycyjnosc"] != "") {
                    echo "<table style='border: 1px solid black'>";
                    foreach (explode(";", $row["dyspozycyjnosc"]) as $pierwszy_poziom) {
                        echo "<tr>";
                        foreach (explode(",", $pierwszy_poziom) as $drugi_poziom) {
                            echo "<td style='border: 1px solid black'>" . $drugi_poziom . "</td>";
                        }
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "brak danych";
                }
                echo "<br>";
                echo "</div><br>";

                echo "<div class='ogloszenie_tresc'>";
                echo $row["tresc"];
                echo "</div><br><br>";
                echo "<hr>";
            }
        } else {
            echo "Nie aplikowałeś do żadnej oferty!";
        }
    }
}
?>
<script>
    function loadKandydatContent(link) {
        var kandydatContentDiv = document.getElementById('kandydatContentDiv');
        var buttonsDiv = document.getElementById('buttonsDiv');
        var przyjmijBtn = document.getElementById('przyjmijBtn');
        var zamknijBtn = document.getElementById('zamknijBtn');

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                kandydatContentDiv.innerHTML = this.responseText;
                kandydatContentDiv.style.display = 'block';
                buttonsDiv.style.display = 'block'; 
            }
        };
        xhttp.open("GET", link, true);
        xhttp.send();
    }

    function closeKandydatContent() {
        var kandydatContentDiv = document.getElementById('kandydatContentDiv');
        var buttonsDiv = document.getElementById('buttonsDiv');

        kandydatContentDiv.innerHTML = '';
        kandydatContentDiv.style.display = 'none';
        buttonsDiv.style.display = 'none';
    }

    function przyjmijKandydata() {
        alert("Pomyślnie przyjęto! (mailto)");
        // Kod obsługujący akcję przyjęcia kandydata
    }
</script>