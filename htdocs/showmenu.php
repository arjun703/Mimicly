<?php 
session_start();
require 'db.php';

$ftr = $homeftr;
$hdr = $homehdr;
$lm = 0;
	$content='<button class="simplebtn">Menu</button>';

 if(isset($_SESSION['un'])){


$content.='<div style="text-align:center;">';

$content.='

<div class="papertext" onclick="loadtype3(\'uploadform.php\',\'showuploadform.php\',1)">Upload A Post</div>
<div class="papertext" onclick="loadtype1(0,1,\'showprofile.php?un='.$_SESSION['un'].'&l=\',\'profile.php?un='.$_SESSION['un'].'\',1)">View Your Profile</div>
<div class="papertext" onclick="loadtype3(\'changepasswordform.php\',\'showpasswordchangeform.php\',1)">Change Password</div>
</div>';
}


$content.='<div style="text-align:center">
<div class="papertext" onclick="aboutus()">About Us</div>
<div class="papertext" onclick="privacy()">Privacy And Terms</div>
<div class="papertext">Give Us Feedback</div>
</div>

';


$age = array("hdr"=>$hdr, "content"=>$content, "ftr"=>$ftr,"lm"=>$lm);
//echo $_COOKIE['remember'];
echo json_encode($age);

 ?>