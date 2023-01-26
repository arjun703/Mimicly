<?php 
session_start();
$vid = trim($_GET['vid']);
$un = $_GET['un'];
$task = trim($_GET['task']);

if(isset($_SESSION['un'])&&is_numeric($vid)&&is_numeric($task)){


require 'db.php';

require 'functions.php';

$liked = checkifliked($vid);


$dbc = mysqli_connect($GLOBALS['host'],$GLOBALS['user'],$GLOBALS['pass'],$GLOBALS['db']);



if($task==1){

if($liked==0){

$query = "UPDATE videos set nl = nl+1  where vid = '".$vid."' ";

mysqli_query($dbc,$query) or die('ERROR');

$query = "INSERT INTO likes  VALUES(".$vid.",'".$_SESSION['un']."')";

mysqli_query($dbc,$query) or die('ERROR');



if($un!=$_SESSION['un']){

$query = "INSERT INTO  notifications (of,type,eun,evid,readd) VALUES ('".$un."',0,'".$_SESSION['un']."',".$vid.",0)";

mysqli_query($dbc,$query) or die();

}

echo 'You liked the post';
}
else{
	echo'Error - You have already liked this post.';
}

}
else if($task==0){

if($liked==1){


$query = "UPDATE videos set nl = nl-1  where vid = ".$vid." ";

mysqli_query($dbc,$query) or die('ERrro');


$query = "DELETE FROM  likes  WHERE vid =  ".$vid." and un = '".$_SESSION['un']."'";

mysqli_query($dbc,$query) or die('error');

echo 'You unliked the post';

}
else{
	echo'Error - You have already unliked this post.';
}

}

}

 ?>
