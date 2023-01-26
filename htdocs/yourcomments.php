<?php 

session_start();

require 'db.php';

require 'functions.php';

$lm = 0;
$content = '';
$hdr='';
$ftr = '';
$vid = $_GET['vid'];


	$hdr=showbbhdr('Viewing Your Comment(s)');
	$ftr = '..';

if(isset($_SESSION['un'])){

	$content = displaypost($vid) ;


$dbc = mysqli_connect($GLOBALS['host'],$GLOBALS['user'],$GLOBALS['pass'],$GLOBALS['db']);


$query = "SELECT * from comments where vid=".$vid." and un   = '".$_SESSION['un']."' ";

$result = mysqli_query($dbc,$query);

mysqli_close($dbc);


while($row = mysqli_fetch_array($result)){

$cmntr = $row['un'];

$chid = 'cmt_'.$row['cid'];

//showing commentor name
$content.='<div class="ph" id="'.$chid.'">';	
$content .='<div class="userprops" style="display:block">'.showppcandname($row['un']).'</tr></table></div>';

$content.='<div>'.$row['cmt'].'</div>';

if(isset($_SESSION['un'])){

if($cmntr==$_SESSION['un']){
	$content.='<button class="simplebtn" onclick="rca('.$row['cid'].')">Remove</button>';
}

if($row['liked']==1){
	$content.='<div class="lbs">Liked by Video Creator</div>';
}

}



$content.='</div>';

}

}

else{
	$content = 'ERROR';
	$lm = 0;
}

$age = array("hdr"=>$hdr, "content"=>$content, "ftr"=>$ftr,"lm"=>$lm);


echo json_encode($age);


?>

