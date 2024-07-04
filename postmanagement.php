<?php
if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
    include "utils/sql.php";
    if(!isset($_SESSION["sess_user"]))
        echo("login.php"); //se l'utente non è identificato viene mandato al login
    else{
        //recuper id utente dalla sessione
        $user_id = $_SESSION["sess_user"];
        if(isset($_POST["like"]) && isset($_POST["id_post_f"])){
            //gestione del contatore dei like 
            $likeCounter=query_get("utente", ["numlike"], ["id_utente"=>$user_id]);
            //controlla se l'utente ha ancora dei like  
            if(($likeCounter[0]["numlike"] && $likeCounter[0]["numlike"]>0)|| !$likeCounter[0]["numlike"]){
                query_insert_int("feedback", ["id_post_f"=>$_POST["id_post_f"], "id_utente_f"=>$user_id]);
                if($likeCounter) //se l'utente ha già un like, il contatore si aggiorna decrementandolo
                    query_update_int("utente", ["numlike"=>$likeCounter[0]["numlike"]-1], ["id_utente"=>$user_id]);
                $caller="http://localhost/basididati/post.php?id_post=".$_POST["id_post_f"];
                echo($caller);
            }
        }
        else if(isset($_POST["commento"]) && isset($_POST["id_post_c"])){
            //gestione contatore dei commenti 
            $commCounter=query_get("utente", ["numcomm"], ["id_utente"=>$user_id]);
            //controlla se l'utente ha ancora commenti disponibili
            if(($commCounter[0]["numcomm"] && $commCounter[0]["numcomm"]>0)|| !$commCounter[0]["numcomm"]){
                query_insert_types("commento", ["id_post_c"=>$_POST["id_post_c"], "id_utente_c"=>$user_id, "testoc"=>$_POST["commento"], "datac"=>date("y-m-d")], ["int", "int", "string", "string"]);
                if($commCounter) //se l'utente ha già il commento, il contatore si aggiorna decrementandolo
                    query_update_int("utente", ["numcomm"=>$commCounter[0]["numcomm"]-1], ["id_utente"=>$user_id]);
                $caller="http://localhost/basididati/post.php?id_post=".$_POST["id_post_c"];
                echo($caller);
            }
        }
    }
}
?>

