function savestates(f){

		if(type==1){

			state={'l':limit,'i':icr,'lmu':loadmoreurl,'sy':window.scrollY,'type':1};

		}

		else{

			state={'type':3}

		}

		localStorage.setItem(f,JSON.stringify(state));

}





function setpageprops(l,i,lmu){

limit=l;

icr=i;

loadmoreurl=lmu;

lm=1;

type=1;

}



function pushorreplace(){

	if(shouldbepushed==1){

		//console.log('pushed: '+requestedfile);

		history.pushState({},'',requestedfile);

	}

	else{

		//console.log('replaced: '+requestedfile);

		history.replaceState({},'',requestedfile);

	}

}



function loadwhenpageend(){

		if(lm==1){

			var content = document.getElementById(requestedfile+'_content');

		if(window.innerHeight+window.scrollY+200>content.clientHeight){

			loadmore();

		}

	}

}



window.onscroll=function(){

loadwhenpageend();

}



function loadmore(){

	if(lm==1&&initial_reqest_fetched==1&&rd==0){

		limit=limit+icr;

	//console.log('inside loadmore');

		sourceurl = loadmoreurl+limit;

		fetchfromserver(sourceurl);

	}

}





function ffillupthespace(){

var interval = setInterval(function(){

	if(lm==0){

		clearInterval(interval);

	}

	else{

		var content = document.getElementById(requestedfile+'_content');

		if(content.clientHeight<window.innerHeight){

			loadmore();

		}

		else{

			clearInterval(interval);

		}

	}

},199)

}



function loadnewcontent(){

	if(type==1){

		firstsourceurl=loadmoreurl+0;

	}

	else{

		firstsourceurl=sourceurl;

	}

	fetchfromserver(firstsourceurl);

	if(lm==1){

		ffillupthespace();

	}

}





var scrolly;



function sleep(ms) {

  return new Promise(resolve => setTimeout(resolve, ms));

}



async function checkdiv(){

//hide all nodes

rd=1;



var childnodes = wcontent.children;



	for(var i=0;i<childnodes.length;i++){

	childnodes[i].style.marginLeft ="-1000px";

}



sleep(400).then(() => { 

	for(var i=0;i<childnodes.length;i++){

	childnodes[i].style.display="none";

}



var rqdiv = document.getElementById(requestedfile);



if(rqdiv){

//required div exists, hide all other divs and display the required one to user	

readdiv(requestedfile);

}

else{

var hdrid = requestedfile+'_hdr';

var contentid = requestedfile+'_content';

var ftrid = requestedfile+'_ftr';

var newdiv  = document.createElement('div');

newdiv.id=requestedfile;

newdiv.className = "slide";

newdiv.style.width=wcontent.style.width;

newdiv.innerHTML = '<div class="hdr" id = '+hdrid+'></div><div id = '+contentid+'></div><div class="ftr" id='+ftrid+'></div>';

wcontent.appendChild(newdiv);

rd=0;

loadnewcontent();

}







 });



}



function readdiv(){



var prevstate = JSON.parse(localStorage.getItem(requestedfile));

if(prevstate.type==1){

	//	console.log('inside readcache if');

	scrolly = prevstate.sy;

	setpageprops(prevstate.l,prevstate.i,prevstate.lmu);

}

else{

	type=3;

	lm=0;

	console.log('inside readcacheelse');

	scrolly=0;

}



document.getElementById(requestedfile).style.marginLeft="0px";

document.getElementById(requestedfile).style.display="block";

rd=0;

setTimeout(function(){window.scrollTo(0,scrolly);

},100);

}





function fetchfromserver(su){



if(initial_reqest_fetched==1){

	initial_reqest_fetched=0;

	

	var newdiv = document.createElement('div');

newdiv.innerHTML = 'Loading...';

var contentdiv =  document.getElementById(requestedfile+'_'+'content');

contentdiv.appendChild(newdiv);



	fetch(su).then(function(response){

				return response.json();

	})

	.then(function(data){



				if(data.lm==0){

				lm = 0;

				}



			if(data.hdr!=''){

				document.getElementById(requestedfile+'_'+'hdr').innerHTML=data.hdr;

			}

			if(data.ftr!=''){

				document.getElementById(requestedfile+'_'+'ftr').innerHTML=data.ftr;

			}



			newdiv.innerHTML=data.content;





			createobserver();



					//saving the states of current page after new content

					//is loaded

					//console.log('inside loadnewcontent, ucrrent satate saved');

					savestates(document.location);

					initial_reqest_fetched=1;

	})

}

}





