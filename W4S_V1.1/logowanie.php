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
        <h2>Zaloguj</h2>
        <?php
        if(@!$_SESSION['user']){
          echo "<form action='login.php' method='POST'>";
          echo "Nazwa użytkownika: <input type='text' name='user'/><br>";
          echo "Hasło: <input type='password' name='haslo'/><br>";
          echo "<input type='submit' value='Zaloguj się'/>";
          echo "</form>";
          if(isset($_SESSION['blad'])) echo $_SESSION['blad'];
          echo '<br>Nie masz konta? <a href="rejestracja.php">Zarejestruj się!</a>';          
        } else {
          echo "Witaj ".$_SESSION['user']."!";
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