<?php  
session_start();

require 'db.php';

require 'functions.php';

$lm = 1;
$content = '';
$hdr='';
$ftr = '';

if($_GET['l']==0){
	$hdr = showbbhdr('Viewing Profile');
	$ftr = '';
}

$limit = $_GET['l'];

if(isset($_GET['un'])&&is_numeric($limit)){
$un = $_GET['un'];

if($_GET['l']==0){

if(isset($_SESSION['un'])){

if($un!=$_SESSION['un']){

$dbc = mysqli_connect($GLOBALS['host'],$GLOBALS['user'],$GLOBALS['pass'],$GLOBALS['db']);

$query  = "UPDATE ud SET pviews = pviews+1 where un = ".$un." ";

mysqli_query($dbc,$query);
}

}

$ud  =  getppandname($un);

if($ud[0]!=''){
	$ppsrc='files/'.$ud[0];
}
else{
	$ppsrc='user.webp';
}

$name = $ud[1].' '.$ud[2];

$nfr = $ud[3];

$nfg = $ud[4];

$dj = $ud[5];

$pviews = $ud[6];

$content.='<div class="profileh"><img class="profilepic" src= "'.$ppsrc.'">

<div class="papertext">'.$name.'</div>

';

if(isset($_SESSION['un'])){
if($_SESSION['un']==$un){
	$content.='<div class="papertext"><b>This is You</b></div>';
}
else{
$content.='<div>'.createfbtn($un).'</div>';
}
}
else{
	$content.='<button class="btn" onclick="displayloginalert()">Follow</button>';
}
//pd = profile div
$content.='
<div id = "pd" style="font-size:18px;padding-top:5px">
<div onclick="
loadtype1(0,3,\'showfollowers.php?un='.$un.'&l=\',\'followers.php?un='.$un.'\',1)"><i class = "fa fa-user"></i><span><b>'.$nfr.' Followers</b></span>
</div>
<div
onclick="loadtype1(0,3,\'showfollowings.php?un='.$un.'&l=\',\'followings.php?un='.$un.'\',1)"><i class="fa fa-user"></i><span><b>
'.$nfg.' Followings</b></span>  
</div>
<div><i class="fa fa-eye"></i><span><b>'.$pviews.' Profile views</b></span></div>
<div><i class="fa fa-clock-o"></i><span><b>Joined on '.$dj.'</b></span></div>
</div>
';
	
$content.='</div>';

}

//fetch posts from feed table

$dbc = mysqli_connect($GLOBALS['host'],$GLOBALS['user'],$GLOBALS['pass'],$GLOBALS['db']);


$query = "SELECT vid from videos where un = '".$un."' order by  vid desc limit " . $limit .",1";

$result = mysqli_query($dbc,$query);

mysqli_close($dbc);

if(mysqli_num_rows($result)==0){

$lm = 0;

}

else{
$lm = 1;
$row = mysqli_fetch_array($result);
$content = $content.displaypost($row['vid']);
}

}


$age = array("hdr"=>$hdr, "content"=>$content, "ftr"=>$ftr,"lm"=>$lm);


echo json_encode($age);




?>

