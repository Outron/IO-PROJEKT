<header>
      <a href = "index.php">WORK FOR STUDENTS</a>
      <nav>
        <ul>
        <?php
        if((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true)){
            echo '<li><a href="oferty.php">Oferty pracy</a></li>';
            echo '<li><a href="logout.php">Wyloguj się</a></li>';
            echo '<li id="user">Zalogowany: <a href="logowanie.php" placeholder="Wejdz do swojego profilu" >'.$_SESSION['user'].'</a></li>';
        } else {
            echo '<li><a href="index.php">Strona główna</a></li>';
            echo '<li><a href="oferty.php">Oferty pracy</a></li>';
            echo '<li id = "log-in"><a href="logowanie.php">Zaloguj się</a></li>'; 
        }
?>
        </ul>
      </nav>
    </header>