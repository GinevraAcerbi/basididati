<?php
if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
include "utils/sql.php";
if(isset($_POST["titolob"])){
    $result=array();
    $searchWord=$_POST["titolob"];
    $titoloBlogQuery="SELECT id_blog FROM blog WHERE titolob = '$searchWord' LIMIT 1;"; //limite di un risultato
    $titoloBlogResult=MySQLi_query($connection, $titoloBlogQuery);
    while($res1=mysqli_fetch_array($titoloBlogResult))
        $result[] = $res1["id_blog"];
    if(count($result)==1)
        echo $result[0];
}else if(isset($_POST["descrizioneb"])){
    $result=array();
    $searchWord=$_POST["descrizioneb"];
    $descrizioneBlogQuery="SELECT id_blog FROM blog WHERE descrizioneb = '$searchWord' LIMIT 1;";
    $descrizioneBlogResult=MySQLi_query($connection, $descrizioneBlogQuery);
    while($res1=mysqli_fetch_array($descrizioneBlogResult))
        $result[] = $res1["id_blog"];
    if(count($result)==1)
        echo $result[0];
}else if(isset($_POST["descrcat"])){
    $idCat=-1;
    $searchWord=$_POST["descrcat"];
    $categoriaQuery="SELECT id_cat FROM categoria WHERE descrcat = '$searchWord' LIMIT 1;";
    $categoriaResult=MySQLi_query($connection, $categoriaQuery);
    while($res1=mysqli_fetch_array($categoriaResult))
        $idCat = $res1["id_cat"];
    if($idCat!=-1)
        echo $idCat;
}
}
?>

