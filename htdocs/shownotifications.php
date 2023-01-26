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
		$content.='<button class="simplebtn">notifications</button>';

}

$limit = $_GET['l'];

if(isset($_SESSION['un'])&&is_numeric($limit)){




$dbc = mysqli_connect($GLOBALS['host'],$GLOBALS['user'],$GLOBALS['pass'],$GLOBALS['db']);



$query = "SELECT *  from notifications Where of = '".$_SESSION['un']."' order by  nid desc limit " . $limit .",10";

$result = mysqli_query($dbc,$query);


if(mysqli_num_rows($result)<10){

$lm = 0;

}	
else{
$lm = 1;
}


while($row = mysqli_fetch_array($result)){

$eun = $row['eun'];

$iniitator = getppandname($row['eun']);

$vid = $row['evid'];

$name = $iniitator[1].' '.$iniitator[2];

$pp = $iniitator[0];

if($pp!=''){
	$ppsrc = 'files/'.$pp;
}
else{
	$ppsrc = 'user.webp';
}


if($row['type']==0){

$noti = '<table class = "simpletable"><tr><th><img src ="'.$ppsrc.'" class="notiimg"></th><th>'.$name.' liked your video.</th></tr></table>';
 
if($row['readd']==0){

$content .='<div onclick = "loadtype1(0,3,\'showlikes.php?vid='.$vid.'&l=\',\'likes.php?vid='.$vid.'\',1)" class="unreadd">'.$noti.'</div>';
}
else{
	$content .='<div onclick = "loadtype1(0,3,\'showlikes.php?vid='.$vid.'&l=\',\'likes.php?vid='.$vid.'\',1)" class="readd">'.$noti.'</div>';
}

}

else if($row['type']==1){

//comment

	$noti = '<table class = "simpletable"><tr><th><img src ="'.$ppsrc.'" class="notiimg"></th><th>New Comment ! '.$name.' commented your video.</th></tr></table>';
 $creator = $_SESSION['un'];

if($row['readd']==0){
$content .='<div onclick="loadtype1(0,1,\'showcomments.php?vid='.$vid.'&un='.$creator.'&l=\',\'comment.php?vid='.$vid.'\',1)" class="unreadd">'.$noti.'</div>';
}
else{
	$content .='<div onclick="loadtype1(0,1,\'showcomments.php?vid='.$vid.'&un='.$creator.'&l=\',\'comment.php?vid='.$vid.'\',1)" class="readd">'.$noti.'</div>';
}

}

else if($row['type']==2){

$noti = '<table class = "simpletable"><tr><th><img src ="'.$ppsrc.'" class="notiimg"></th><th>New Follower ! '.$name.' followed you.</th></tr></table>';

if($row['readd']==0){

$content .='<div onclick="loadtype1(0,1,\'showprofile.php?un='.$eun.'&l=\',\'profile.php?un='.$eun.'\',1)" class="unreadd">'.$noti.'</div>';
}
else{
	$content .='<div onclick="loadtype1(0,1,\'showprofile.php?un='.$eun.'&l=\',\'profile.php?un='.$eun.'\',1)"  class="readd">'.$noti.'</div>';
}

}
else if($row['type']==3){

$cmntr= $_SESSION['un'];

$noti = '<table class = "simpletable"><tr><th><img src ="'.$ppsrc.'" class="notiimg"></th><th>'.$name.' liked your comment.</th></tr></table>';

if($row['readd']==0){

$content .='<div onclick="loadtype3(\'yourcomments.php?vid='.$vid.'\',\'yourcomments.php?vid='.$vid.'&l=\',1)" class="unreadd">'.$noti.'</div>';
}
else{
$content .='<div onclick="loadtype3(\'showhighlightedc.php?vid='.$vid.'\',\'yourcomments.php?vid='.$vid.'&l=\',1)" class="readd">'.$noti.'</div>';
}

}



}


$query = "UPDATE notifications SET readd = 1 Where readd=0 and of = '".$_SESSION['un']."'";

mysqli_query($dbc,$query);

mysqli_close($dbc);


}

else{
		$content = '

<div class=ph><table width="100%;valign:center"><tr><th><i class = "fa fa-info-circle fa-2x">  </i></th><th><button class=simplebtn><a href = login.php>Login Now</a></button> to view your notifications.</th></tr></table> </div>';
	$lm = 0;
}




$age = array("hdr"=>$hdr, "content"=>$content, "ftr"=>$ftr,"lm"=>$lm);


echo json_encode($age);






?>

