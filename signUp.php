<?php
  include "./common/header.php";
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
    <h1>Iscrizione</h1>
    
    <form id="formSignUp" action="controlloSignUp.php" method="post" id="signup" novalidate>
        <div>
            <label for="email">email</label>
            <input type="email" id="email" name="email">
        </div>
        
        <div>
            <label for="password">Password</label>
            <input type="password" id="password" name="password">
        </div>
        
        <button>Sign up</button>
    </form>
    <p>Signup successful.
       You can now <a href="login.php">log in</a>.</p>
</body>

<?php
  include "./common/footer.php";
?>