<?php 

session_start();

if(!isset($_COOKIE['remember'])){
setcookie('remember','0',time()+86400);
}


if(!isset($_SESSION['uid'])){

if($_COOKIE['remember']==1){

	if(isset($_COOKIE['uid'])&&$_COOKIE['password']){

$uid = $_COOKIE['uid'];
$password = $_COOKIE['password'];

require 'db.php';

$dbc = mysqli_connect($GLOBALS['host'],$GLOBALS['user'],$GLOBALS['pass'],$GLOBALS['db']) or die('Error conneting..');

$table = 'ud';

$query = "SELECT * from ".$table." where uid =  ".$uid." and password = '".sha1($password)."' ";

$result = mysqli_query($dbc,$query) or die('ERROR in table');

if(mysqli_num_rows($result)==1){
$row = mysqli_fetch_array($result);	
$_SESSION['uid'] = $uid;
$_SESSION['password'] = $password;
$_SESSION['fn'] = $row['fn'];
$_SESSION['ln'] = $row['ln'];
header('location: home.php');	
}

	}
}
else{


header('location: topcontent.php');	

}

}
else{

		header('location: home.php');	
}


 ?>