<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Mimicly - Login </title>
<style type="text/css">
	.gridboxes{
  display: grid;
  align-items: center;
  text-align: center;
}

@media screen and (max-width: 2000px) {
  .gridboxes{
    width: 800px;
    margin-left: 50%;
    grid-template-columns: 1fr 1fr;
    -webkit-transform: translate(-50%);
    transform: translate(-50%);
  }
}


@media screen and (max-width: 800px) {
  .gridboxes{
      width:100%;
    margin-left: 0px;
    -webkit-transform: translate(0%);
    transform: translate(0%);
    grid-template-columns: 1fr;
  }
}


.gridbox{
    box-shadow: 0px 5px 10px 0px rgba(0,0,0,0.6);
    padding: 5px;
    margin:5px;
    margin-left:30px;
}

input[type=text],input[type=password],input[type=pw],input[type=submit],button{
  display: block;
  border-radius: 15px;
  width: 100%;
  box-sizing: border-box;
  margin-bottom: 10px;
  padding: 5px;
}


button,input[type=submit] {
  display: block;
  background: green; 
  border:none;
  color: white;
  font-size: 20px;
}

a{
  text-decoration: none;
  border:1px solid blue;
  padding: 5px;
  border-radius: 15px;
  background: blue;
  color: white;
  display: inline-block;
  margin-top: 15px;
}

#footer{
  bottom:0px;
  margin-top: 15px;
}


</style>
</head>
<body>
<div class="gridboxes">

	<div id = "desc" class="gridbox">
	<h2>Mimicly</h2>
	<strong>View catwalks, fashion show videos, and acting clips. You can also make your own and upload here.</strong>
	</div> 

	<div id="loginform" class="gridbox">
		<h5>Enter un and pw below to login.</h5>
		<form action="login.php" method = "POST">
			<input type="text" name="un" placeholder="Username" required>
			<input type="password" name="pw" placeholder="Password" required>
			<input type="submit" name="submit" value="Login">
			<strong>Don't have an account ?</strong>
			<br>
			<a href="register.php">Create New Account Here</a>
		</form>
		</form>
	</div>
</div>
<div id="footer">
	<a  href="about.html">About Us</a>
	<a  href="privacy.html">Privacy</a>
</div>
</body>
</html>

<?php 
if(isset($_POST['submit'])&&isset($_POST['un'])&&isset($_POST['pw'])){
require 'db.php';
$un = htmlspecialchars(trim($_POST['un']));
$pw = trim($_POST['pw']);
if(empty($pw)||empty($un)){
	die('Empty un or pw field');
}
$dbc = mysqli_connect($host,$user,$pass,$db) or die('error in connection');
$email = mysqli_real_escape_string($dbc,$un);
$query = "SELECT fn,ln from ud WHERE  un = '".$un."' and pw  = '".sha1($pw)."' ";
$result = mysqli_query($dbc,$query) or die('<h1>Error registering the user.</h1>');
if(mysqli_num_rows($result)==1){
$row = mysqli_fetch_array($result);
$_SESSION['un']=$un;
$_SESSION['fn']=$row['fn'];
$_SESSION['ln']=$row['ln'];
$_SESSION['pw']=$pw;
$location = 'home.php';
header('location:'.$location);
}
else{
	die('<a style="position:fixed;top:0px;text-align:center;width:100%">Incorrect username or password</a>');
}
}

 ?>