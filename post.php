<?php
  if(empty($_GET))
    header("location:error.php");
  include "./common/header.php";
?>
<?php
$post=query_get("post", [], ["id_post" => $_GET["id_post"]]);
?>
<h1><?php echo($post[0]["titolop"]) ?></h1>
<p><?php echo($post[0]["testop"]) ?></p>
<p><?php echo($post[0]["data"] )." ".($post[0]["ora"]) ?></p>
<p>
    <?php
    $titoloBlog=query_get("blog", ["titolob"],["id_blog" => $post[0]["id_blog_p"]]);
    echo($titoloBlog[0]["titolob"]); 
    ?>
</p>
<p>
    <?php
    $username=query_get("utente", ["email"],["id_utente" => $post[0]["id_utente_p"]]);
    echo($username[0]["email"]); 
    ?>
</p>
<?php 
    $img = query_get("immagine", ["percorso"], ["id_post_imm" => $_GET["id_post"]]);
    if(!$img)
        $img[0]["percorso"]="";
?>
<img src="<?php echo($img[0]["percorso"]); ?>" alt="immagine" width="50%" height="50%">

<?php
  include "./common/footer.php";
?>