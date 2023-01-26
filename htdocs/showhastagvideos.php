<?php 
session_start();
$hastag = '#'.htmlspecialchars( trim($_GET['ht']));
$limit = $_GET['l'];

$lm = 1;
$hdr = '';
$content = '';
$ftr = '';


if(!empty($hastag)&&is_numeric($limit)){
	require 'db.php';
require 'functions.php';
if($limit==0){
	$hdr=showbbhdr($hastag);
}


$dbc = mysqli_connect($host,$user,$pass,$db);

$hastag = mysqli_real_escape_string($dbc,$hastag);


$query  = "SELECT vid from videos where vid IN (select vid from hastags where ht = '".$hastag."') ORDER BY nl DESC,nc desc, dp  limit ".$limit.",1";

$result = mysqli_query($dbc,$query) or die(mysqli_error($dbc));

$no = mysqli_num_rows($result) ;

if($no>0){
$lm = 1;
while($row = mysqli_fetch_array($result)){
$content.=displaypost($row['vid']);
}

}
else{
$lm = 0;
}

}

$age = array("hdr"=>$hdr, "content"=>$content, "ftr"=>$ftr,"lm"=>$lm);

echo json_encode($age);




 ?>