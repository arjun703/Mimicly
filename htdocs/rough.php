<?php 

$a = '#aaa#aa';
echo 'orginal: '.$a.'<br>';
$a = preg_replace('/#/', '',$a);
echo 'replaced: '.$a.'<br>';


 ?>