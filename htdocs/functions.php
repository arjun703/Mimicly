<?php 

require 'db.php';


function displaypost($vid){

$content = '';

$content .= '<div class="ph">';

$dbc = mysqli_connect($GLOBALS['host'],$GLOBALS['user'],$GLOBALS['pass'],$GLOBALS['db']);

$query = "SELECT TIME_TO_SEC(TIMEDIFF(NOW(),dp)) AS se, nl,nc,un,vid,vfn,title FROM videos WHERE vid = ".$vid." ";

$result  = mysqli_query($dbc,$query) or die(mysqli_error($dbc));

if(mysqli_num_rows($result)==1){

$row = mysqli_fetch_array($result);

$creator = $row['un'];
$content.=displaypnmo($creator,$vid);

$GLOBALS['likes'] = $row['nl'];

$GLOBALS['comments'] = $row['nc'];

$vid = $row['vid'];

$se = $row['se'];

if($se>=86400*365){
$date = floor(($se)/(86400*365)).' year(s)';
}
else if($se>=86400*30){
$date = floor(($se)/(86400*30)).' month(s)';
}
else if($se>=86400*7){
$date = floor(($se)/(86400*7)).' week(s)';
}
else if($se>=86400){
$date = floor(($se)/(86400)).' day(s)';
}
else if($se>3600){
$date = floor(($se)/(3600)).' hour(s)';
}
else if($se>60){
$date = floor(($se)/(60)).' min(s)';
}
else{
$date = $se.' sec(s)';
}

$videoname  =  $row['vfn'];

$videosrc = 'files/'.$videoname;

$title = $row['title'];

$content.='<div class="pt"><i class="fa fa-pencil"></i><span>'.$title.'
 <br><i class = "fa fa-clock-o"></i><strong style="opacity:0.7;padding-left:5px">'.$date.'</strong></div>';

//find out hastags related to this video

$query = "SELECT ht from hastags where vid = ".$vid." ";

$result = mysqli_query($dbc,$query);

while($row = mysqli_fetch_array($result)){
	$replaced = preg_replace('/#/','',$row['ht']);
	$content .='<div onclick = "loadtype1(0,1,\'showhastagvideos.php?ht='.$replaced.'&l=\',\'hastags.php?ht='.$replaced.'\',1)" id = "hastag">'.$row['ht'].'</div>'; 
}

$content.='<video class="viddeo" width="100%" src = "'.$videosrc.'" controls></video>';
$content .= displaylc($vid,$creator); ///display like and comment icon with number
}
else{
	$content .= '<div><table width="100%"><tr><th><i class = "fa fa-info-circle fa-2x">  </i></th><th> This content is not available. It may have been deleted.</th></tr></table> </div>';
}

$content.='</div>';

return $content;

}




function displaypnmo($un,$vid){
$content = '';
$content.='<div style="display:block">'.showppcandname($un);
$content.='<th class="moi" onclick="displaymo('.$un.','.$vid.')"
 ><i class="fa fa-ellipsis-h" style="float:left"></i></th>
';

$content .= '</tr></table></div>';

return $content;
}


function displaypnfu($un){

$content = '';

$content.='<div style="display:block">'.showppcandname($un);


$content.=createfbtn($un);

$content .= '</tr></table></div>';

return $content;

}

function showppcandname($un){

$ppandname = getppandname($un);


$pv = $ppandname[0];

$fn = $ppandname[1];

$ln  = $ppandname[2];

$dir = 'files/';

if($pv!=''){
$ppsrc = $dir.$pp;
}
else{
	$ppsrc = 'user.webp';
}

$name = $fn.' '.$ln;

$content = '
<table class="ppnfuh">
<tr>
<th 
onclick="loadtype1(0,1,\'showprofile.php?un='.$un.'&l=\',\'profile.php?un='.$un.'\',1)"
class="ppch"><img src = "'.$ppsrc.'"  class="ppc"></th>
<th>'.$name.'</th>
';

return $content;

}

function createfbtn($un){

$content='';

	if(isset($_SESSION['un'])){


if($_SESSION['un']!=$un){

		$fu = getfui($un); //get follow unfollow info


$fbtnid = 'fbtn_'.$un;

	if($fu==1){ //the user follows,give option to unfollow
		$content .= '
		<th><span class="fb"> <button  class="'.$fbtnid.'"  onclick="unfollow(\''.$un.'\')">Unfollow</button></span></th>
		';
	}
	else{
		$content .='
		<th><span class="fb"><button  class="'.$fbtnid.'" onclick="follow(\''.$un.'\')">Follow</button></th>
		';
	}
  }
}
else{
		$content .= '
		<th><button class="fbtn" onclick="displayloginalert()">Follow</button></th>
		';
	}

return $content;

}



