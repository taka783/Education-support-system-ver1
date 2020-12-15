<?php
require "level.php";

$con = mysqli_connect("localhost", "g031o031", "xE8ptBCY");
if (!$con) {
exit('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
}
mysqli_set_charset($con, 'utf8mb4');
mysqli_select_db($con, "g031o031");


?>



