<?php
if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
include "utils/sql.php";
if(isset($_POST["search"])){
    $result=array();
    $searchWord=$_POST["search"]; //parola chiave di ricerca
    //query per cercare il titolo nel blog
    $titoloBlogQuery="SELECT titolob FROM blog WHERE titolob LIKE '%$searchWord%' LIMIT 2;";
    $titoloBlogResult=MySQLi_query($connection, $titoloBlogQuery);
    while($res1=mysqli_fetch_array($titoloBlogResult))
        $result[] = array("name"=>"titolob", "value"=>$res1["titolob"]);
    //query per cercare la descrizione nel blog
    $descrizioneBlogQuery="SELECT descrizioneb FROM blog WHERE descrizioneb LIKE '%$searchWord%' LIMIT 2;";
    $descrizioneBlogResult=mysqli_query($connection, $descrizioneBlogQuery);
    while($res2=mysqli_fetch_array($descrizioneBlogResult))
        $result[] = array("name"=>"descrizioneb", "value"=>$res2["descrizioneb"]);
    //query per cercare la categoria nel blog
    $categoriaBlogQuery="SELECT descrcat FROM categoria c, blog b WHERE c.descrcat LIKE '%$searchWord%' AND c.id_cat=b.id_cat_b LIMIT 2;";
    $categoriaBlogResult=mysqli_query($connection, $categoriaBlogQuery);
    while($res3=mysqli_fetch_array($categoriaBlogResult))
        $result[] = array("name"=>"descrcat", "value"=>$res3["descrcat"]);
    //query per cercare l'email dell'utente associato al blog
    $utenteBlogQuery="SELECT email FROM utente u, blog b WHERE u.email LIKE '%$searchWord%' AND u.id_utente=b.id_utente_b LIMIT 2;";
    $utenteBlogResult=mysqli_query($connection, $utenteBlogQuery);
    while($res4=mysqli_fetch_array($utenteBlogResult))
        $result[] = array("name"=>"email", "value"=>$res4["email"]);

    //stampa dei risultati
    print_r(json_encode($result));
}
}
?>