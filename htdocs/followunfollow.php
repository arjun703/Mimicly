<?php 
session_start();
$un = trim($_GET['un']);
$task = trim($_GET['task']);
if(isset($_SESSION['un'])&&is_numeric($task)){

require 'db.php';

require 'functions.php';

$followed = getfui($un);

$dbc = mysqli_connect($GLOBALS['host'],$GLOBALS['user'],$GLOBALS['pass'],$GLOBALS['db']);


if($task==1){

if($followed==0){

$table = 'ud';

$query = "UPDATE ".$table." set nfg = nfg+1  where un = '".$_SESSION['un']."' ";

mysqli_query($dbc,$query) or die('ERROR');

$table = 'ud';

$query = "UPDATE ".$table." set nfr = nfr+1  where un = '".$un."' ";

mysqli_query($dbc,$query) or die(mysqli_error($dbc));

$query = "INSERT INTO followers(of,iss)  VALUES('".$un."','".$_SESSION['un']."')";

mysqli_query($dbc,$query) or die(mysqli_error($dbc));

echo 'You followed a person.';

//notify the person that is followed
$query = "INSERT INTO  notifications (of,type,eun,readd) VALUES ('".$un."',2,'".$_SESSION['un']."',0)";

mysqli_query($dbc,$query) or die();

}
else{
	echo'Error - You have already followed this person.';
}

}
else if($task==0){

if($followed==1){

$table = 'ud';

$query = "UPDATE ".$table." set nfg = nfg-1  where un = '".$_SESSION['un']."' ";

mysqli_query($dbc,$query) or die(mysqli_error($dbc));


$table = 'ud';

$query = "UPDATE ".$table." set nfr = nfr-1  where un = '".$un."' ";

mysqli_query($dbc,$query) or die(mysqli_error($dbc));

$table = 'followers';

$query = "DELETE from ".$table."  WHERE of = '".$un."' and iss = '".$_SESSION['un']."'";

mysqli_query($dbc,$query) or die(mysqli_error($dbc));

echo 'You unfollowed a person.';

}
else{
	echo'Error - You have already unfollowed this person.';
}

}

}

 ?>
