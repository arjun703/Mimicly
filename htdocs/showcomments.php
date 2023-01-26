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
	$hdr=showbbhdr('Viewing Comments');
	if(isset($_SESSION['un'])){
	$txtareaid = 'cmt_'.$vid;
	$cmticonid = 'cmticon_'.$vid;	
	$ftr = '
	<table class="nav"><tr><th><textarea autofocus placeholder="Comment...." style="width:100%;resize:none" id="'.$txtareaid.'" class="cmtbox"></textarea></th><th style="width:40px"><i class="fa fa-send" id="'.$cmticonid.'" onclick = "insertcomment('.$vid.')"></i>';
}
else{
$ftr = '<div class="ph"><button  onclick="displayloginalert()" class="fbtn">I also want to comment.</button></div>';
}
}
$limit = $_GET['l'];

if(is_numeric($limit)){

if($_GET['l']==0){

	$content = displaypost($vid) ;
}

$dbc = mysqli_connect($GLOBALS['host'],$GLOBALS['user'],$GLOBALS['pass'],$GLOBALS['db']);


$query = "SELECT * from comments where vid = ".$vid." ORDER BY cid DESC limit " . $limit .",1";

$result = mysqli_query($dbc,$query);



if(mysqli_num_rows($result)<1){

$lm = 0;

}	
else{
$lm = 1;
}

while($row = mysqli_fetch_array($result)){

$cmntr = $row['un'];

$chid = 'cmt_'.$row['cid'];

//showing commentor name
$content.='<div class="ph" id="'.$chid.'">';	
$content .='<div class="userprops" style="display:block">'.showppcandname($row['un']).'</tr></table></div>';

$content.='<div>'.$row['cmt'].'</div>';

if(isset($_SESSION['un'])){


$query = "SELECT un from videos where vid =".$vid." ";

$resultt = mysqli_query($dbc,$query);

mysqli_close($dbc);

$roww = mysqli_fetch_array($resultt);

$un = $roww['un']; //un is creator


if($un==$_SESSION['un']){

$clbtnid = 'clbtn_'.$row['cid'];

$content.='<div>';
if($row['liked']==1){
$content.='<button class="simplebtn" id="'.$clbtnid.'" onclick="ulc('.$row['cid'].')">Unlike</button>';
}
else{
	$content.='<button class="simplebtn" id="'.$clbtnid.'" onclick="lc('.$row['cid'].')">Like</button>';
}

$content.='<button class="simplebtn" onclick="rca('.$row['cid'].')">Remove</button>';

$content.='</div>';
}
else{

if($cmntr==$_SESSION['un']){
	$content.='<button class="simplebtn" onclick="rca('.$row['cid'].')">Remove</button>';
}

if($row['liked']==1){
	$content.='<div class="lbs">Liked by Video Creator</div>';
}

}

}

$content.='</div>';

}
}

$age = array("hdr"=>$hdr, "content"=>$content, "ftr"=>$ftr,"lm"=>$lm);


echo json_encode($age);






?>