function getppandname($un){



$dbc = mysqli_connect($GLOBALS['host'],$GLOBALS['user'],$GLOBALS['pass'],$GLOBALS['db']);


$query = "SELECT pv,fn,ln,nfr,nfg,dj,pviews  from ud WHERE un = '".$un."'  ";

$result = mysqli_query($dbc,$query);

if(mysqli_num_rows($result)==1){

$row = mysqli_fetch_array($result);

$ppandname = array($row['pv'],$row['fn'],$row['ln'],$row['nfr'],$row['nfg'],$row['dj'],$row['pviews']);

}
else{
	$ppandname=array('','','','','');
}

mysqli_close($dbc);

return $ppandname;

}



function getfui($un){


$dbc = mysqli_connect($GLOBALS['host'],$GLOBALS['user'],$GLOBALS['pass'],$GLOBALS['db']);

$query = "SELECT iss from followers where of = '".$un."' and iss = '".$_SESSION['un']."' ";

$result = mysqli_query($dbc,$query);

mysqli_close($dbc);

if(mysqli_num_rows($result)==1){
	return 1;
}
else{
	return 0;
}

}

$likes = 0;$comments = 0;


function displaylc($vid,$creator){

$content = '<div class="lch">';

$content.='<table class="rxnoptions"><tr>';

$lbtnid = 'lbtn_'.$vid;

$nlikesid = 'nlikes_'.$vid;

if(isset($_SESSION['un'])){
$liked = checkifliked($vid);
}
else{
	$liked=0;
}
 
//like


if($liked==1){
$content.='
<th>
<span class="'.$lbtnid.'" onclick="unlike(\''.$creator.'\','.$vid.')">
<i class="fa fa-heart" 
 style="color:red" 
 ></i>
 </span>
 </th>
 ';
}

else{
if(isset($_SESSION['un'])){
$content.='
<th>
<span  class="'.$lbtnid.'" onclick="like(\''.$creator.'\','.$vid.')">
<i class="fa fa-heart-o"  
></i>
</span>
 </th>
';
}
else{

$content.='
<th>
<i class="fa fa-heart-o"  onclick="displayloginalert()"></i></th>
';

}
}

//no of likes

$content.='<th><i   
onclick=" loadtype1(0,3,\'showlikes.php?vid='.$vid.'&l=\',\'likes.php?vid='.$vid.'\',1)" class ="'.$nlikesid.'">'.$GLOBALS['likes'].'</i></th>';

//comment

$content.= '
<th onclick="loadtype1(0,1,\'showcomments.php?vid='.$vid.'&un='.$creator.'&l=\',\'comment.php?vid='.$vid.'\',1)">
<i class="fa fa-comment-o"></i>
 </th>
 <th>
 <i>' . $GLOBALS['comments'] . '</i>
</th>
 
';



$content.='</tr></table>';

$content.='</div>';
return $content;

}

function checkifliked($vid){

$dbc = mysqli_connect($GLOBALS['host'],$GLOBALS['user'],$GLOBALS['pass'],$GLOBALS['db']);

$query = "SELECT un from likes where vid = ".$vid." and un = '".$_SESSION['un']." '";

$result = mysqli_query($dbc,$query);

mysqli_close($dbc);

if(mysqli_num_rows($result)==1){

return 1;

}
else{
	return 0;
}

}



function fcftr($un){

$fcftr = '

<table class="nav">

<tr>

<th  onclick="loadtype1(0,3,\'showfollowers.php?un='.$un.'&l=\',\'followers.php?un='.$un.'\',0)">

Followers

</th>

<th  onclick="loadtype1(0,3,\'showfollowings.php?un='.$un.'&l=\',\'followings.php?un='.$un.'\',0)">

Followings

</th>
</tr>
</table>

';

return $fcftr;

}


function showbbhdr($msg){
return '<table class="nav">
<tr>
<th style="width:30px" onclick="history.back()">
<i  class="fa fa-arrow-left"></i>
</th>

<th>
'.$msg.'
</th>
<tr>
</table>
';
}



 ?>

