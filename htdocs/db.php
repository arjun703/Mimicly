<?php 

$host = 'sql300.epizy.com';
$user = 'epiz_30820131';
$pass = 'VODJKBUEOCQJ';
$db = 'epiz_30820131_mimicly';

$homehdr = 

'<table class="hhf">
			<tr>
			<th><i>Mimicly</i></th>
			<th class="tgn"  onclick="daynight(0)"><i  class="fa fa-moon-o"></i>
			</th>
			<th onclick="loadtype3(\'searchbox.php\',\'showsearchbox.php\',1)">
			<i  class="fa fa-search"></i>
			</th>
			</tr>
			</table>';

$homeftr  = '

<table class="hhf">

<tr>

<th  onclick="loadtype1(0,1,\'showhomecontent.php?l=\',\'home.php\',0)">

<i class="fa fa-home"></i>

</th>

<th title="Top Content" id="tc" onclick="loadtype1(0,1,\'showtopcontent.php?l=\',\'topcontent.php\',0)">

<i class="fa fa-fire"><br></i>

</th>
';

if(isset($_SESSION['un'])){
 
$homeftr.= '<th  onclick="loadtype1(0,3,\'showfollowers.php?un='.$_SESSION['un'].'&l=\',\'followers.php?un='.$_SESSION['un'].'\',1)">

<i class="fa fa-user"></i>

</th>';
}
else{

$homeftr.= '<th  onclick="alert(\'You need to login to view your followers and followings.\')">

<i class="fa fa-user"></i>

</th>';

}

$homeftr.= '<th  onclick="loadtype1(0,10,\'shownotifications.php?l=\',\'notifications.php\',0)">
<i class="fa fa-bell"><strong class="nbadge"></strong></i>
</th>

<th onclick="loadtype3(\'menu.php\',\'showmenu.php\',0)">
<i class="fa fa-bars"></i>
</th>

</tr>

</table>

';



 ?>