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
}

$limit = $_GET['l'];

if(isset($_SESSION['un'])&&is_numeric($limit)){


if($_GET['l']==0){

	$content .= '<button class="btn" style="margin-top:20px;font-size:20px" onclick="loadtype3(\'uploadform.php\',\'showuploadform.php\',1)">Hi ' . $_SESSION['fn'] . ', Upload your fashion show video. [Click Here]</button><br>';
}


//fetch posts from feed table


$dbc = mysqli_connect($GLOBALS['host'],$GLOBALS['user'],$GLOBALS['pass'],$GLOBALS['db']);

$query = "SELECT vid from feed WHERE of = '".$_SESSION['un']."' order by  fid desc limit " . $limit .",1";

$result = mysqli_query($dbc,$query);

mysqli_close($dbc);

if(mysqli_num_rows($result)==0){

$lm = 0;

$content.='
<div class=ph><table width="100%;valign:center"><tr><th><i class = "fa fa-info-circle fa-2x">  </i></th><th>You have reached the end. <button  class="simplebtn" onclick = "document.getElementById(\'tc\').click()">Click Here</button> to view posts from most famous persons on this site.</th></tr></table> </div>';
}	
else{
$lm = 1;
$row = mysqli_fetch_array($result);
$content = $content.displaypost($row['vid']);
}
}
else{
	$content = '
<div class=ph><table width="100%;valign:center"><tr><th><i class = "fa fa-info-circle fa-2x">  </i></th><th><button class=simplebtn><a href = login.php>Login Now</a></button> to view posts from people you follow.</th></tr></table> </div>';
	$lm = 0;
}

$age = array("hdr"=>$hdr, "content"=>$content, "ftr"=>$ftr,"lm"=>$lm);

echo json_encode($age);

?>

