<?php  


require 'db.php';

$ftr='Search.......';

$sbhdr =  '

<table class="nav">
<tr>
<th width = "50px" onclick="history.back()">
<i style = "width: 30px" class="fa fa-arrow-left"></i>
</th>

<th>
<input  onkeyup="showsearchsuggestions()"  id="sb" type="text" placeholder="Search..." autofocus="true">
</th>
<tr>

</th>

';
	$content='';

$age = array("hdr"=>$sbhdr, "content"=>$content, "ftr"=>$ftr);

echo json_encode($age);


?>

