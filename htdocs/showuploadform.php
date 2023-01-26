<?php 

require 'functions.php';

    $hdr = showbbhdr('Upload post');

$ftr ='';


$content='
<div class = "ph">
<form id="formd">
<h3 style = "text-align:center">You can upload your catwalk, fashion show video or acting clip.</h3>
<input type="text" name="title" id="uptext" style="margin-bottom:20px" placeholder="Video title....">

<div>
<label for  = "vid" >
<div id = "addiconh">
<img src = "addvideoicon.png" id = "addvideoicon">
</div>
</label>
</div>
<input style="opacity:0" name="video" id="vid" onchange = "previewvideo(event)" type = "file" accept="video/*">
</form>

<button class="btn" id="uploadbtn" 
onclick="uploadpost()"
 style="position:sticky;bottom:0px;margin-top:1px">Upload</button>

<div id="preview"></div>

</div>


';

$age = array("hdr"=>$hdr, "content"=>$content, "ftr"=>$ftr);

echo json_encode($age);

 ?>
