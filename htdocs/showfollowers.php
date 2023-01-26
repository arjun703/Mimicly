<?php  
session_start();
require 'db.php';

$hdr = '';
$ftr = '';
$content = '';
$lm = 1;
$limit = $_GET['l'];
$un = $_GET['un'];
	require 'functions.php';

if($_GET['l']==0){
	$hdr = showbbhdr('Followers');
	$ftr = fcftr($un);
}
else{
	$hdr = '';
	$ftr = '';
}

if(is_numeric($limit)){

//fetch posts from feed table

$dbc = mysqli_connect($GLOBALS['host'],$GLOBALS['user'],$GLOBALS['pass'],$GLOBALS['db']);

$query = "SELECT iss from followers where of = '".$un."' limit " . $limit .",3";

$result = mysqli_query($dbc,$query) or die(mysqli_error($dbc));

mysqli_close($dbc);

if(mysqli_num_rows($result)<3){

$lm = 0;

}	
else if(mysqli_num_rows($result)==3){
$lm = 1;
}

while($row = mysqli_fetch_array($result)){

$content = $content.displaypnfu($row['iss']);

}

}


$age = array("hdr"=>$hdr, "content"=>$content, "ftr"=>$ftr,"lm"=>$lm);

echo json_encode($age);


?>

