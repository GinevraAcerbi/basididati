<?php
include "utils/sql.php";
include "utils/regExp.php";
?>
<!DOCTYPE html>
<html lang="it">

<?php
if (isset($_POST["submit"])) {
  if (!emailIsValid($_POST["email"])) {
    $errorMessageEmail = "<div class='alert alert-danger' role='alert'> inserire una email valida </div>";
  }
  if (!passwordIsValid($_POST["password"])) {
    $errorMessagePassword = "<div class='alert alert-danger' role='alert'> inserire una password valida </div>";
  }
  if (!isset($errorMessageEmail) && !isset($errorMessagePassword)) {
    $user = query_get("utente", ["id_utente"], ["email" => $_POST["email"], "pwd" => md5($_POST["password"])]);
    if (!$user)
      $errorMessageLogin = "<div class='alert alert-danger' role='alert'> login non valido </div>";
    else {
      $_SESSION['sess_user'] = $user;
      header("refresh:1; url=index.php");
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
        <label for="exampleInputEmail1">Indirizzo Email</label>
        <input type="email" name="email" placeholder="user1@gmail.com" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input type="password" name="password" class="form-control" id="exampleInputPassword1">
      </div>
      <a href="signUp.php">Registrati</a><br>
      <input name="submit" type="submit" class="btn btn-primary" value="login">
      <?php
      if (isset($errorMessageEmail)) echo $errorMessageEmail;
      if (isset($errorMessagePassword)) echo $errorMessagePassword;
      if (isset($errorMessageLogin)) echo $errorMessageLogin;
      ?>
    </form>
  </div>
  <script>
     $(document).ready(function(){
        $("#backButton").click( function(){
          window.history.back();
        });
    });
  </script>
  <?php
  include "common/footer.php";
  ?>