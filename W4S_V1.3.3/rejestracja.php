<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Sprawdzenie, czy pole userType istnieje
  if (isset($_POST["userType"])) {
    $userType = $_POST["userType"];

// -----------------------------------------------------PRACOWNIK-----------------------------------------------------------
    if ($userType == "employee") {
        if((isset($_POST['email']))){
            $wszystko_OK=true;
        
            //WALIDACJA LOGINU
            $user=$_POST['user'];
            if((strlen($user)<3) || (strlen($user)>15)){
              $wszystko_OK=false;
              $_SESSION['e_user']="Nazwa użytkownika powinna posiadać długość od 3 do 16 znaków!";
            }
            if(ctype_alnum($user)==false){
              $wszystko_OK=false;
              $_SESSION['e_user']="Nazwa użytkownika powinna składać się wyłącznie z liter i cyfr - bez znaków diakrytycznych!";
            }
        
            //WALIDACJA HASLA
            $haslo=$_POST['haslo'];
            if((strlen($haslo)<3) || (strlen($haslo)>128)){
              $wszystko_OK=false;
              $_SESSION['e_haslo']="Haslo powinno posiadać długość od 3 do 128 znaków!";
            }
        
            //WALIDACJA IMIE
            $imie=$_POST['imie'];
            $imie = ucfirst($imie);
            function validate_imie($imie){
              $reg = "/^[a-zA-ZęóąśłżźćńĘÓĄŚŁŻŹĆŃ]{2,50}$/";
              return preg_match($reg,$imie);
            }
            if(validate_imie($imie)==0){
              $wszystko_OK=false;
              $_SESSION['e_imie']="Niepoprawne imie!";
            }
        
            //WALIDACJA NAZWISKO
            $nazwisko=$_POST['nazwisko'];
            $nazwisko = ucfirst($nazwisko);
            function validate_nazwisko($nazwisko){
              $reg = "/^[a-zA-ZęóąśłżźćńĘÓĄŚŁŻŹĆŃ]{2,}$/";
              return preg_match($reg,$nazwisko);
            }
            if(validate_nazwisko($nazwisko)==0){
              $wszystko_OK=false;
              $_SESSION['e_nazwisko']="Niepoprawne nazwisko!";
            }
        
            //WALIDACJA EMAIL
            $email = $_POST['email'];
            $emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
        
            if((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email)){
              $wszystko_OK=false;
              $_SESSION['e_email']="Podaj poprawny adres email!";
            }
        
        
            //WALIDACJA NUMERU TELEFONU
            $nrtel=$_POST['nrtel'];
        
            function validate_nrtel($nrtel) {
              $reg = '/^[0-9]{9}$/';
              return preg_match($reg, $nrtel);
            }
            if(validate_nrtel($nrtel)==0){
              $wszystko_OK=false;
              $_SESSION['e_nrtel']="Numer telefonu musi się składać z 9 cyfr!";
            }
        
            //WALIDACJA REGULAMIN
            if(!isset($_POST['regulamin'])){
              $wszystko_OK=false;
              $_SESSION['e_regulamin']="Aby korzystać z serwisu, należy zaakceptować regulamin!";
            }
        
            //ZAPAMIĘTYWANIE WPROWADZONYCH DANYCH
            $_SESSION['formularz_user'] = $user;
            $_SESSION['formularz_haslo'] = $haslo;
            $_SESSION['formularz_imie'] = $imie;
            $_SESSION['formularz_nazwisko'] = $nazwisko;
            $_SESSION['formularz_email'] = $email;
            $_SESSION['formularz_nrtel'] = $nrtel;
            if(isset($_POST['regulamin'])) $_SESSION['formularz_regulamin'] = true;
        
            //SPRAWDZENIE ISTENIJACEGO USERA
            require_once "connect.php";
        
            mysqli_report(MYSQLI_REPORT_STRICT);
        
            try{
              $connect = new mysqli($host, $db_user, $db_password, $db_name);
              if($connect->connect_errno!=0){
                throw new Exception(mysqli_connect_errono());
              }
              else{
                //SPRAWDZANIE CZY ISTNIEJE W BAZIE DANY EMAIL
                $result = $connect->query("SELECT id FROM pracownicy WHERE email='$email'");
                if(!$result) throw new Exception($connect->error);
                $email_count = $result->num_rows;
                if($email_count>0){
                  $wszystko_OK=false;
                  $_SESSION['e_email']="Istnieje już konto przypisane do tego adresu email!";
                }
                $result = $connect->query("SELECT id FROM pracodawcy WHERE email='$email'");
                if(!$result) throw new Exception($connect->error);
                $email_count = $result->num_rows;
                if($email_count>0){
                  $wszystko_OK=false;
                  $_SESSION['e_email']="Istnieje już konto przypisane do tego adresu email!";
                }
        
                //SPRAWDZANIE CZY ISTNIEJE W BAZIE DANY LOGIN
                $result = $connect->query("SELECT id FROM pracownicy WHERE user='$user'");
                if(!$result) throw new Exception($connect->error);
                $user_count = $result->num_rows;
                if($user_count>0){
                  $wszystko_OK=false;
                  $_SESSION['e_user']="Istnieje już konto o takiej nazwie użytkownika!";
                }
                $result = $connect->query("SELECT id FROM pracodawcy WHERE login='$user'");
                if(!$result) throw new Exception($connect->error);
                $user_count = $result->num_rows;
                if($user_count>0){
                  $wszystko_OK=false;
                  $_SESSION['e_user']="Istnieje już konto o takiej nazwie użytkownika!";
                }
        
                //JESLI WSZYSTKO JEST OK - WPIS DO BAZY
                if($wszystko_OK==true){
                  if($connect->query("INSERT INTO pracownicy VALUES (NULL, '$user','$haslo','$imie','$nazwisko','$email','$nrtel')")){
                    $_SESSION['udanarejestracja']=true;
                    header("refresh:5;url=index.php");
                    echo "Rejestracja przebiegła pomyślnie. Za chwilę zostaniesz przekierowany na stronę główną.";
                  }
                  else{
                    throw new Exception($connect->error);
                  }
                }
        
                $connect->close();
              }
            }
            catch(Exception $e){
              echo '<span style="color:red;">Błąd serwera!</span>';
            }
          }
      // Jeśli walidacja się nie powiedzie, zapisz wartości w sesji
      if($wszystko_OK==false){
        $_SESSION['userType'] = $userType;
        header("Location: rejestracja.php");
        exit();
      }

    } elseif ($userType == "employer") {

      // -----------------------------------------------------PRACODAWCA-----------------------------------------------------------
      if((isset($_POST['email_pracodawca']))){
        $wszystko_OK=true;
    
        //WALIDACJA LOGINU
        $login=$_POST['login'];
        if((strlen($login)<3) || (strlen($login)>15)){
          $wszystko_OK=false;
          $_SESSION['e_login']="Nazwa użytkownika powinna posiadać długość od 3 do 16 znaków!";
        }
        if(ctype_alnum($login)==false){
          $wszystko_OK=false;
          $_SESSION['e_login']="Nazwa użytkownika powinna składać się wyłącznie z liter i cyfr - bez znaków diakrytycznych!";
        }
    
        //WALIDACJA HASLA
        $haslo_pracodawca=$_POST['haslo_pracodawca'];
        if((strlen($haslo_pracodawca)<3) || (strlen($haslo_pracodawca)>128)){
          $wszystko_OK=false;
          $_SESSION['e_haslo_pracodawca']="Haslo powinno posiadać długość od 3 do 128 znaków!";
        }
    
        //WALIDACJA IMIE
        $imie_pracodawca=$_POST['imie_pracodawca'];
        $imie_pracodawca = ucfirst($imie_pracodawca);
        function validate_imie($imie_pracodawca){
          $reg = "/^[a-zA-ZęóąśłżźćńĘÓĄŚŁŻŹĆŃ]{2,50}$/";
          return preg_match($reg,$imie_pracodawca);
        }
        if(validate_imie($imie_pracodawca)==0){
          $wszystko_OK=false;
          $_SESSION['e_imie_pracodawca']="Niepoprawne imie!";
        }
    
        //WALIDACJA NAZWISKO
        $nazwisko_pracodawca=$_POST['nazwisko_pracodawca'];
        $nazwisko_pracodawca = ucfirst($nazwisko_pracodawca);
        function validate_nazwisko($nazwisko_pracodawca){
          $reg = "/^[a-zA-ZęóąśłżźćńĘÓĄŚŁŻŹĆŃ]{2,}$/";
          return preg_match($reg,$nazwisko_pracodawca);
        }
        if(validate_nazwisko($nazwisko_pracodawca)==0){
          $wszystko_OK=false;
          $_SESSION['e_nazwisko_pracodawca']="Niepoprawne nazwisko!";
        }
    
        //WALIDACJA EMAIL
        $email_pracodawca = $_POST['email_pracodawca'];
        $emailB_pracodawca = filter_var($email_pracodawca, FILTER_SANITIZE_EMAIL);
    
        if((filter_var($emailB_pracodawca, FILTER_VALIDATE_EMAIL)==false) || ($emailB_pracodawca!=$email_pracodawca)){
          $wszystko_OK=false;
          $_SESSION['e_email_pracodawca']="Podaj poprawny adres email!";
        }
    
    
        //WALIDACJA NUMERU TELEFONU
        $nrtel_pracodawca=$_POST['nrtel_pracodawca'];
    
        function validate_nrtel($nrtel_pracodawca) {
          $reg = '/^[0-9]{9}$/';
          return preg_match($reg, $nrtel_pracodawca);
        }
        if(validate_nrtel($nrtel_pracodawca)==0){
          $wszystko_OK=false;
          $_SESSION['e_nrtel_pracodawca']="Numer telefonu musi się składać z 9 cyfr!";
        }

        //WALIDACJA NIP
        $NIP=$_POST['NIP'];
    
        function validate_NIP($NIP) {
          $reg = '/^[0-9]{10}$/';
          return preg_match($reg, $NIP);
        }
        if(validate_NIP($NIP)==0){
          $wszystko_OK=false;
          $_SESSION['e_NIP']="NIP musi się składać z 10 cyfr!";
        }

        //WALIDACJA REGON
        $REGON=$_POST['REGON'];
    
        function validate_REGON($REGON) {
          $reg = '/^\d{9}(?:\d{5})?$/';
          return preg_match($reg, $REGON);
        }
        if(validate_REGON($REGON)==0){
          $wszystko_OK=false;
          $_SESSION['e_REGON']="REGON musi się składać z 9 cyfr!";
        }

        //WALIDACJA ADRESU
        $adres=$_POST['adres'];
        function validateAdres($adres){
            $parts = explode(',', $adres);
            if (count($parts) !== 2) {
                return false;
            }
            $street = trim($parts[0]);
            $city = trim($parts[1]);
            if (empty($street) || empty($city)) {
                return false;
            }
            if (!preg_match('/^[a-zA-Z0-9ąćęłńóśźżĄĆĘŁŃÓŚŹŻ ,]+$/', $street)) {
                return false;
            }
            if (!preg_match('/^[a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ]+$/', $city)) {
                return false;
            }
            return true;
        }
        
        if(validateAdres($adres)==0){
          $wszystko_OK=false;
          $_SESSION['e_adres']="Niepoprawny adres! Przykładowy poprawny format adresu: <b>Długosza 15, Kraków</b>";
        }

    
        //WALIDACJA REGULAMIN
        if(!isset($_POST['regulamin_pracodawca'])){
          $wszystko_OK=false;
          $_SESSION['e_regulamin_pracodawca']="Aby korzystać z serwisu, należy zaakceptować regulamin!";
        }
    
        $nazwa_firmy=$_POST['nazwa_firmy'];

        //ZAPAMIĘTYWANIE WPROWADZONYCH DANYCH
        $_SESSION['formularz_login'] = $login;
        $_SESSION['formularz_haslo_pracodawca'] = $haslo_pracodawca;
        $_SESSION['formularz_imie_pracodawca'] = $imie_pracodawca;
        $_SESSION['formularz_nazwisko_pracodawca'] = $nazwisko_pracodawca;
        $_SESSION['formularz_email_pracodawca'] = $email_pracodawca;
        $_SESSION['formularz_nrtel_pracodawca'] = $nrtel_pracodawca;
        $_SESSION['formularz_NIP'] = $NIP;
        $_SESSION['formularz_REGON'] = $REGON;
        $_SESSION['formularz_adres'] = $adres;
        $_SESSION['formularz_nazwa_firmy'] = $nazwa_firmy;
        if(isset($_POST['regulamin_pracodawca'])) $_SESSION['formularz_regulamin_pracodawca'] = true;
    
        //SPRAWDZENIE ISTENIJACEGO USERA
        require_once "connect.php";
    
        mysqli_report(MYSQLI_REPORT_STRICT);
    
        try{
          $connect = new mysqli($host, $db_user, $db_password, $db_name);
          if($connect->connect_errno!=0){
            throw new Exception(mysqli_connect_errono());
          }
          else{
            //SPRAWDZANIE CZY ISTNIEJE W BAZIE DANY EMAIL
            $result = $connect->query("SELECT id FROM pracodawcy WHERE email='$email_pracodawca'");
            if(!$result) throw new Exception($connect->error);
            $email_count = $result->num_rows;
            if($email_count>0){
              $wszystko_OK=false;
              $_SESSION['e_email_pracodawca']="Istnieje już konto przypisane do tego adresu email!";
            }
            $result = $connect->query("SELECT id FROM pracownicy WHERE email='$email_pracodawca'");
            if(!$result) throw new Exception($connect->error);
            $email_count = $result->num_rows;
            if($email_count>0){
              $wszystko_OK=false;
              $_SESSION['e_email_pracodawca']="Istnieje już konto przypisane do tego adresu email!";
            }
    
            //SPRAWDZANIE CZY ISTNIEJE W BAZIE DANY LOGIN
            $result = $connect->query("SELECT id FROM pracodawcy WHERE login='$login'");
            if(!$result) throw new Exception($connect->error);
            $user_count = $result->num_rows;
            if($user_count>0){
              $wszystko_OK=false;
              $_SESSION['e_login']="Istnieje już konto o takiej nazwie użytkownika!";
            }
            $result = $connect->query("SELECT id FROM pracownicy WHERE user='$login'");
            if(!$result) throw new Exception($connect->error);
            $user_count = $result->num_rows;
            if($user_count>0){
              $wszystko_OK=false;
              $_SESSION['e_login']="Istnieje już konto o takiej nazwie użytkownika!";
            }
    
            //JESLI WSZYSTKO JEST OK - WPIS DO BAZY
            if($wszystko_OK==true){
              if($connect->query("INSERT INTO pracodawcy (login, haslo, imie, nazwisko, email, nrtel, NIP, REGON, adres, nazwa_firmy) 
              VALUES ('$login', '$haslo_pracodawca', '$imie_pracodawca', '$nazwisko_pracodawca', '$email_pracodawca', '$nrtel_pracodawca', '$NIP', '$REGON', '$adres', '$nazwa_firmy')")){
                $_SESSION['udanarejestracja']=true;
                header("refresh:5;url=index.php");
                echo "Rejestracja przebiegła pomyślnie. Za chwilę zostaniesz przekierowany na stronę główną.";
              }
              else{
                throw new Exception($connect->error);
              }
            }
    
            $connect->close();
          }
        }
        catch(Exception $e){
          echo '<span style="color:red;">Błąd serwera!</span>';
        }
      }

      // Jeśli walidacja się nie powiedzie, zapisz wartości w sesji
      if($wszystko_OK==false){
        $_SESSION['userType'] = $userType;
        header("Location: rejestracja.php");
        exit();
      }
    }
  }
}
?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8"> 
  <style>
    .hidden {
      display: none;
    }
    .error{
      color: red;
      margin-top: 10px;
      margin-bottom: 10px;
    }
  </style>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'pasek.php'; ?>
  <main>
  <div class="wrapper-reg">
  <div class="container-reg">
    <div class="col-left">
      <div class="login-text-reg">
        <h2>Work<br>For<br>Students</h2><br>
        
        <p>
         Zacznij pracę już dziś!
        </p>
      </div>
    </div>
    <div class="col-right">
      <div class="login-form-reg"> 
        <h2>Zarejestruj się</h2>
        <form method="POST">
          <div class = "reg-type">
              <input type="radio" name="userType" value="employee" id="employeeRadio" <?php if(isset($_SESSION['userType']) && $_SESSION['userType'] === 'employee') echo 'checked';?> checked>
              <label for="employeeRadio">Pracownik</label>

              <input type="radio" name="userType" value="employer" id="employerRadio" <?php if(isset($_SESSION['userType']) && $_SESSION['userType'] === 'employer') echo 'checked'; ?>>
              <label for="employerRadio">Pracodawca</label>
          </div>
   

          <div id="employeeFields" <?php if(isset($_SESSION['userType']) && $_SESSION['userType'] === 'employee') echo 'style="display: block;"'; ?>>
                  <label type="user">Login:</label>
                  <input type="text" name="user" id="login" value="<?php 
                  if(isset($_SESSION['formularz_user'])){
                    echo $_SESSION['formularz_user'];
                    unset($_SESSION['formularz_user']);
                  } 
                  ?>" id="user">
                  <?php
                    if(isset($_SESSION['e_user'])){
                      echo '<div class="error">'.$_SESSION['e_user'].'</div>';
                      unset($_SESSION['e_user']);
                    }
                  ?><br>

                  <label for="haslo">Hasło:</label>
                  <input type="password" name="haslo" value="<?php 
                  if(isset($_SESSION['formularz_haslo'])){
                    echo $_SESSION['formularz_haslo'];
                    unset($_SESSION['formularz_haslo']);
                  } 
                  ?>" id="haslo">
                  <?php
                    if(isset($_SESSION['e_haslo'])){
                      echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
                      unset($_SESSION['e_haslo']);
                    }
                  ?><br>

                  <label for="imie">Imię:</label>
                  <input type="text" name="imie" value="<?php 
                  if(isset($_SESSION['formularz_imie'])){
                    echo $_SESSION['formularz_imie'];
                    unset($_SESSION['formularz_imie']);
                  } 
                  ?>" id="imie">
                  <?php
                    if(isset($_SESSION['e_imie'])){
                      echo '<div class="error">'.$_SESSION['e_imie'].'</div>';
                      unset($_SESSION['e_imie']);
                    }
                  ?><br>

                  <label for="nazwisko">Nazwisko:</label>
                  <input type="text" name="nazwisko" value="<?php 
                  if(isset($_SESSION['formularz_nazwisko'])){
                    echo $_SESSION['formularz_nazwisko'];
                    unset($_SESSION['formularz_nazwisko']);
                  } 
                  ?>" id="nazwisko">
                  <?php
                    if(isset($_SESSION['e_nazwisko'])){
                      echo '<div class="error">'.$_SESSION['e_nazwisko'].'</div>';
                      unset($_SESSION['e_nazwisko']);
                    }
                  ?><br>

                  <label for="email">Email:</label>
                  <input type="email" name="email" value="<?php 
                  if(isset($_SESSION['formularz_email'])){
                    echo $_SESSION['formularz_email'];
                    unset($_SESSION['formularz_email']);
                  } 
                  ?>" id="email">
                  <?php
                    if(isset($_SESSION['e_email'])){
                      echo '<div class="error">'.$_SESSION['e_email'].'</div>';
                      unset($_SESSION['e_email']);
                    }
                  ?><br>

                  <label for="nrtel">Nr tel:</label>
                  <input type="tel" name="nrtel" value="<?php 
                  if(isset($_SESSION['formularz_nrtel'])){
                    echo $_SESSION['formularz_nrtel'];
                    unset($_SESSION['formularz_nrtel']);
                  } 
                  ?>" id="nrtel">
                  <?php
                    if(isset($_SESSION['e_nrtel'])){
                      echo '<div class="error">'.$_SESSION['e_nrtel'].'</div>';
                      unset($_SESSION['e_nrtel']);
                    }
                  ?><br>
                  <div class = "reg-button">
                  <label for="regulamin">Regulamin</label>
                  <input type="checkbox" name="regulamin" id="regulamin" <?php 
                    if(isset($_SESSION['formularz_regulamin'])){
                      echo "checked";
                      unset($_SESSION['formularz_regulamin']);
                    }
                  ?>></div>
                  <?php
                    if(isset($_SESSION['e_regulamin'])){
                      echo '<div class="error">'.$_SESSION['e_regulamin'].'</div>';
                      unset($_SESSION['e_regulamin']);
                    }
                  ?>
          </div>
          <div id="employerFields" <?php if(isset($_SESSION['userType']) && $_SESSION['userType'] === 'employer') echo 'style="display: block;"'; ?>>
                  <label for="login">Login:</label>
                  <input type="text" name="login" id="login" value="<?php 
                  if(isset($_SESSION['formularz_login'])){
                    echo $_SESSION['formularz_login'];
                    unset($_SESSION['formularz_login']);
                  } 
                  ?>">
                  <?php
                    if(isset($_SESSION['e_login'])){
                      echo '<div class="error">'.$_SESSION['e_login'].'</div>';
                      unset($_SESSION['e_login']);
                    }
                  ?><br>           

                  <label for="haslo">Hasło:</label>
                  <input type="password" name="haslo_pracodawca" id="haslo_pracodawca" value="<?php 
                  if(isset($_SESSION['formularz_haslo_pracodawca'])){
                    echo $_SESSION['formularz_haslo_pracodawca'];
                    unset($_SESSION['formularz_haslo_pracodawca']);
                  } 
                  ?>">
                  <?php
                    if(isset($_SESSION['e_haslo_pracodawca'])){
                      echo '<div class="error">'.$_SESSION['e_haslo_pracodawca'].'</div>';
                      unset($_SESSION['e_haslo_pracodawca']);
                    }
                  ?><br>            

                  <label for="imie">Imię:</label>
                  <input type="text" name="imie_pracodawca" id="imie_pracodawca" value="<?php 
                  if(isset($_SESSION['formularz_imie_pracodawca'])){
                    echo $_SESSION['formularz_imie_pracodawca'];
                    unset($_SESSION['formularz_imie_pracodawca']);
                  } 
                  ?>">
                  <?php
                    if(isset($_SESSION['e_imie_pracodawca'])){
                      echo '<div class="error">'.$_SESSION['e_imie_pracodawca'].'</div>';
                      unset($_SESSION['e_imie_pracodawca']);
                    }
                  ?><br>           

                  <label for="nazwisko">Nazwisko:</label>
                  <input type="text" name="nazwisko_pracodawca" id="nazwisko_pracodawca" value="<?php 
                  if(isset($_SESSION['formularz_nazwisko_pracodawca'])){
                    echo $_SESSION['formularz_nazwisko_pracodawca'];
                    unset($_SESSION['formularz_nazwisko_pracodawca']);
                  } 
                  ?>">
                  <?php
                    if(isset($_SESSION['e_nazwisko_pracodawca'])){
                      echo '<div class="error">'.$_SESSION['e_nazwisko_pracodawca'].'</div>';
                      unset($_SESSION['e_nazwisko_pracodawca']);
                    }
                  ?><br>            

                  <label for="email">Email:</label>
                  <input type="email" name="email_pracodawca" id="email_pracodawca" value="<?php 
                  if(isset($_SESSION['formularz_email_pracodawca'])){
                    echo $_SESSION['formularz_email_pracodawca'];
                    unset($_SESSION['formularz_email_pracodawca']);
                  } 
                  ?>">
                  <?php
                    if(isset($_SESSION['e_email_pracodawca'])){
                      echo '<div class="error">'.$_SESSION['e_email_pracodawca'].'</div>';
                      unset($_SESSION['e_email_pracodawca']);
                    }
                  ?><br>            

                  <label for="nrtel">Nr tel:</label>
                  <input type="tel" name="nrtel_pracodawca" id="nrtel_pracodawca" value="<?php 
                  if(isset($_SESSION['formularz_nrtel_pracodawca'])){
                    echo $_SESSION['formularz_nrtel_pracodawca'];
                    unset($_SESSION['formularz_nrtel_pracodawca']);
                  } 
                  ?>">
                  <?php
                    if(isset($_SESSION['e_nrtel_pracodawca'])){
                      echo '<div class="error">'.$_SESSION['e_nrtel_pracodawca'].'</div>';
                      unset($_SESSION['e_nrtel_pracodawca']);
                    }
                  ?><br>            

                  <label for="NIP">NIP:</label>
                  <input type="text" name="NIP" id="NIP" value="<?php 
                  if(isset($_SESSION['formularz_NIP'])){
                    echo $_SESSION['formularz_NIP'];
                    unset($_SESSION['formularz_NIP']);
                  } 
                  ?>">
                  <?php
                    if(isset($_SESSION['e_NIP'])){
                      echo '<div class="error">'.$_SESSION['e_NIP'].'</div>';
                      unset($_SESSION['e_NIP']);
                    }
                  ?><br>

                  <label for="REGON">REGON:</label>
                  <input type="text" name="REGON" id="REGON" value="<?php 
                  if(isset($_SESSION['formularz_REGON'])){
                    echo $_SESSION['formularz_REGON'];
                    unset($_SESSION['formularz_REGON']);
                  } 
                  ?>">
                  <?php
                    if(isset($_SESSION['e_REGON'])){
                      echo '<div class="error">'.$_SESSION['e_REGON'].'</div>';
                      unset($_SESSION['e_REGON']);
                    }
                  ?><br>

                  <label for="adres">Adres:</label>
                  <input type="text" name="adres" id="adres" value="<?php 
                  if(isset($_SESSION['formularz_adres'])){
                    echo $_SESSION['formularz_adres'];
                    unset($_SESSION['formularz_adres']);
                  } 
                  ?>">
                  <?php
                    if(isset($_SESSION['e_adres'])){
                      echo '<div class="error">'.$_SESSION['e_adres'].'</div>';
                      unset($_SESSION['e_adres']);
                    }
                  ?><br>

                  <label for="nazwa_firmy">Nazwa firmy:</label>
                  <input type="text" name="nazwa_firmy" id="nazwa_firmy" value="<?php 
                  if(isset($_SESSION['formularz_nazwa_firmy'])){
                    echo $_SESSION['formularz_nazwa_firmy'];
                    unset($_SESSION['formularz_nazwa_firmy']);
                  } 
                  ?>"><br>
                  <div class = "reg-button">
                  <label for="regulamin">Regulamin</label>
                  <input type="checkbox" name="regulamin_pracodawca" id="regulamin_pracodawca" <?php 
                    if(isset($_SESSION['formularz_regulamin_pracodawca'])){
                      echo "checked";
                      unset($_SESSION['formularz_regulamin_pracodawca']);
                    }
                  ?>></div>
                  <?php
                    if(isset($_SESSION['e_regulamin_pracodawca'])){
                      echo '<div class="error">'.$_SESSION['e_regulamin_pracodawca'].'</div>';
                      unset($_SESSION['e_regulamin_pracodawca']);
                    }
                  ?>
          </div>

          <br><br><input type="submit" value="Zarejestruj">
        </form>
       
        </div>
    </div>
  </div>
</div>

  <script>
    const employeeRadio = document.getElementById("employeeRadio");
    const employerRadio = document.getElementById("employerRadio");
    const employeeFields = document.getElementById("employeeFields");
    const employerFields = document.getElementById("employerFields");

    function showEmployeeFields() {
      employeeFields.style.display = "block";
      employerFields.style.display = "none";
    }

    function showEmployerFields() {
      employeeFields.style.display = "none";
      employerFields.style.display = "block";
    }

    if (employeeRadio.checked) {
      showEmployeeFields();
    } else if (employerRadio.checked) {
      showEmployerFields();
    }

    employeeRadio.addEventListener("click", showEmployeeFields);
    employerRadio.addEventListener("click", showEmployerFields);
  </script>
  </main>
  <footer>
      <p>w4s.com &copy; 2023</p>
  </footer>



</html>