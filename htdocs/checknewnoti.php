<?php 
session_start();
require 'db.php';
if(isset($_SESSION['un'])){

$dbc = mysqli_connect($GLOBALS['host'],$GLOBALS['user'],$GLOBALS['pass'],$GLOBALS['db']);

$query = "SELECT nid from notifications WHERE of = '".$_SESSION['un']."' and readd = 0";

$result = mysqli_query($dbc,$query);

$nnoti = mysqli_num_rows($result);

$nnoti = array("nnoti"=>$nnoti);

mysqli_close($dbc);

}

else{
$nnoti = array("nnoti"=>0);

}

	echo json_encode($nnoti);

 ?>