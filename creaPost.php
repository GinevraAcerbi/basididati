<?php
if (empty($_GET))
  header("location:error.php");
include "./common/header.php";
?>
<link rel="stylesheet" type="text/css" href="style/blog.css" />
<?php
$post = query_get("post", [], ["id_post" => $_GET["id_post"]]);
$stile = query_get("stile", [], ["id_style" => $post[0]["id_style_p"]]);
?>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<?php
if (empty($stile)) echo ("<div class='row'>");
else echo ("<div class='row' style='font-family: " . $stile[0]["font"] . "; font-size: " . $stile[0]["dimensione"] . "'>");
?>
<div class="leftcolumn">
  <div class="card">
    <div class="cardpost"> <h1><?php echo ($post[0]["titolop"]) ?></h1>
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
      <p>
      <h6>Argomento: <?php echo ($post[0]["testop"]) ?></h6>
      </p>

      <p style="padding-top:5%">
        <?php
        if (isset($_SESSION["sess_user"])) {
          $nLikeUtente = query_get_count("feedback", ["id_post_f" => $post[0]["id_post"], "id_utente_f" => $_SESSION["sess_user"]]);
          if ($nLikeUtente >= 1)
            echo ('<i class="fa fa-thumbs-up fa-2xl" aria-hidden="true" disabled=true style="color:blue"></i>');
          else
            echo ('<i class="fa fa-thumbs-up fa-2xl" aria-hidden="true"></i>');
        } else
          echo ('<i class="fa fa-thumbs-up fa-2xl" aria-hidden="true"></i>');
        ?>
        <?php
        $nLike = query_get_count("feedback", ["id_post_f" => $post[0]["id_post"]]);
        ?>
        <span><?php echo ($nLike); ?></span>
      </p>

      <div class="form-group">
        <label for="exampleFormControlTextarea1">Commento</label>
        <textarea class="form-control" id="txtCommento" rows="3"></textarea>
        <?php
          if (isset($_SESSION["sess_user"])) {
            $nCommUtente = query_get("utente", ["numcomm"], [ "id_utente" => $_SESSION["sess_user"]]);
            if ((isset($nCommUtente[0]["numcomm"]) && $nCommUtente[0]["numcomm"] <= 0))
              echo ('<button id="btncommento" disabled=true type="button" class="btn btn-outline-dark">Posta</button>');
            else
              echo ('<button id="btncommento" type="button" class="btn btn-outline-dark">Posta</button>');
          } else
            echo ('<button id="btncommento" disabled=true type="button" class="btn btn-outline-dark">Posta</button>');
        ?>
      </div>
      <?php
      $commenti=query_get("commento", [], ["id_post_c"=>$post[0]["id_post"]]);
      foreach ($commenti as $commento) {
        echo('<div class="card" style="width: 18rem;">');
          echo('<div class="card-body">');
            echo('<h5 class="card-title">');
              $nomeUtente=query_get("utente", ["email"], ["id_utente"=>$commento["id_utente_c"]]);
              echo ($nomeUtente[0]["email"]);
            echo('</h5>');
            echo('<p class="card-text">');
            echo ($commento["testoc"]);
            echo('</p>');
            echo('<span class="card-text">');
            echo ($commento["datac"]);
            echo('</span>');
          echo('</div>');
        echo('</div>');
      } ?>

    </div>
  </div>
</div>
<script>
  $(document).ready(function() {
    $(".fa-thumbs-up").click(function() {
      if ($(".fa-thumbs-up").attr("disabled") != "disabled")
        $.ajax({
          type: "POST",
          url: "postmanagement.php",
          data: {
            "id_post_f": $(location).attr('href').split('id_post=')[1],
            "like":1
          },
          success: function(data) {
            window.location.href = data;
          }
        });
    });


    $("#btncommento").click(function() {
      if ($("#btncommento").attr("disabled") != "disabled")
        $.ajax({
          type: "POST",
          url: "postmanagement.php",
          data: {
            "id_post_c": $(location).attr('href').split('id_post=')[1],
            "commento": $("#txtCommento").val()
          },
          success: function(data) {
            window.location.href = data;
          }
        });
    });
  });
</script>

<?php
include "./common/footer.php";
?>