//THIS FUNCTION DISPLAY TEXT IN CENTER OF THE SCREEN



function displaycentertext(centertext){

var overlay = document.createElement('div');

overlay.id="o";

document.body.style.overflow="hidden";

overlay.onclick = function(){}

document.body.appendChild(overlay);

var options = document.getElementById('centered');

options.innerHTML = centertext;

options.style.marginTop="0px";

}







var type,initial_reqest_fetched=1,lm,rd=0;



var leftsidebar  = document.getElementById('leftsidebar');

var wcontent = document.getElementById('wcontent');

var rightsidebar = document.getElementById('rightsidebar');



var statusmsgh = document.getElementById('statusmsgh');





//the following function makes webpage responsive



function setwidth(){

	var innerwidth = window.innerWidth;

	var extrawidtheach,extrawidth;

	if(innerwidth<400){

		leftsidebar.style.display="none";

		wcontent.style.width = "100%";

		wcontent.style.left = "0px";

		rightsidebar.style.display = "none";

	}

	else if(innerwidth<600){

		extrawidth = innerwidth-400;

		leftsidebar.style.display="none";

		wcontent.style.width = "450px";

		wcontent.style.left = "0px";

		wcontent.style.marginLeft  = (extrawidth/2)+"px";

		rightsidebar.style.display = "none";		

	}

	else if(innerwidth<1000){

		extrawidth = innerwidth-400-250;

		extrawidtheach = Math.floor(extrawidth/2);

		leftsidebar.style.width = "250px";

		leftsidebar.style.left = "0px";

		leftsidebar.style.marginLeft=Math.floor(extrawidtheach/2)+"px";

		leftsidebar.style.display="block";

		wcontent.style.left = extrawidtheach+250+"px";

		wcontent.style.marginLeft=Math.floor(extrawidtheach/2)+"px";

		wcontent.style.width = "400px";

		rightsidebar.style.display = "none";

	}

	else{

		extrawidth = innerwidth-400-250-280;

		extrawidtheach = Math.floor(extrawidth/3);

		leftsidebar.style.width = "250px";

		leftsidebar.style.left = "0px";

		leftsidebar.style.marginLeft=Math.floor(extrawidtheach/2)+"px";

		leftsidebar.style.display="block";		

		wcontent.style.left = extrawidtheach+250+"px";

		wcontent.style.marginLeft=Math.floor(extrawidtheach/2)+"px";

		wcontent.style.width = "400px";

		rightsidebar.style.width = "280px";

		rightsidebar.style.left = extrawidtheach*2+250+400+"px";

		rightsidebar.style.marginLeft=Math.floor(extrawidtheach/2)+"px";

		rightsidebar.style.display="block";

	}

	statusmsgh.style.width = wcontent.clientWidth+"px";



}



setwidth();



window.onresize = function(){setwidth();}







if(window.innerWidth>600){



leftsidebar.innerHTML = '<i class = "fa fa-spinner fa-spin fa-2x"></i>';



	fetch('leftsidebar.php').then(function(response){

				return response.text();

	})

	.then(function(data){

		leftsidebar.innerHTML=data;

	})



}



function createrightsidebar(idd){

	var newdiv = document.createElement('div');

	newdiv.className = 'rightsidebarelement';

	newdiv.id = idd;

	rightsidebar.appendChild(newdiv);

}





function displayrandomjoke(){

	var randomjokeh = document.getElementById('randomjoke');

	randomjokeh.innerHTML = '<i class="fa fa-spinner fa-2x fa-spin"></i>';

		fetch( "https://v2.jokeapi.dev/joke/Any?type=single").then(function(response){

				return response.json();

	})

	.then(function(data){		

		randomjokeh.innerHTML = '';

		var subhdr = document.createElement('div');

		subhdr.className = "subhdr";

		subhdr.innerHTML = 'Random Joke';

		randomjokeh.appendChild(subhdr);

		var content = document.createElement('div');

		content.className = 'rscontent';

		content.innerHTML =data.joke;

		randomjokeh.appendChild(content);

		var buttonh  = document.createElement('div');

		buttonh.innerHTML = '<br><button class="next" onclick = "displayrandomjoke()">Next </button>';

		randomjokeh.appendChild(buttonh);

	})

}



