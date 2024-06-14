<?php
session_start();
unset($_SESSION["sess_user"]);
session_destroy();
header("refresh:1; url=index.php");
?>