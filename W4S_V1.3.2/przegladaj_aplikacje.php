<?php
session_start();
if ($_SESSION['user']) {
    if ($_SESSION['typ_uzytkownika'] == "pracodawca") {
        include 'connect.php';
        $conn = mysqli_connect($host, $db_user, $db_password, $db_name);

        $user = $_SESSION['user'];

        $sql = "SELECT oferty.id, oferty.tytul_oferty, GROUP_CONCAT(CONCAT('<a href=\"#\" class=\"kandydat-link\" data-id=\"', aplikacje.id_user, '\">', pracownicy.imie, ' ', pracownicy.nazwisko, '</a>') SEPARATOR ', ') AS lista_aplikujacych
                FROM oferty
                LEFT JOIN aplikacje ON oferty.id = aplikacje.id_oferta
                LEFT JOIN pracownicy ON aplikacje.id_user = pracownicy.id
                WHERE oferty.autor = '$user'
                GROUP BY oferty.id, oferty.tytul_oferty;";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<h3>Zgłoszenia dla oferty nr: " . $row["id"] . "</h3>";
                echo "Oferta: " . $row["tytul_oferty"] . "<br>";

                $applicants = $row["lista_aplikujacych"];

                if ($applicants) {
                    echo "Lista chętnych: " . $applicants;
                } else {
                    echo "Brak zgłoszeń.";
                }

                echo "<br><br>";
            }
        } else {
            echo "Brak ofert.";
        }


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

<!-- Modal -->
<div id="kandydatModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <div id="kandydatDetails"></div>
    </div>
</div>

<script>
var modal = document.getElementById("kandydatModal");

var span = document.getElementsByClassName("close")[0];

var kandydatLinks = document.getElementsByClassName("kandydat-link");
for (var i = 0; i < kandydatLinks.length; i++) {
    kandydatLinks[i].addEventListener("click", function(event) {
        event.preventDefault();
        var kandydatId = this.getAttribute("data-id");
        fetchKandydatDetails(kandydatId);
        modal.style.display = "block";
    });
}

span.addEventListener("click", function() {
    modal.style.display = "none";
});

function fetchKandydatDetails(kandydatId) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("kandydatDetails").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "kandydat.php?id=" + kandydatId, true);
    xhttp.send();
}
</script>