function displayrandomquote(){

	var randomquoteh = document.getElementById('randomquote');

	randomquoteh.innerHTML = '<i class="fa fa-spinner fa-2x fa-spin"></i>';



		fetch("https://api.quotable.io/random").then(function(response){

				return response.json();

	})

	.then(function(data){		

		randomquoteh.innerHTML = '';

		var subhdr = document.createElement('div');

		subhdr.className = "subhdr";

		subhdr.innerHTML = 'Random Quote';

		randomquoteh.appendChild(subhdr);

		var content = document.createElement('div');

		content.className = 'rscontent';

		content.innerHTML ='" '+data.content+' "<br>'+'<i class="quoter">- '+data.author+'</i>';

		randomquoteh.appendChild(content);

		var buttonh  = document.createElement('div');

		buttonh.innerHTML = '<br><button class="next" onclick = "displayrandomquote()">Next </button>';

		randomquoteh.appendChild(buttonh);

	})

}





if(window.innerWidth>=1000){

	//load rightsidebar, 



createrightsidebar('randomjoke');

createrightsidebar('randomquote');

displayrandomjoke();

displayrandomquote();



}













function showsearchsuggestions(){

var q = document.getElementById('sb')

q = q.value.trim();

q = q.replace(' ', '+');

q = 'searchsuggestions.php?q='+q;

document.getElementById(requestedfile+'_content').innerHTML='<i class="fa fa-spinner fa-spin"></i>';

fetch(q).then(function(response){return response.text();}).then(function(data){document.getElementById(requestedfile+'_content').innerHTML=data;

})

}





window.onpopstate= async function(){

requestedfile = document.location;

 checkdiv();

}







var prefile = 'http://mimicly.rf.gd/';



function refresh(){

var toberemoved = document.getElementById(requestedfile);

if(toberemoved){

var removed = 	wcontent.removeChild(toberemoved);

}

checkdiv();

}



function loadtype1(l,i,lmu,rf,sbp){

	requestedfile = prefile +rf;

	if(document.location!=requestedfile){	

	//console.log(requestedfile);

	setpageprops(l,i,lmu);

	shouldbepushed=sbp;

	pushorreplace();

	checkdiv();

	}

	else{

		//console.log('inside refresh');

		setpageprops(l,i,lmu);

		refresh();

	}

}





function loadtype3(rf,su,sbp){

requestedfile = prefile +rf;

sourceurl=su;

if(document.location!=requestedfile){

lm=0;type=3;shouldbepushed=sbp;

pushorreplace();

checkdiv();

//console.log('Inside loadtype3');

}

else{

	refresh();

}



}





var tv=0,videos;

function previewvideo(event){

var preview = document.getElementById('preview');

preview.innerHTML = "";

 videos = event.target.files;

tv=videos.length;

if(tv>0){

	preview.innerHTML = '<ul><li>'+videos[0].name+'</li></ul>';

}



}

function validate(){

if(tv==0){

	displaystatusmsg('You need to Select a video to upload post',1);

	return false;

}

else if(document.getElementById('uptext').value==''){

	displaystatusmsg('Your video should have a title.',1);

	return false;

}

else if(videos[0].size>20*1024*1024){

		displaystatusmsg('Sorry, Video size can not exceed 20 MB.',1);

		return false;

}

return true;

}







function uploadpost(){



if(validate()){

//upload

var uploadbtn = document.getElementById('uploadbtn');

uploadbtn.innerHTML = 'Uploading....';

displaystatusmsg('Uploading post--<i class="fa fa-spinner fa-spin"></i>',1);

history.back();

uploadbtn.disabled=true;

//uploadbtn.style.opacity = '0.5';

var formd = document.getElementById('formd');

var formdata = new FormData(formd);

var xmlhttp = new XMLHttpRequest();



xmlhttp.onreadystatechange=function(){

	if(this.readyState==4&&this.status==200){

		uploadbtn.innerHTML = this.responseText;

		displaystatusmsg(this.responseText,1);

 document.getElementById('uptext').value='';

	}

}



xmlhttp.open('POST','upload.php');

xmlhttp.send(formdata);

	

}



}



function displaytt(string,event){ //display tt = display tooltip

	var boundingrect = event.target.getBoundingClientRect();

	var elementleft = boundingrect.left;

	var elementbottom = boundingrect.bottom;

	var tooltip = document.getElementById('tooltip');

	tooltip.innerHTML = string;

	tooltip.style.display="inline";

	tooltip.style.left = elementleft+"px";

	tooltip.style.top  = elementbottom+"px";

}



function hidett(){ //hide the tooltip

	document.getElementById('tooltip').style.display="none";

}













