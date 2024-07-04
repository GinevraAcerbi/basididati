<?php
include "utils/sql.php";
include "utils/regExp.php";
?>
<!DOCTYPE html>
<html lang="it">

<?php
if (isset($_POST["submit"])) {
  //validazione dei campi attraverso le funzioni di regExp.php
  if (!emailIsValid($_POST["email"])) {
    $errorMessageEmail = "<div class='alert alert-danger' role='alert'> inserire una email valida </div>";
  }
  if (!passwordIsValid($_POST["password"])) {
    $errorMessagePassword = "<div class='alert alert-danger' role='alert'> inserire una password valida (almeno 5 caratteri di cui almeno una maiuscola, una minuscola e un numero) </div>";
  }
  if (!passwordIsValid($_POST["password2"])) {
    $errorMessagePasswordConfirm = "<div class='alert alert-danger' role='alert'> inserire una password di conferma valida (almeno 5 caratteri di cui almeno una maiuscola, una minuscola e un numero)</div>";
  }
  if (isset($_POST["subscribe"]) && !numeroCartaIsValid($_POST["cardNumber"])) {
    $errorMessageCardNumber = "<div class='alert alert-danger' role='alert'> inserire un numero di carta valido </div>";
  }
  if ($_POST["nome"] === "") {
    $errorMessageNome = "<div class='alert alert-danger' role='alert'> inserire un nome </div>";
  }
  //verifica che le due password siano uguali
  if (!isset($errorMessageEmail) && !isset($errorMessagePassword) && !isset($errorMessagePasswordConfirm) && !isset($errorMessageCardNumber) && !isset($errorMessageNome)) {
    if ($_POST["password"] !== $_POST["password2"]) {
      $errorMessagePassword2 = "<div class='alert alert-danger' role='alert'> le password non sono uguali </div>";
    } else {
      //verifica che l'utente non sia già iscritto al sito
      $user = query_get("utente", ["id_utente"], ["email" => $_POST["email"]]);
      if (!$user) {
        //abbonamento premium
        if (isset($_POST["subscribe"])) {
          query_insert("utente", ["pwd" => md5($_POST["password"]), "email" => $_POST["email"], "numcarta" => $_POST["cardNumber"], "nome" => $_POST["nome"]]);
          //eseguo una query per recuperare i dettagli dell'utente appena inserito utilizzando l'email
          $insertedUser = query_get("utente", ["id_utente"], ["email" => $_POST["email"]]);
          if (!$insertedUser)
            $errorMessageSignUp = "<div class='alert alert-danger' role='alert'> Errore durante la registrazione </div>";
          else {
            $_SESSION['sess_user'] = $insertedUser;
            header("refresh:1; url=index.php");
          }
        } else {
          //inserimento dell'utente non premium
          query_insert("utente", ["pwd" => md5($_POST["password"]), "email" => $_POST["email"], "nome" => $_POST["nome"]]);
          $insertedUser = query_get("utente", ["id_utente"], ["email" => $_POST["email"]]);
          if (!$insertedUser)
            $errorMessageSignUp = "<div class='alert alert-danger' role='alert'> Errore durante la registrazione </div>";
          else {
            //set di dati iniziali per un nuovo utente
            query_update_int("utente", ["numcomm" => 2, "numlike" => 2, "numpost" => 2], ["id_utente" => intval($insertedUser[0]["id_utente"])]);
            $_SESSION['sess_user'] = $insertedUser;
            header("refresh:1; url=index.php");
          }
        }
      } else
        $errorMessageSignUp = "<div class='alert alert-danger' role='alert'> Email già registrata </div>";
    }
  }
}
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> LPW GinevraAcerbi </title>
  <link rel="stylesheet" type="text/css" href="style/index.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://kit.fontawesome.com/6911c927ab.js" crossorigin="anonymous"></script>
</head>

<body>
  <script>
    //visualizzazione della carta 
    $(document).ready(function() {
      $("#exampleInputCardNumber1").hide();
      $("#numeroCarta").hide();
      $("#exampleInputSubscribe1").change(function() {
        if ($(this).prop("checked")) {
          $("#exampleInputCardNumber1").show();//se vero mostra la carta
          $("#numeroCarta").show();
        } else {
          $("#exampleInputCardNumber1").hide();//se falso nasconde la carta 
          $("#numeroCarta").hide();
        }
      });
    });
  </script>
  <div class="container">
    <header class="border-bottom 1h-1 py-3">
      <div class="row flex-nowrap justify-content-between align-items-center fst-italic">
        <div class="col-4 text-center">
          <a class="blog-header-logo text-decoration-none" style="color:pink" href="index.php">
            <h1>TalkaboutAnything</h1>
          </a>
        </div>
      </div>
    </header>
    <i id="backButton" class="fa fa-arrow-left fa-2xl" aria-hidden="true" style="left:25%; position:relative; padding-top:5%; padding-bottom:5%; cursor:pointer;"></i>
    <form id="formLogin" method="post" class="card" style="padding:2%;">
      <div class="form-group">
        <label for="exampleInputEmail1">Nome</label>
        <input type="text" name="nome" class="form-control" id="exampleInputName1">
      </div>
      <div class="form-group">
        <label for="exampleInputEmail1">Indirizzo Email</label>
        <input type="email" name="email" placeholder="user1@gmail.com" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input type="password" name="password" class="form-control" id="exampleInputPassword1">
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">Conferma Password</label>
        <input type="password" name="password2" class="form-control" id="exampleInputPassword2">
      </div>
      <div class="form-group">
        <label for="premiumSub"> Abbonati a premium</label>
        <input type="checkbox" id="exampleInputSubscribe1" name="subscribe"><br>
        <label id="numeroCarta" for="premiumSub"> Numero Carta</label>
        <input type="text" name="cardNumber" class="form-control" id="exampleInputCardNumber1">
      </div>
      <input name="submit" type="submit" class="btn btn-primary" value="Registrati">
      <?php
      //visualizzazione dei messaggi di errore nella pagina web
      if (isset($errorMessageEmail)) echo $errorMessageEmail;
      if (isset($errorMessagePassword)) echo $errorMessagePassword;
      if (isset($errorMessagePasswordConfirm)) echo $errorMessagePasswordConfirm;
      if (isset($errorMessagePassword2)) echo $errorMessagePassword2;
      if (isset($errorMessageCardNumber)) echo $errorMessageCardNumber;
      if (isset($errorMessageNome)) echo $errorMessageNome;
      if (isset($errorMessageSignUp)) echo $errorMessageSignUp;
      ?>
    </form>
  </div>
  <script>
    $(document).ready(function() {
      $("#backButton").click(function() {
        window.history.back();
      });
    });
  </script>
  <?php
  include "common/footer.php";
  ?>