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

    <main>
      <?php
        if(@!$_SESSION['user']){
          echo "<form action='login.php' method='POST'>";
          echo "Login: <input type='text' name='user'/><br>";
          echo "Hasło: <input type='password' name='haslo'/><br>";
          echo "<input type='submit' value='Zaloguj się'/>";
          echo "</form>";
          if(isset($_SESSION['blad'])) echo $_SESSION['blad'];
          echo '<br>Nie masz konta? <a href="rejestracja.php">Zarejestruj się!</a>';          
        } else {
          echo "Witaj ".$_SESSION['user']."!";
          echo "<br><br>";

          if ($_SESSION['typ_uzytkownika'] == "pracodawca") {
		echo "Co chcialbys zrobic?<br><br><br>";
               echo "<a href='dodaj_oferte.php' ><span class='hero_btn_oferta' >Dodaj oferte pracy</span></a><br><br><br><br>";
               echo "<a href='zarzadzaj_ofertami.php' ><span class='hero_btn_oferta' >Zarzadzaj ofertami pracy</span></a><br><br><br><br>";
               echo "<a href='przegladaj_aplikacje.php' ><span class='hero_btn_oferta' >Przegladaj aplikacje na oferty pracy</span></a><br><br><br><br>";
		echo "<br><br>";
		echo "<br><br>";
          } elseif ($_SESSION['typ_uzytkownika'] == "student") {
		echo "Co chcialbys zrobic?<br><br><br>";
               echo "<a href='oferty.php' ><span class='hero_btn_oferta' >Przegladaj oferty pracy</span></a><br><br><br><br>";
               echo "<a href='godziny_dostepnosci.php' ><span class='hero_btn_oferta' >Ustaw swoje preferencje</span></a><br><br><br><br>";
               echo "<a href='oferty.php' ><span class='hero_btn_oferta' >Przegladaj oferty, na ktore aplikowales</span></a><br><br><br><br>";
		echo "<br><br>";
		echo "<br><br>";
          }

        }
      ?>
       
    </main>


    <footer>
      <p>w4s.com &copy; 2023</p>
    </footer>
  </body>
</html>