function showloveanimation(){

var imggg = document.createElement("img");

imggg.src= "love.GIF";

imggg.style.borderRadius = "50%";

imggg.style.width="150px";

imggg.style.height  = "150px";

imggg.style.position = "fixed";

imggg.style.border= '3px solid white';

imggg.style.left = "50%";

imggg.style.top = "50%";

imggg.style.transform = "translate(-50%,-50%)";

document.body.appendChild(imggg);

setTimeout(function(){document.body.removeChild(imggg);},2000);

}







function like(un,vid){

showloveanimation();

var lbtnclass = 'lbtn_'+vid;

var lbtn  = document.getElementsByClassName(lbtnclass);



for(var i=0;i<lbtn.length;i++){

lbtn[i].innerHTML = '<i class="fa fa-heart" style="color:red"></i>';

lbtn[i].onclick=function(){unlike(un,vid)};

}



nlikesclass  = 'nlikes_'+vid;

var nlikes = document.getElementsByClassName(nlikesclass);

for(var i=0;i<nlikes.length;i++){

	nlikes[i].innerHTML = parseInt(nlikes[i].innerHTML,10)+1;

}



var su = 'likeunlike.php?un='+un+'&vid='+vid+'&task=1';



sendpostreq(su);



}



function unlike(un,vid){



var lbtnclass = 'lbtn_'+vid;



var lbtn  = document.getElementsByClassName(lbtnclass);



for(var i=0;i<lbtn.length;i++){

lbtn[i].innerHTML = '<i  class="fa fa-heart-o" style="color:"></i>';

lbtn[i].onclick=function(){like(un,vid)};

}



nlikesclass  = 'nlikes_'+vid;

var nlikes = document.getElementsByClassName(nlikesclass);



for(var i=0;i<nlikes.length;i++){

	nlikes[i].innerHTML = parseInt(nlikes[i].innerHTML,10)-1;

}

var su = 'likeunlike.php?un='+un+'&vid='+vid+'&task=0';



sendpostreq(su);



}





function checknoti(){



fetch('checknewnoti.php').then(function(response){

	return response.json();

})

.then(function(data){



	var nbadges = document.getElementsByClassName('nbadge');



			for(var i = 0;i<nbadges.length;i++){

if(data.nnoti>0){

		nbadges[i].style.opacity="1";

		nbadges[i].innerHTML=data.nnoti;

		}

	else{

		nbadges[i].style.opacity="0";

	}

 }

})





}



checknoti();



setInterval(checknoti,100000);



function sendpostreq(su){

var xmlhttp = new XMLHttpRequest();

xmlhttp.onreadystatechange = function(){

	if(this.readyState==4&&this.status==200){

		displaystatusmsg(this.responseText,0);

	}

}

xmlhttp.open('GET',su);

xmlhttp.send();

}







function follow(un){



var fbtnclass = 'fbtn_'+un;

var fbtns  = document.getElementsByClassName(fbtnclass);

for(var i=0;i<fbtns.length;i++){

fbtns[i].innerHTML = "<i class='fa fa-spinner fa-spin'></i>";

fbtns[i].disabled = true;

}

var su = 'followunfollow.php?un='+un+'&task=1';

fetch(su).then(function(response) {

 	return response.text();

})

.then(function(data){



	for(var i=0;i<fbtns.length;i++){

fbtns[i].innerHTML = "UnFollow";

fbtns[i].disabled = false;

	fbtns[i].onclick=function(){unfollow(un)};

}

	displaystatusmsg(data,0);

})

;



}



function unfollow(un){



var fbtnclass = 'fbtn_'+un;

var fbtns  = document.getElementsByClassName(fbtnclass);

for(var i=0;i<fbtns.length;i++){

fbtns[i].innerHTML = "<i class='fa fa-spinner fa-spin'></i>";

fbtns[i].disabled = true;

}

var su = 'followunfollow.php?un='+un+'&task=0';

fetch(su).then(function(response) {

 	return response.text();

})

.then(function(data){



	

	for(var i=0;i<fbtns.length;i++){

fbtns[i].innerHTML = "Follow";

fbtns[i].disabled = false;

	fbtns[i].onclick=function(){follow(un)};

}

	displaystatusmsg(data,0);



})

;



}







function displaystatusmsg(msg,longer){

if(longer==0){

	statusmsgh.innerHTML = msg;

setTimeout(hidestatusmsg,3000);

}

else{

		statusmsgh.innerHTML ='<table width = "100%"><tr><th>'+msg+'</th><th>  <i style="float:right;" class="fa fa-close" onclick="hidestatusmsg()"></i></th></tr></table>';

}

statusmsgh.style.marginLeft = "0px";



}



