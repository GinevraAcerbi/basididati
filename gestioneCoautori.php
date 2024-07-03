<?php
if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
  include "utils/sql.php";
  if (!isset($_SESSION["sess_user"]))
    echo ("login.php");
  else {
    $result=array();
    $queryCoautori="SELECT distinct email FROM utente;";
    $results=MySQLi_query($connection, $queryCoautori);
    while($res1=mysqli_fetch_array($results))
        $result[] = array("email"=>$res1["email"]);

    print_r(json_encode($result));
  }
}
