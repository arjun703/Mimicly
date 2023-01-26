<?php 
session_start();
$task = $_GET['task'];

if($task==1){
	setcookie('remember','1',time()+86400);
		setcookie('uid',$_SESSION['uid'],time()+86400);
	setcookie('password',$_SESSION['password'],time()+86400);
	die('You will be remembered  next time you log in.');
}
else{
	setcookie('remember','0',time()+86400);
	setcookie('uid',$_SESSION['uid'],time()-86400);
	setcookie('password',$_SESSION['password'],time()-86400);
	die('You won\'t be remembered.');
}


 ?>