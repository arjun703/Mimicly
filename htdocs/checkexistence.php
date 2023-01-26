<?php 
require 'db.php';
$un = htmlspecialchars(trim($_GET['un']));
$dbc= mysqli_connect($host,$user,$pass,$db);
$un = mysqli_real_escape_string($dbc,$un);
$query = "SELECT un from ud where un = '".$un."' ";
$result = mysqli_query($dbc,$query);
mysqli_close($dbc);
if(mysqli_num_rows($result)==1){
echo '1';
}

 ?>
