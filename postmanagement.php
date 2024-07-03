<?php
if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
    include "utils/sql.php";
    if(!isset($_SESSION["sess_user"]))
        echo("login.php");
    else{
        $user_id = $_SESSION["sess_user"];
        if(isset($_POST["like"]) && isset($_POST["id_post_f"])){
            $likeCounter=query_get("utente", ["numlike"], ["id_utente"=>$user_id]);
            if(($likeCounter[0]["numlike"] && $likeCounter[0]["numlike"]>0)|| !$likeCounter[0]["numlike"]){
                query_insert_int("feedback", ["id_post_f"=>$_POST["id_post_f"], "id_utente_f"=>$user_id]);
                if($likeCounter)
                    query_update_int("utente", ["numlike"=>$likeCounter[0]["numlike"]-1], ["id_utente"=>$user_id]);
                $caller="http://localhost/basididati/post.php?id_post=".$_POST["id_post_f"];
                echo($caller);
            }
        }
        else if(isset($_POST["commento"]) && isset($_POST["id_post_c"])){
            $commCounter=query_get("utente", ["numcomm"], ["id_utente"=>$user_id]);
            if(($commCounter[0]["numcomm"] && $commCounter[0]["numcomm"]>0)|| !$commCounter[0]["numcomm"]){
                query_insert_types("commento", ["id_post_c"=>$_POST["id_post_c"], "id_utente_c"=>$user_id, "testoc"=>$_POST["commento"], "datac"=>date("y-m-d")], ["int", "int", "string", "string"]);
                if($commCounter)
                    query_update_int("utente", ["numcomm"=>$commCounter[0]["numcomm"]-1], ["id_utente"=>$user_id]);
                $caller="http://localhost/basididati/post.php?id_post=".$_POST["id_post_c"];
                echo($caller);
            }
        }
    }
}
?>

