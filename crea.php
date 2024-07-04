<?php
include "./common/header.php";
if(!isset($_SESSION["sess_user"])){
    header("location: index.php");
}
?>
<link rel="stylesheet" type="text/css" href="style/blog.css" />


<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<div class="card">
    <button class="btn btn-info" id="btnBlog" color="pink">Crea Blog</button>
    <br>
    <button class="btn btn-info" id="btnPost" color="pink">Crea Post</button>
</div>
<script>
    $(document).ready(function() {
        $("#btnBlog").click(function() {
            window.location.href = "creaBlog.php";
        });
        $("#btnPost").click(function() {
            window.location.href = "creaPost.php";
        });
    });
</script>

<?php
include "./common/footer.php";
?>