<?php 
session_start();
$cid = $_GET['cid'];
$task = $_GET['task'];
if(isset($_SESSION['un'])&&is_numeric($cid)&&is_numeric($task)){

require 'db.php';

require 'functions.php';

$dbc = mysqli_connect($GLOBALS['host'],$GLOBALS['user'],$GLOBALS['pass'],$GLOBALS['db']);

if($task==1){ //like the comment


$query = "UPDATE comments set liked = 1  where cid = ".$cid." ";

mysqli_query($dbc,$query) or die('Error while liking the comment');


$query = "SELECT un,vid from comments where cid = ".$cid."";

$result = mysqli_query($dbc,$query);

if(mysqli_num_rows($result)==1){

	$row = mysqli_fetch_array($result);
	$cmntr = $row['un'];
	$evid  = $row['vid'];

	if($cmntr!=$_SESSION['un']){

$query = "INSERT INTO  notifications (of,type,eun,evid,readd) VALUES ('".$cmntr."',3,'".$_SESSION['un']."',".$evid.",0)";

mysqli_query($dbc,$query) or die('An error occured');

	}
}


echo 'You liked a comment';
}

else if($task==0){

$query = "UPDATE comments set liked = 0  where cid = ".$cid." ";

mysqli_query($dbc,$query) or die('Error while liking the comment');

echo 'You unliked the comment';

}

}

 ?>
