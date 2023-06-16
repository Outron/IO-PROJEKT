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

        if(@$_SESSION['user']){
		// Zapytanie
		if (isset($_GET["id"])) {
			echo "<h1>Aplikujesz na oferte nr " . $_GET["id"] . "</h1>";
		}
	} else {
		echo "<h1>Zarejestruj sie, aby aplikowac na oferte pracy!</h1>";
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
