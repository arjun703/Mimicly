<?php 

session_start();
if(isset($_SESSION['un'])&&isset($_POST['newpass'])&&isset($_POST['currentpass'])){

$newpass = trim($_POST['newpass']);
$currentpass = trim($_POST['currentpass']);


require'db.php';

if(!empty($newpass)&&!empty($currentpass)){

$dbc = mysqli_connect($GLOBALS['host'],$GLOBALS['user'],$GLOBALS['pass'],$GLOBALS['db']);

$query  = "SELECT un from ud where un=  '".$_SESSION['un']."' and pw = '".sha1($currentpass)."' ";

$result = mysqli_query($dbc,$query);

if(mysqli_num_rows($result)==1){

$query = "UPDATE ud set  pw = '".sha1($newpass)."' where un = '".$_SESSION['un']."' ";

mysqli_query($dbc,$query) or die('Sorry Unexpected error occured.');

die('Yoour password was changed sucessfully.');

}
else{
	die('Your current password is incorrect.');
}

}
else{
	die('WT - Password fields empty');
}

}

 ?>