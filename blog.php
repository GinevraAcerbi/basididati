<?php
  if(empty($_GET))
    header("location:error.php");
  include "./common/header.php";
?>
<link rel="stylesheet" type="text/css" href="style/blog.css" />
<?php
$blog=query_get("blog", [], ["id_blog" => $_GET["id_blog"]]);
?>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

<div class="header">
    <h1><?php echo($blog[0]["titolob"]) ?></h1>
    <h3><p><?php echo($blog[0]["descrizioneb"]) ?></p></h3>
</div>

<div class="row">
  <div class="leftcolumn">
    <div class="card">
    <?php
    $post_correlati_id=query_get("post", ["id_post"],["id_blog_p" => $_GET["id_blog"]]);
    if(count($post_correlati_id)>0){
        $i=0;
        for($i=0; $i<count($post_correlati_id); $i++){
            $post_correlati=query_get("post", [],["id_post" => intval($post_correlati_id[$i]["id_post"])]); 
            ?><h1><?php echo($post_correlati[0]["titolop"]) ?></h1>
            <p><h6>argomento: <?php echo($post_correlati[0]["testop"]) ?></h6></p>
            <p><h6>data e ora di pubblicazione: <?php echo($post_correlati[0]["data"] )." ".($post_correlati[0]["ora"]) ?></h6></p>
            <p>
                <h6>blog di appartenenza: 
                <?php
                $titoloBlog=query_get("blog", ["titolob"],["id_blog" => $post_correlati[0]["id_blog_p"]]);
                echo($titoloBlog[0]["titolob"]); 
                ?>
                </h6>
            </p>
            <p>
                <h6>creatore: 
                <?php
                $username=query_get("utente", ["email"],["id_utente" => $post_correlati[0]["id_utente_p"]]);
                echo($username[0]["email"]); 
                ?>
                </h6>
            </p>

            <?php 
                $img = query_get("immagine", ["percorso"], ["id_post_imm" => $post_correlati[0]["id_post"]]);
                if(!$img)
                    $img[0]["percorso"]="";
            ?>
            <img src="<?php echo($img[0]["percorso"]); ?>" alt="immagine" height:200px>
        <?php
        }
    }
    ?>
    
  <div class="rightcolumn">
    <div class="card">
      <h2>I creatori</h2>
      <p>
        <?php
        $username=query_get("utente", ["email"],["id_utente" => $blog[0]["id_utente_b"]]);
        echo("Autore: ".$username[0]["email"]); 
        ?>
    </p>
    <p>
        <?php
        $coautori_id=query_get("coautore", ["id_utente_fr"],["id_blog_fr" => $_GET["id_blog"]]);
        if(count($coautori_id)>0){
            $coautori=array();
            $i=0;
            for($i=0; $i<count($coautori_id); $i++){
                $coautori[$i]=query_get("utente", ["email"],["id_utente" => intval($coautori_id[$i]["id_utente_fr"])])[0]["email"];
                echo("Coautore: ".$coautori[$i]);
            }
        }
        ?>
        <h4>la categoria</h4>
        <p>
            <?php
            $categoria=query_get("categoria", ["descrcat"],["id_cat" => $blog[0]["id_cat_b"]]);
            echo($categoria[0]["descrcat"]); 
            ?>
        </p>
    </p>
    </div>
</div>
<?php
  include "./common/footer.php";
?>