function hidestatusmsg(){	

	document.getElementById('statusmsgh').style.marginLeft = -wcontent.clientWidth-200+"px";

}



function displayoverlay(){

var overlay = document.createElement('div');



overlay.id="o";



document.body.style.overflow="hidden";

overlay.onclick = function(){

	hideoverlay();

}



document.body.appendChild(overlay);

}





function displaymo(un,pid){

displayoverlay();

var options = document.getElementById('centered');

options.innerHTML = '<div class="papertext" onclick="cltp('+un+')">Copy link to Profile</div><div class="papertext" onclick="cltp('+un+')">Copy link to Profile</div><div class="papertext" onclick="rp('+un+','+pid+')">Report Post</div><div class="papertext" onclick="hideoverlay()">Close</div>';

options.style.marginTop="0px";

}



function cltp(un){

var	text = prefile+'profile.php?un='+un;

navigator.clipboard.writeText(text);

displaystatusmsg('Link copied to clipboard',0);

}



function rp(un,pid){

	displaystatusmsg('Thanks for reporting the content !',0);

}



function deletecache(cn){

	cn = prefile+cn;

	//alert('deleting cache');

	caches.delete(cn);

}





function hideoverlay(){

var options = document.getElementById('centered');

options.style.marginTop=(window.innerHeight)/2+options.clientHeight+"px";

document.body.style.overflowY="scroll";

var overlay = document.getElementById('o');

document.body.removeChild(overlay);



}

 



function hcf(shbid,cfid){

	document.getElementById(shbid).innerHTML = "Show Comment Form";

	document.getElementById(cfid).style.display="none";

	document.getElementById(shbid).onclick = function(){scf(shbid,cfid);}

}



function scf(shbid,cfid){

	document.getElementById(shbid).innerHTML = "Hide Comment Form";

	document.getElementById(cfid).style.display="block";

	document.getElementById(shbid).onclick = function(){hcf(shbid,cfid);}

}



function insertcomment(vid){



var commentbtn =  document.getElementById('cmticon_'+vid);

var cmtbox = document.getElementById('cmt_'+vid);

var cmt = cmtbox.value;

if(cmt!=''){

commentbtn.style.display="none";



cmtbox.value="Commenting.....Please wait";



var su = 'insertcomment.php';



var formdata = new FormData();

formdata.append('vid',vid);

formdata.append('cmt',cmt);



var xmlhttp = new XMLHttpRequest();

xmlhttp.onreadystatechange=function(){

	if(this.readyState==4&&this.status==200){



displaystatusmsg(this.responseText,0);

refresh();

}

}

xmlhttp.open('POST',su);

xmlhttp.send(formdata);



}

else{

	displaystatusmsg('Comment box can\'t be empty',1);

}



}





function ulc(cid){

var clbtnclass = 'clbtn_'+cid;

var clbtn  = document.getElementById(clbtnclass);

clbtn.innerHTML = 'Like';

clbtn.onclick=function(){lc(cid)};

var su = 'luc.php?cid='+cid+'&task=0';

sendpostreq(su);

}



function lc(cid){	

var clbtnclass = 'clbtn_'+cid;

var clbtn  = document.getElementById(clbtnclass);

clbtn.innerHTML = 'UnLike';

clbtn.onclick=function(){ulc(cid)};

var su = 'luc.php?cid='+cid+'&task=1';

sendpostreq(su);



}



function rca(cid){

displayoverlay();

var options = document.getElementById('centered');

options.innerHTML='<div class="au">Remove the comment ?<table class="ctable"><tr><th> <div class="papertext" onclick="hideoverlay()">Cancel</div></th><th> <div class="papertext" onclick="removec('+cid+')">Remove</div></th></tr></table></div>';

options.style.marginTop="0px";

}



function removec(cid){

hideoverlay();

var cmthid = 'cmt_'+cid;

var cmth = document.getElementById(cmthid);

cmth.innerHTML = '<div id="papertext" style="text-align:center"><i class="fa fa-spinner fa-spin"></i></div>';

var su = 'removec.php?cid='+cid;

fetch(su).then(function(response) {

 	return response.text();

})

.then(function(data){

	cmth.innerHTML = '<div class="papertext" style="text-align:center">'+data+'</div>';

	displaystatusmsg(data,0);

})

;



}





