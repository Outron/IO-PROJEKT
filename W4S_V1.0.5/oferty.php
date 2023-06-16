<?php
  session_start();
?>

<!DOCTYPE html>
<html lang="pl">
  <head>
    <meta charset="UTF-8">
    <title>w4s.com – Work for Students</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <?php include 'pasek.php'; ?>

    <main id="test" >
      <section class="hero" style="height: 200px" >
        <h1>w4s.com – Work for Students</h1>
        <h2>Oferty pracy</h2>
      </section>

      <section class="how-it-works">
      <?php
	include 'connect.php';

	// Create connection
	$conn = mysqli_connect($host, $db_user, $db_password, $db_name);

	// Check connection
	if (!$conn) {
		die("Bląd łączenia z bazą danych: " . mysqli_connect_error());
	}

	/* // Wybierz baze danych
	$sql = "use w4s;";
	if ($ret = mysqli_query($conn, $sql)) {
		/* echo "Database created successfully";
		echo "\r\n";
		var_dump($ret); */
	/* } else {
		echo "Error: " . mysqli_error($conn);
	}

	echo "\r\n"; */

	// Zapytanie
	if (isset($_GET["id"])) {
		// Przegladanie pojedynczej oferty

		$sql = "select * from oferty where id=" . mysqli_real_escape_string($conn, htmlentities($_GET["id"], ENT_QUOTES, "UTF-8")) . ";";
		if ($ret = mysqli_query($conn, $sql)) {
			if ($wiersz = mysqli_fetch_assoc($ret)) {
				echo "<h3>" . $wiersz["tytul_oferty"] ."</h3><br>";

				echo "<div class='ogloszenie_formatka' >";
				echo "Pracodawca: <i>". $wiersz["autor"] . "</i><br>";
				echo "Data zamieszenia oferty: " . $wiersz["data"] . "<br>";
				echo "Dyzpozycyjnosc: ";
				if ($wiersz["dyspozycyjnosc"] != "") {
					echo "<table style='border: 1px solid black' >";
					foreach (explode(";", $wiersz["dyspozycyjnosc"]) as $pierwszy_poziom) {
						echo "<tr>";
						foreach (explode(",", $pierwszy_poziom) as $drugi_poziom) {
							echo "<td style='border: 1px solid black' >" . $drugi_poziom . "</td>";
						}
						echo "</tr>";
					}
					echo "</table>";
				} else {
					echo "brak danych";
				}
				echo "<br>";
				echo "</div><br>";

				echo "<div class='ogloszenie_tresc' >";
				echo $wiersz["tresc"];
				echo "</div><br><br>";

			        if(@$_SESSION['user']){
					if ($_SESSION['typ_uzytkownika'] == "student") {
						echo "Spodobala ci sie ta ofeta?<br><br><a href='aplikuj.php?id=".$wiersz["id"]."' class='hero_btn_oferta' >Aplikuj</a>";
					}
				} else {
					echo "Spodobala ci sie ta ofeta?<br><br><a href='aplikuj.php?id=".$wiersz["id"]."' class='hero_btn_oferta' >Zarejestruj sie, aby aplikowac</a>";
				}
			} else {
				echo "Oferta nie istnieje!";
			}
		} else {
			echo "Wystapil blad serwera! Przepraszamy za utrudnienia!";
		}
	} else {
		$sql = "select * from oferty;";
		if ($ret = mysqli_query($conn, $sql)) {
			//cho "Zapytanie select";
			//echo "\r\n";
			while ($wiersz = mysqli_fetch_assoc($ret)) {
				// var_dump($wiersz);
				echo "<div class='oferta' style='border: 1px solid black; border-radius: 1em 0 0 0; padding: 0.5em; margin: 0.5em' >";
				echo "<a href='oferty.php?id=" . $wiersz["id"] . "' ><h3>" . $wiersz["tytul_oferty"] ."</h3></a><br>";
				echo "Zamiescil <i>". $wiersz["autor"] . "</i> w dniu " . $wiersz["data"];
				echo "</div><br>";
			}
		} else {
			echo "Blad odpytania bazy danych: " . mysqli_error($conn);
		}
	}

	mysqli_close($conn); 
      ?>
       </section>
    </main>


    <footer>
      <p>w4s.com &copy; 2023</p>
    </footer>
  </body>
</html>
