<?php 
session_start();

if(isset($_SESSION['un'])&&isset($_GET['cid'])){

$cid = $_GET['cid'];

if(is_numeric($cid)){
	require 'db.php';

	$dbc = mysqli_connect($GLOBALS['host'],$GLOBALS['user'],$GLOBALS['pass'],$GLOBALS['db']) or die('Sorry, An error occured while removing comment.');

	$query = "SELECT un,vid from comments where cid=".$cid." ";

	$result = mysqli_query($dbc,$query) or die('Sorry, an eror occured') ;

	$row = mysqli_fetch_array($result) ;

	$commentor = $row['un'];

	$vid= $row['vid'];

	$query = "SELECT un from videos where vid =".$vid." ";

	$result = mysqli_query($dbc,$query);

	$row = mysqli_fetch_array($result);

	$videocreater = $row['un'];

	if($commentor==$_SESSION['un']||$videocreater==$_SESSION['un']){
		$query = "DELETE from comments where cid =".$cid." ";

		if(mysqli_query($dbc,$query)){
			echo 'Comment Sucessfully removed.';

$query = "UPDATE videos set nc = nc-1 where vid = ".$vid." ";
mysqli_query($dbc,$query);


		}
	}
	else{
		echo 'Comment removal UnSucessful';
	}
}


}




 ?>