<?php  

require 'db.php';

$ftr='Search....';


if(trim($_GET['q']=='')){
	$content='';
	$hdr = $srhdr;
}
else{
	$hdr = '';
	$content = $_GET['q'];
}


$age = array("hdr"=>$hdr, "content"=>$content, "ftr"=>$ftr);

echo json_encode($age);


?>

