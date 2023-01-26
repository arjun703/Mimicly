<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>


<script type="text/javascript">
	
var xmlhttp = new XMLHttpRequest();

xmlhttp.onreadystatechange=function(){
	if(this.readyState==4&&this.status==200){
window.location.href = "login.php";
}
}
xmlhttp.open('POST','rough.php');
xmlhttp.send();



</script>


</body>
</html>



