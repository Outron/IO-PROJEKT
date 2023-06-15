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
      <nav>
        <ul>
<?php
        if((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true)){
            echo '<li><a href="index.php">Strona główna</a></li>';
            echo '<li><a href="oferty.php">Oferty pracy</a></li>';
            echo '<li><a href="logout.php">Wyloguj się</a></li>';
            echo '<li id="user">Zalogowany: '.$_SESSION['user'].'</li>';
        } else {
            echo '<li><a href="index.php">Strona główna</a></li>';
            echo '<li><a href="oferty.php">Oferty pracy</a></li>';
            echo '<li><a href="logowanie.php">Zaloguj się</a></li>'; 
        }
?>
        </ul>
      </nav>
    </header>

    <main id="test">
      <section class="hero">
        <h1>w4s.com – Work for Students</h1>
        <p>Znajdź pracę, która pasuje do Twojego stylu życia.</p>
        <a href="#">Szukaj pracy</a>
      </section>

      <section class="featured-jobs">
        <h2>Praca wyróżniona</h2>
        <div class="job-card">
          <h3>Programista Java</h3>
          <p>Wymagania: dobra znajomość Javy, doświadczenie w tworzeniu aplikacji webowych, umiejętność pracy w zespole</p>
          <a href="#">Aplikuj teraz</a>
        </div>
        <div class="job-card">
          <h3>Copywriter</h3>
          <p>Wymagania: dobra znajomość języka angielskiego, kreatywność, umiejętność pisania skutecznych tekstów reklamowych</p>
          <a href="#">Aplikuj teraz</a>
        </div>
      </section>

      <section class="how-it-works">
        <h2>Jak to działa?</h2>
        <ol>
          <li>Zarejestruj się na naszej stronie</li>
          <li>Przeglądaj dostępne oferty pracy</li>
          <li>Złóż aplikację na interesujące Cię stanowisko</li>
          <li>Czekaj na odpowiedź pracodawcy</li>
          <li>Rozpocznij pracę i zdobywaj doświadczenie</li>
        </ol>
      </section>
    </main>

    <footer>
      <p>w4s.com &copy; 2023</p>
    </footer>
  </body>
</html>