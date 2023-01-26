<?php  

require 'db.php';

$content='';

if(htmlspecialchars(trim($_GET['q']))!=''){

$q = $_GET['q'];


$dbc = mysqli_connect($GLOBALS['host'],$GLOBALS['user'],$GLOBALS['pass'],$GLOBALS['db']);

$q = mysqli_real_escape_string($dbc,$q);

$q = explode(" ",$q);

$fn = $q[0];
$ln = $q[1];

$query = "SELECT distinct fn,ln from ud where fn like '".$fn."%' and ln like '".$ln."%' ORDER BY nfr DESC limit 10 ";

$result = mysqli_query($dbc,$query);

mysqli_close($dbc);

if(mysqli_num_rows($result)==0){
	$content .= '<div>Sorry, No suggestions for this query term</div>';
}

else{

while($row=mysqli_fetch_array($result)){

$content = $content.'<div class="searchsuggestions" onclick="

loadtype1(0,3,\'showsearchresults.php?q='.$row['fn'].'+'.$row['ln'].'&l=\',\'searchresults.php?q='.$row['fn'].'+'.$row['ln'].'\',1)
"
><strong>' . $row['fn']. ' ' . $row['ln'] . ' </strong></div>';

}

}

}

echo $content;

?>

