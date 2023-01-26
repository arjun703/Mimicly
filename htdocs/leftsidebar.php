<?php 
session_start();

echo'
<div>';
if(!isset($_SESSION['un'])){
echo'
<div onclick = "displayloginalert()"><i class = "fa fa-upload"></i><span>Upload  Post</span></div>
<div onclick = "displayloginalert()"><i class = "fa fa-edit"></i><span>Update Profile</span></div>
<div onclick = "displayloginalert()"><i class = "fa fa-eye"></i><span>View Your Profle</span></div>
<div onclick = "displayloginalert()"><i class = "fa fa-lock"></i>Change Password</div>
';
}
else{
	echo'
<div onclick = "loadtype3(\'uploadform.php\',\'showuploadform.php\',1)"><i class = "fa fa-upload"></i><span>Upload  Post</span></div>
<div onclick = "loadtype3(\'updateprofile.php\',\'showupdateprofileform.php\',1)"><i class = "fa fa-edit"></i><span>Update Profile</span></div>
<div onclick = "loadtype1(0,1,\'showprofile.php?un='.$_SESSION['un'].'&l=\',\'profile.php?un='.$_SESSION['un'].'\',1)"><i class = "fa fa-eye"></i><span>View Your Profle</span></div>
<div onclick = "loadtype3(\'changepasswordform.php\',\'showpasswordchangeform.php\',1)"><i class = "fa fa-lock"></i>Change Password</div>
';
}
echo'
<div onclick="aboutus()"><i class = "fa fa-users"></i>About Us</div>
<div><i class = "fa fa-comments-o"></i>Give Us  Feedback</div>
<div onclick = "loadtype3(\'searchbox.php\',\'showsearchbox.php\',1)"><i class = "fa fa-search"></i><span>Search Peoples</span></div>
<div onclick="loadtype1(0,1,\'showhomecontent.php?l=\',\'home.php\',0)"><i class="fa fa-home"></i><span>Navigate to Home</span></div>
';

echo'</div>';

 ?>