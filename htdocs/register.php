<?php session_start(); ?>


<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Mimicly - Register </title>
<style type="text/css">
	.gridboxes{
  display: grid;
  align-items: center;
  text-align: center;
}

@media screen and (max-width: 2000px) {
  .gridboxes{
    width: 100%;
    margin-left: 50%;
    grid-template-columns: 1fr 1fr;
    -webkit-transform: translate(-50%);
    transform: translate(-50%);
  }
}


@media screen and (max-width: 700px) {
  .gridboxes{
    margin-left: 0px;
    -webkit-transform: translate(0%);
    transform: translate(0%);
    grid-template-columns: 1fr;
  }
}


.gridbox{
    box-shadow: 0px 5px 10px 0px rgba(0,0,0,0.6);
    padding: 5px;
    margin: 5px;
}

input[type=text],input[type=password],input[type=submit],button{
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

#statusmsg{
	padding: 5px;
	position: fixed;
	top: 0px;
	background: red;
	color: white;
	font-weight: bold;
}

</style>
</head>
<body>
	<script type="text/javascript">
		var exists = false;
		function checkexistence(){
			var statusmsg = document.getElementById('statusmsg');
			statusmsg.style.display = "none";
			var un = document.getElementById('un').value;
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange=function(){
				if(this.readyState==4&&this.status==200){
					//alert(this.responseText);
					if(this.responseText=='1'){				
						exists = true;
						statusmsg.style.display = "block";
						statusmsg.innerHTML = 'User with this username already exists. Choose Another username.';
					}
				else{exists=false;}
				}
			}
			xmlhttp.open('GET','checkexistence.php?un='+un);
			xmlhttp.send();
		}

function validate(){
	if(exists){alert('WTF, The username already exists. Choose another username .');return false}else{
var regbtn = document.getElementById('reg');
regbtn.style.display = "none";
		return true}
}

	</script>
		<div style="display:none" id="statusmsg" ></div>
<div class="gridboxes">

	<div id = "desc" class="gridbox">
	<h2>Mimicly</h2><strong>View catwalk videos, fashion show videos, and acting clips. You can also make your own and upload here.</strong>
	</div> 
	<div id="loginform" class="gridbox">
		<h5>Enter details asked below to register.</h5>
		<form action="register.php" onsubmit = "return validate()" method = "POST">
			<input type="text" name="fn" placeholder="First name" required>
			<input type="text" name="ln" placeholder="Last name" required>
			<input type="text" onkeyup="checkexistence()" id="un" name="un" placeholder="username" required>
			<input type="password" name="pw" placeholder="password" required>
			<input type="submit" id="reg" name="submit" value="Register">
		</form>
		</form>
	</div>
</div>
<div id="footer">
	<a href="about.html">About Us</a>
	<a href="privacy.html">Privacy</a>
</div>
</body>
</html>

<?php 

function backtoregister(){
	$location = 'register.php';
	header('location: '.$location);
}



if(isset($_POST['submit'])){

echo 'submit set';

$fn = htmlspecialchars( trim($_POST['fn']));
$ln = htmlspecialchars( trim($_POST['ln']));
$un = htmlspecialchars(trim($_POST['un']));
$pw = trim($_POST['pw']);


//validate the inputs

if (
	empty($fn)
	||empty($ln)
	||empty($un)
	||empty($pw)
	)
	 { 
		backtoregister();
	 }
else{
//insert the details into the database
require 'db.php';
$dbc = mysqli_connect($host,$user,$pass,$db);

$fn =  mysqli_real_escape_string($dbc,$fn);

$ln =  mysqli_real_escape_string($dbc,$ln);

$un =  mysqli_real_escape_string($dbc,$un);



$query = "INSERT INTO ud(fn,ln,un,pw,nfr,nfg,dj,pviews,pv) values('".$fn."','".$ln."','".$un."','".sha1($pw)."',0,0,NOW(),0,'')";

mysqli_query($dbc,$query) or die('<div id = "statusmsg">'.mysqli_error($dbc).'</div>');

$_SESSION['un'] = $un;
$_SESSION['pw'] = $pw;
$_SESSION['fn'] = $fn;
$_SESSION['ln'] = $ln;

$location = 'home.php';
header('location:'.$location);

}
}


 ?>