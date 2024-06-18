<?php
if (empty($_GET))
  header("location:error.php");
include "./common/header.php";
?>
<link rel="stylesheet" type="text/css" href="style/blog.css" />
<?php
$post = query_get("post", [], ["id_post" => $_GET["id_post"]]);
?>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

  <div class="row">
    <div class="leftcolumn">
      <div class="card">
        <h1><?php echo ($post[0]["titolop"]) ?></h1>
        <p>
        <h6>Argomento: <?php echo ($post[0]["testop"]) ?></h6>
        </p>
        <p>
        <h6>data e ora di pubblicazione: <?php echo ($post[0]["data"]) . " " . ($post[0]["ora"]) ?></h6>
        </p>
        <p>
        <h6>Blog di appartenenza:
          <?php
          $titoloBlog = query_get("blog", ["titolob"], ["id_blog" => $post[0]["id_blog_p"]]);
          echo ($titoloBlog[0]["titolob"]);
          ?>
        </h6>
        </p>
        <p>
        <h6>Creatore:
          <?php
          $username = query_get("utente", ["email"], ["id_utente" => $post[0]["id_utente_p"]]);
          echo ($username[0]["email"]);
          ?>
        </h6>
        </p>

        <?php
        $img = query_get("immagine", ["percorso"], ["id_post_imm" => $_GET["id_post"]]);
        if (!$img)
          $img[0]["percorso"] = "";
        ?>
        <img src="<?php echo ($img[0]["percorso"]); ?>" alt="immagine" width="50%" height="50%">
      </div>
    </div>
  </div>

  <?php
  include "./common/footer.php";
  ?>