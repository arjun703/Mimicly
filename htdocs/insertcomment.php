<?php 
session_start();
if(isset($_SESSION['un'])&&isset($_POST['vid'])){
$vid = $_POST['vid'];
$cmt = htmlspecialchars(trim($_POST['cmt']));
if(is_numeric($vid)&&!empty($cmt)){

require 'db.php';

$dbc = mysqli_connect($GLOBALS['host'],$GLOBALS['user'],$GLOBALS['pass'],$GLOBALS['db']) or die(mysqli_error($dbc));

$cmt = mysqli_real_escape_string($dbc,$cmt);

$query = "INSERT INTO comments (vid,un,cmt,liked) VALUES(".$vid.",'".$_SESSION['un']."','".$cmt."',0)";

mysqli_query($dbc,$query) or die(mysqli_error($dbc));

$query = "UPDATE videos set nc = nc+1 WHERE vid = ".$vid." ";

mysqli_query($dbc,$query) or die('Sorry, ther was an unexpected error.');

echo 'Your comment was submitted.';



$query = "SELECT un from videos where vid = ".$vid."";

$result = mysqli_query($dbc,$query);

$row = mysqli_fetch_array($result);

$creator = $row['un'];

if($creator!=$_SESSION['un']){

$query = "INSERT INTO  notifications (of,type,eun,evid,readd) VALUES ('".$creator."',1,'".$_SESSION['un']."',".$vid.",0)";

mysqli_query($dbc,$query) or die();

}

}
else{
	die('error');
}

}
else{
	die('error');
}


 ?>