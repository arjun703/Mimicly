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

$audiosrc = 'files/'.$un.'/'.$row['audio'];

$content.='<div><audio controls src="'.$audiosrc.'"></audio></div>';

if($un==$_SESSION['un']){

$clbtnid = 'clbtn_'.$row['cid'];

$content.='<div>';
if($row['likes']==1){
$content.='<button id="'.$clbtnid.'" onclick="ulc('.$row['pid'].', '.$row['cid'].','.$cmntr.')">Unlike</button>';
}
else{
	$content.='<button id="'.$clbtnid.'" onclick="lc('.$row['pid'].', '.$row['cid'].','.$cmntr.')">Like</button>';
}

$content.='<button onclick="rc('.$row['cid'].')">Remove</button>';
$content.='</div>';
}
else{

if($row['likes']==1){
	$content.='<div class="lbs">Liked by speaker</div>';
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

