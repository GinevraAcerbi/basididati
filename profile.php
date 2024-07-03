<?php
include "./common/header.php";
if(!isset($_SESSION["sess_user"])){
    header("location: index.php");
}
?>
<?php

$user=query_get_int("utente", [], ["id_utente" => intval($_SESSION["sess_user"])]);
?>
<link href="./style/profile.css" rel="stylesheet" type="text/css">

<div class="container emp-profile">
    <form method="post">
        <div class="row">
            <div class="col-md-10">
                <div class="profile-head">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true">About</a>
                        </ul>
                    </ul>
                </div>
            </div>
            <div class="col-md-2">
                <button class="btn btn-outline-danger" id="btnLogOut">Log Out</button>  
            </div>
        </div>
        <div class="row">
            <div class="col-md-8" style="left:25%; position:relative;">
                <div class="tab-content profile-tab" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Name</label>
                            </div>
                            <div class="col-md-6">
                                <p>
                                    <?php echo($user[0]["nome"]) ?>
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Email</label>
                            </div>
                            <div class="col-md-6">
                                <p><?php echo($user[0]["email"])?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Numero post disponibili</label>
                            </div>
                            <div class="col-md-6">
                                <p><?php echo($user[0]["numpost"])?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Numero commenti disponibili</label>
                            </div>
                            <div class="col-md-6">
                                <p><?php echo($user[0]["numcomm"])?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Numero like disponibili</label>
                            </div>
                            <div class="col-md-6">
                                <p><?php echo($user[0]["numlike"])?></p>
                            </div>
                        </div>
                    </div>   
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    $(document).ready(function(){
        $("#btnLogOut").click( function(){
            $.ajax({
                type: "POST",
                url: "logout.php",
                success: function(){
                    window.location.href = "index.php";
                }
            });
        });
    });
</script>
<?php
include "./common/footer.php";
?>