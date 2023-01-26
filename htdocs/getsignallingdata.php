<?php 

session_start();

require 'db.php';

if($_GET['caller']=='self'){
	$caller = $_SESSION['uid'];
}
else{
$caller= $_GET['caller'];
}

if($_GET['callee']=='self'){
$callee = $_SESSION['uid'];
}
else{
$callee=$_GET['callee'];
}

$dbc = mysqli_connect($host,$user,$pass,$db);

$signallingdata='';

if($_GET['whose']=='caller'){

$query = "SELECT offer,callerice from callinfo where caller=".$caller." and callee=".$callee."";

$result = mysqli_query($dbc,$query);

$row = mysqli_fetch_array($result);

if($row['offer']!=''){
	$offer = $row['offer'];
	$signallingdata = array("offer"=>$offer);
	$query = "UPDATE callinfo set offer  = '' where caller=".$caller." and callee=".$callee." ";
mysqli_query($dbc,$query) or die('ERROR INSERTING DATA');

}

if($row['callerice']!=''){
		$query = "UPDATE callinfo set callerice  = '' where caller=".$caller." and callee=".$callee." ";
mysqli_query($dbc,$query) or die('ERROR INSERTING DATA');

	$callerice = $row['callerice'];
	$signallingdata = array_merge($signallingdata,array("callerice"=>$callerice));


}

echo json_encode($signallingdata);

}
else if($_GET['whose']=='callee'){

$query = "SELECT answer,calleeice from callinfo where caller=".$caller." and callee=".$callee."";

$result = mysqli_query($dbc,$query) or die('Error retrieving data');

$row = mysqli_fetch_array($result);

if($row['answer']!=''){
		$query = "UPDATE callinfo set answer  = '' where caller=".$caller." and callee=".$callee." ";
mysqli_query($dbc,$query) or die('ERROR INSERTING DATA');

	$answer = $row['answer'];
	$signallingdata = array("answer"=>$answer);

}

if($row['calleeice']!=''){
		$query = "UPDATE callinfo set calleeice  = '' where caller=".$caller." and callee=".$callee." ";
mysqli_query($dbc,$query) or die('ERROR INSERTING DATA');

	$calleeice = $row['calleeice'];
	array_push($signallingdata,array("calleeice"=>$calleeice));
}

echo json_encode($signallingdata);

}



 ?>