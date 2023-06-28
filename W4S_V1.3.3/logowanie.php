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
    <header>
    <a href = "index.php">WORK FOR STUDENTS</a>
      <nav>
        <ul>
        <?php
        if((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true)){
            echo '<li><a href="oferty.php">Oferty pracy</a></li>';
            echo '<li><a href="oferty.php">Dla pracodawcy</a></li>';
            echo '<li><a href="oferty.php">O nas</a></li>';
            echo '<li><a href="logout.php">Wyloguj się</a></li>';
            echo '<li id="user">Zalogowany: '.$_SESSION['user'].'</li>';
        } else {
            echo '<li><a href="oferty.php">Oferty pracy</a></li>';
            echo '<li><a href="oferty.php">Dla pracodawcy</a></li>';
            echo '<li><a href="oferty.php">O nas</a></li>';
            echo '<li id = "log-in"><a href="logowanie.php">Zaloguj się</a></li>'; 
        }
?>
        </ul>
      </nav>
    </header>

    <main>

<div class="wrapper">
  <div class="container">
    <div class="col-left">
      <div class="login-text">
        <h2>Work<br>For<br>Students</h2><br>
        
        <p>
         Zacznij pracę już dziś!
        </p>
      </div>
    </div>
    <div class="col-right">
      <div class="login-form">
        <?php
        if(@!$_SESSION['user']){
          echo "<h2>Zaloguj</h2>";
          echo "<form action='login.php' method='POST'>";
          echo "Nazwa użytkownika: <input type='text' name='user'/><br>";
          echo "Hasło: <input type='password' name='haslo'/><br>";
          echo "<input type='submit' value='Zaloguj się'/>";
          echo "</form>";
          if(isset($_SESSION['blad'])) echo $_SESSION['blad'];
          echo '<br>Nie masz konta? <a href="rejestracja.php">Zarejestruj się!</a>';          
        } else {
          echo "<h2>Zalogowano!</h2>";
          echo "Witaj ".$_SESSION['user']."! ";
          
          if ($_SESSION['typ_uzytkownika'] == "pracodawca") {
            echo "Co chcialbys zrobic?<br><br>";
                       echo "<a href='dodaj_oferte.php' ><span class='hero_btn_oferta' >Dodaj oferte pracy</span></a><br><br>";
                       echo "<a href='zarzadzaj_ofertami.php' ><span class='hero_btn_oferta' >Zarzadzaj ofertami pracy</span></a><br><br>";
                       echo "<a href='przegladaj_aplikacje.php' ><span class='hero_btn_oferta' >Przegladaj aplikacje na oferty pracy</span></a>";
            echo "<br><br>";
            echo "<br><br>";
                  } elseif ($_SESSION['typ_uzytkownika'] == "student") {
            echo "Co chcialbys zrobic?<br><br>";
                       echo "<a href='oferty.php' ><span class='hero_btn_oferta'>Przegladaj oferty pracy</span></a><br><br>";
                       echo "<a href='godziny_dostepnosci.php' ><span class='hero_btn_oferta'>Ustaw swoje preferencje</span></a><br><br>";
                       echo "<a href='przegladaj_aplikacje.php' ><span class='hero_btn_oferta' >Przegladaj oferty, na ktore aplikowales</span></a>";
            echo "<br><br>";
            echo "<br><br>";
                  }
        }
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