function alertdp(pid){

displayoverlay();

var options = document.getElementById('centered');

options.innerHTML='<b>Delete Post ?</b><table class="ctable"><tr><th> <div class="papertext" onclick="hideoverlay()">Cancel</div></th><th> <div class="papertext" onclick="deletep('+pid+')">Delete</div></th></tr></table>';

options.style.marginTop="0px";



}







function deletep(pid){



hideoverlay();

var phid = 'post_'+pid;

var ph = document.getElementById(phid);

ph.innerHTML = '<div id="papertext" style="text-align:center"><i class="fa fa-spinner fa-spin"></i></div>';

var su = 'deletep.php?pid='+pid;

fetch(su).then(function(response) {

 	return response.text();

})

.then(function(data){

	ph.innerHTML = '<div class="papertext" style="text-align:center">'+data+'</div>';

})

;





}





function rm(task){

	var toggles  = document.getElementById('toggles');

	if(task==1){

		//remembered

		toggles.className= "fa fa-toggle-on fa-2x";

		toggles.onclick=function(){rm(0);}

	}

	else{

		//unremembered

		toggles.className= "fa fa-toggle-off fa-2x";

		toggles.onclick=function(){rm(1);}



	}

	var su = 'setcookies.php?task='+task;

	sendpostreq(su);

}







function changepassword(){

	var cpf = document.getElementById('cpf');

	var formd = new FormData(cpf);

	var xmlhttp = new XMLHttpRequest();

	xmlhttp.onreadystatechange=function(){

		if(this.readyState==4&&this.status==200){

			displaystatusmsg(this.responseText,1);

		}

	}

	xmlhttp.open('POST','changepassword.php');

	xmlhttp.send(formd);

}



function aboutus(){

displayoverlay();

var options = document.getElementById('centered');

options.innerHTML='<div class="au">We are a  set of students trying to build a source of entertainment, fully entertainment. <br>Emails:<br> techfun703@gmail.com<br>harry765@gmail.com</div>';

options.style.marginTop="0px";

options.className = "au";

}



function displayloginalert(){

	displaycentertext('<i class="fa fa-exclamation-circle fa-3x"></i><br><b>You must login to complete this action.</b><table class = "simple"><tr><th><button class="btn"><a href="login.php">Login Now</a></button></th><th><button class="btn" onclick="hideoverlay()">Cancel</button></th></tr></table> ')

}





function daynight(task){

	switch(task){

		case 1: //day mode

		document.body.style.color = "black";

		document.body.style.backgroundColor="white";

		var tgn = document.getElementsByClassName('tgn');

		for(var i=0;i<tgn.length;i++){

			tgn[i].onclick=function(){daynight(0);}

		}

		break;

		case 0:

		document.body.style.color = "white";

		document.body.style.backgroundColor="black";

				var tgn = document.getElementsByClassName('tgn');

		for(var i=0;i<tgn.length;i++){

			tgn[i].onclick=function(){daynight(1);}

		}

break;

	}

}







//opacity accourding to percentage of visiblity



function buildThresholdList() {

  let thresholds = [];

  let numSteps = 30;



  for (let i=1.0; i<=numSteps; i++) {

    let ratio = i/numSteps;

    thresholds.push(ratio);

  }

  thresholds.push(0);

  return thresholds;

}



  var options = {

        root: null,

    rootMargin: "0px",

  threshold:buildThresholdList()

}









function callback(entries, observer){

  //alert(entries.length);

  entries.forEach(entry => {

  //alert(entry.intersectionRatio);

 // entry.target.style.opacity = entry.intersectionRatio;

  if(entry.intersectionRatio==1){

  	entry.target.style.backgroundColor='';

  }

  else{  	

  	entry.target.style.backgroundColor = 'rgba('+Math.floor((Math.random() * 255)) +','+Math.floor((Math.random() * 255))+','+Math.floor((Math.random() *255))

+','+(1-entry.intersectionRatio)+')';

  }

  

  });

}

 

  var videooptions = {

        root: null,

    rootMargin: "0px",

  threshold:[0,0.1,0.3,0.5]

}



var currentplayid='';



function videocallback(entries,observer){

		entries.forEach(entry=>{

			entry.target.pause();

		});

}



function createobserver(){

let observer = new IntersectionObserver(callback, options);

let target = document.querySelectorAll('.ph');

target.forEach(targett=>{

observer.observe(targett);

}

  )



let observer3 = new IntersectionObserver(videocallback,videooptions);

let target3 = document.querySelectorAll('.viddeo');

target3.forEach(targett=>{

observer3.observe(targett);

}

  )



}





