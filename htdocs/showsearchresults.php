<?php  

$q =  htmlspecialchars(trim($_GET['q']));
$limit = $_GET['l'];
require 'db.php';

$hdr = '';
$ftr = '';
$content = '';
$lm = 1;

if($limit==0){
$hdr='
<table class="nav">
<tr>
<th style="width:20px" onclick="history.back()">
<i style="width:15px" class="fa fa-arrow-left"></i>
</th>

<th onclick="history.back()">
'.$q.'
</th>
<tr>
</table>
';

}

if(!empty($q)&&is_numeric($limit)){


$q = explode(" ",$q);


$fn = $q[0];
$ln = $q[1];

require 'functions.php';

$dbc = mysqli_connect($GLOBALS['host'],$GLOBALS['user'],$GLOBALS['pass'],$GLOBALS['db']);

$query = "SELECT pv,fn,ln,un from ud where fn like '".$fn."%' and ln like '".$ln."%' ORDER BY nfr DESC limit ".$limit." , 3 ";

$result = mysqli_query($dbc,$query) or die('eRROR');

mysqli_close($dbc);

if(mysqli_num_rows($result)<3){
$lm = 0;
}
else{
	$lm =1;
}


while($row = mysqli_fetch_array($result)){


$pp = $row['pv'];
$fn = $row['fn'];
$ln = $row['ln'];
if($pp!=''){
$ppcsrc = 'files/'.$pp;
}
else{
	$ppcsrc='user.webp';
}

$content.='
<div class="ppandnameh" onclick="loadtype1(0,1,\'showprofile.php?un='.$row['un'].'&l=\',\'profile.php?un='.$row['un'].'\',1)"><table class="ppandnameht"><tr>
<th style="width:50%"><img class="searchphoto"  src="'.$ppcsrc.'"></th>
<th>' . $fn . ' ' . $ln.'</th>
</tr></table></div>
';

	}
}



$age = array("hdr"=>$hdr, "content"=>$content, "ftr"=>$ftr,"lm"=>$lm);

echo json_encode($age);




?>

