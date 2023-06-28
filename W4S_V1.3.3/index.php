<?php
  session_start();
  include 'connect.php';

  $conn = mysqli_connect($host, $db_user, $db_password, $db_name);

  if (!$conn) {
      die('Błąd połączenia z bazą danych: ' . mysqli_connect_error());
  }

  $query = "SELECT * FROM oferty ORDER BY RAND() LIMIT 4";
  $result = mysqli_query($conn, $query);

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
      <a href="index.php">WORK FOR STUDENTS</a>
      <nav>
        <ul>
          <?php
          if (isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] == true) {
            echo '<li><a href="oferty.php">Oferty pracy</a></li>';
            echo '<li><a href="logout.php">Wyloguj się</a></li>';
            echo '<li id="user"><a href="logowanie.php">Zalogowany: ' . $_SESSION['user'] . '</a></li>';
          } else {
            echo '<li><a href="oferty.php">Oferty pracy</a></li>';
            echo '<li><a href="oferty.php">Dla pracodawcy</a></li>';
            echo '<li><a href="oferty.php">O nas</a></li>';
            echo '<li id="log-in"><a href="logowanie.php">Zaloguj się</a></li>';
          }
          ?>
        </ul>
      </nav>
    </header>
    <main id="test">
  <section class="hero">
    <h1>w4s.com – Work for Students</h1>
    <p>Znajdź pracę, która pasuje do Twojego stylu życia.</p>
    <a href="oferty.php">Szukaj pracy</a>
  </section>

  <section class="featured-jobs">
    <?php
    // Wyświetl losowe oferty pracy
    while ($row = mysqli_fetch_assoc($result)) {
      echo '<div class="job-card">';
      echo '<h3>' . $row['tytul_oferty'] . '</h3>';
      echo '<p>Wymagania: ' . $row['wymagania'] . '</p><br>';
      echo '<a href="oferty.php?id=' . $row['id'] . '">Aplikuj teraz</a>';
      echo '</div>';
    }
    ?>
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