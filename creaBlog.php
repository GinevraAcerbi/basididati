<?php
include "./common/header.php";
if(!isset($_SESSION["sess_user"])){
    header("location: index.php");
}

if (isset($_POST["submit"])) {
    query_insert_types("blog", ["id_cat_b"=>$_POST["id_cat_b"], "descrzione_b"=>$_POST["descrizioneb"], "titolo_b"=>$_POST["titolob"], "id_utente_b"=>$_SESSION["sess_user"]], ["int", "string", "string", "int"]);
    
    $lastIdQ="SELECT TOP 1 id_blog FROM blog ORDER BY id_blog DESC;";
    $lastIdR=MySQLi_query($connection, $lastIdQ);
    $lastId=-1;
    while($res1=mysqli_fetch_array($lastIdR))
        $lastId = $res1["id_blog"];

    $i=1;
    while(isset($_POST["id_utente_fr_"+$i])){
        $coautoreId = query_get("utente", ["id_utente"], ["email"=>$_POST["id_utente_fr_"+$i]])[0]["id_utente"];
        query_insert_int("coautore", ["id_utente_fr"=>$coautoreId, "id_blog_fr"=>$lastId]);
        $i++;
    }
    //AGGIUNGERE IMMAGINI
    
    //header("refresh:1; url=index.php");
}
?>
<div class="container">
    <form method="POST">
        <div>
            <label for="titolob">Inserisci il titolo</label>
            <input type="text" name="titolob" id="titolob" required>
        </div>
        <div>
            <label for="descrizioneb">Inserisci la descrizione</label>
            <input type="text" name="descrizioneb" id="descrizioneb" required>
        </div>
        <div>
            <label for="id_cat_b">Scegli la categoria</label>
            <?php
            $categorie=query_get("categoria",["id_cat", "descrcat"], []);
            ?>
            <select name="id_cat_b" id="id_cat_b" required>
                <?php
                foreach ($categorie as $cat) 
                    echo "<option value='".$cat["id_cat"]."'>".$cat["descrcat"]."</option>";
                ?>
            </select>
        </div>
        <div>
            <label for="id_utente_fr_0">Seleziona un coautore</label>
            <?php
            $coautori=query_get("utente",["email"], []);
            ?>
            <select name="id_utente_fr_0" id="id_utente_fr_0">
                <?php
                foreach ($coautori as $ca) 
                    echo "<option value='".$ca["email"]."'>".$ca["email"]."</option>";
                ?>
            </select>
        </div>
        <div id="appendCoautori">
            <label>Aggiungi un coautore</label>
            <i id="altriCoautori" class="fa-solid fa-circle-plus"></i>
        </div>
        <div>
            <label for="id_blog_imm">Seleziona un immagine</label>
            <input type="file" name="id_blog_imm" id="id_blog_imm">
        </div>
        <input name="submit" type="submit" class="btn btn-primary" value="Aggiungi Blog"> 
    </form>
</div>
<script>
    $(document).ready(function(){
        var coautoriCounter=0;
        $("#altriCoautori").click(function(){
            $.ajax({
                type: "POST",
                url: "gestioneCoautori.php",
                success: function(data) {
                    var coautori = jQuery.parseJSON(data);
                    coautoriCounter++;
                    $("#appendCoautori").append('<div> <label for="id_utente_fr_'+coautoriCounter+'">Seleziona un coautore</label><select name="id_utente_fr_'+coautoriCounter+'" id="id_utente_fr_'+coautoriCounter+'">');
                    coautori.forEach(function(coautore){
                        var email = coautore["email"];
                        $("#id_utente_fr_"+coautoriCounter).append('<option value='+email+'>'+email+'</option>');
                    });
                    $("#appendCoautori").append('</select></div>');
                }
            });
        });
    });
</script>