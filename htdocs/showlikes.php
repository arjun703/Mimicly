<?php 

session_start();

require 'db.php';

require 'functions.php';

$lm = 1;
$content = '';
$hdr='';
$ftr = '';
$vid = $_GET['vid'];



if($_GET['l']==0){
	$hdr=showbbhdr('Video Lovers');
}
 
$limit = $_GET['l'];

if(is_numeric($vid)&&is_numeric($limit)){


if($_GET['l']==0){
	$content = displaypost($vid) ;
}


$dbc = mysqli_connect($GLOBALS['host'],$GLOBALS['user'],$GLOBALS['pass'],$GLOBALS['db']);


$query = "SELECT un from likes where vid = '".$vid."' limit " . $limit .",3";

$result = mysqli_query($dbc,$query);

mysqli_close($dbc);

if(mysqli_num_rows($result)<3){

$lm = 0;

}	
else{
$lm = 1;
}

while($row = mysqli_fetch_array($result)){

$content .= displaypnfu($row['un']);

}

}

else{
	$content = 'Fuck off';
	$lm = 0;
}

$age = array("hdr"=>$hdr, "content"=>$content, "ftr"=>$ftr,"lm"=>$lm);


echo json_encode($age);






?>

