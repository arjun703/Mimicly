<?php 

session_start();

require 'db.php';

require 'functions.php';

$lm = 0;
$content = '';
$hdr='';
$ftr = '.';

$hdr=showbbhdr('Change password');

$content.='<h3>Fill up the form below to change password.</h3>'; 


$content.='
<form id="cpf">
<input type="password" style="margin:5px 0 5px 0" name="currentpass" id="currentpass" 
placeholder="Current Password" required>
<input type="password"  name="newpass" id="newpass" 
placeholder="New Password" required>
</form>
<button class="btn" onclick="changepassword()">Change Password</button>
';

$age = array("hdr"=>$hdr, "content"=>$content, "ftr"=>$ftr,"lm"=>$lm);

echo json_encode($age);


?>

