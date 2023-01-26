<?php
session_start(); 
if(isset($_SESSION['un'])){

$caption = htmlspecialchars(trim($_POST['title']));
$videosize = $_FILES['video']['size'];

if($caption==''||$videosize==0||$videosize>10*1024*1024){
	die('Error - Video Size greater than 10 MB. ');
}
else{

require 'db.php';
$dbc = mysqli_connect($host,$user,$pass,$db) or die('Error connecting to server');

$un = $_SESSION['un'];

$dir = 'files/';

$caption = mysqli_real_escape_string($dbc,$caption);

	$videoname  =  $_FILES['video']['name'];
	$videoext = strtolower(pathinfo($videoname,PATHINFO_EXTENSION));
	$videoname  = rand(0,555555555555555).'.'.$videoext;
	$videodest = $dir.$videoname;

$moved = 	move_uploaded_file($_FILES['video']['tmp_name'], $videodest);

if($moved){

$hastags = [];
$newcaption='';

$individual = explode(' ', $caption);
for($i=0;$i<count($individual);$i++){
  if(preg_match('/^#/', $individual[$i])){
    array_push($hastags,$individual[$i]);
  }
  else{
    $newcaption .=' '.$individual[$i]; 
  }
}


$query = "INSERT INTO videos (vfn,title,un,nl,nc,dp) VALUES
			('".$videoname."','".$newcaption."','".$un."',0,0,NOW())";

mysqli_query($dbc,$query) or die(mysqli_error($dbc));

//NOW INSIERT HASTAG

$query = "SELECT vid from videos where vfn = '".$videoname."' ";
$result = mysqli_query($dbc,$query);
$row  = mysqli_fetch_array($result);
$vid = $row['vid'];

for($i=0;$i<count($hastags);$i++){

$query = "INSERT INTO hastags VALUES('".$vid."','".$hastags[$i]."')";
mysqli_query($dbc,$query);

}

//now insert into the feed of the user's followers


$query = "SELECT iss FROM followers where of = '".$_SESSION['un']."' ";

$result = mysqli_query($dbc,$query);

while($row=mysqli_fetch_array($result)){


$query = "INSERT INTO feed (of,vid) VALUES ('".$row['iss']."',".$vid.")";

mysqli_query($dbc,$query);


}


echo 'Post uploaded sucessfully.';

}
else{
    echo'Video Upload failed. Error code:  '.$_FILES['video']['error'];
}

}


}
else{

	echo 'Error - You must login to upload.';
}




 ?>