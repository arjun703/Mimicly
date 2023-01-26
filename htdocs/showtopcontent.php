<?php  

session_start();

require 'db.php';

require 'functions.php';

$lm = 1;
$content = '';
$hdr='';
$ftr = '';

if($_GET['l']==0){
	$hdr = $homehdr;
	$ftr = $homeftr;
	$content.='<button class="simplebtn">Top Content</button>';
}

$limit = $_GET['l'];

if(is_numeric($limit)){

//fetch posts from feed table

$dbc = mysqli_connect($GLOBALS['host'],$GLOBALS['user'],$GLOBALS['pass'],$GLOBALS['db']);

$table = 'ud';

$query = "SELECT un from ".$table." order by  nfr  desc ,dj limit " . $limit .",1";

$result = mysqli_query($dbc,$query) or die('Error');

if(mysqli_num_rows($result)==1){

	$lm = 1;

	$row = mysqli_fetch_array($result);

	$query = "SELECT vid from videos Where un  = '".$row['un']."' ORDER BY vid DESC limit 1";

	$result = mysqli_query($dbc,$query);

	if(mysqli_num_rows($result)==1){
		$roww = mysqli_fetch_array($result);
	//	$content.=$roww['vid'];
		$content.= displaypost($roww['vid']);
	}
}
else{
	$lm=0;
}
}

$age = array("hdr"=>$hdr, "content"=>$content, "ftr"=>$ftr,"lm"=>$lm);

echo json_encode($age);

?>

