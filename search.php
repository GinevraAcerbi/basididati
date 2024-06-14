<?php
//include "utils/sql.php";
if(isset($_POST["search"])){
    $result=array();
    $searchWord=mysqli_real_escape_string($connection, $_POST["search"]);
    $titoloBlogQuery="SELECT titolob FROM blog WHERE titolob LIKE '%$searchWord%' LIMIT 2;";
    $titoloBlogResult=MySQLi_query($connection, $titoloBlogQuery);
    while($res1=MySQLi_fetch_array($titoloBlogResult)){
        array_push($result, array("id"=>$res1["titolob"]));
    }
    echo("<script>console.log($result);</script>");
    $descrizioneBlogQuery="SELECT descrizioneb FROM blog WHERE descrizioneb LIKE '%$searchWord%' LIMIT 2;";
    $descrizioneBlogResult=MySQLi_query($connection, $descrizioneBlogQuery);
    while($res2=MySQLi_fetch_array($descrizioneBlogResult)){
        array_push($result, array("id"=>$res2["descrizioneb"]));
    }
    $categoriaBlogQuery="SELECT descrcat FROM categoria c, blog b WHERE c.descrcat LIKE '%$searchWord%' AND c.id_cat=b.id_cat_b LIMIT 2;";
    $categoriaBlogResult=MySQLi_query($connection, $categoriaBlogQuery);
    while($res3=MySQLi_fetch_array($categoriaBlogResult)){
        array_push($result, array("id"=>$res3["descrcat"]));
    }
    $utenteBlogQuery="SELECT nome FROM utente u, blog b WHERE u.nome LIKE '%$searchWord%' AND u.id_utente=b.id_utente_b LIMIT 2;";
    $utenteBlogResult=MySQLi_query($connection, $utenteBlogQuery);
    while($res4=MySQLi_fetch_array($utenteBlogResult)){
        array_push($result, array("id"=>$res4["nome"]));
    }
    $json= json_encode($result);
    echo $json;
}
?>