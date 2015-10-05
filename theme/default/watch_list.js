function bos() {
	var blank1 = document.getElementById('falseVideoField');
	var blank2 = document.getElementById('spacer1');
	var videof = document.getElementById('trueVideoField');
	if (isBig==1) {
		blank1.style.height = 440;
		blank2.style.height = 1;
		videof.style.height = 440;
		videof.style.width = 600;
		videof.style.left = 8;
		isBig=0;
	} else {
		blank1.style.height = 1;
		blank2.style.height = "85%";
		videof.style.height = "80%";
		videof.style.width = "80%";
		videof.style.left = "10%";
		isBig=1;
	}
}
function playItem(vid,index) {
	var o=document.getElementById(vid);
    var jar=document.getElementById('video_playlist_jar');
	document.getElementById(prevItemId).className = 'vitem';
	o.className = 'vitem_current';
	var t=o.offsetTop-jar.scrollTop;
	if (t<0 | t>jar.style.height) {
		jar.scrollTop = o.offsetTop;
	}
	var player = document.getElementById('player_object');
	try{
		player.SetVariable("ID", vid);
		player.SetVariable("video_info_loaded", "false");
		player.TGotoFrame("/",102);
		player.TPlay("/");
	} catch (e) {
		var t = player.innerHTML;
		do {
			t = t.replace(prevItemId,vid);
		} while (t.indexOf(prevItemId)!=-1);
		do {
			t = t.replace('="bigfb=yes','="autoStart=yes&bigfb=yes');
		} while (t.indexOf('="bigfb=yes')!=-1);
		player.innerHTML=t;
	}
	
	prevItemId=vid;
	cur_index=index;
}
function player_object_DoFSCommand(command, args) {
	var player = document.getElementById('player_object');
	if (command == "status_changed")
		if (args == "over") {
			var next = document.getElementsByTagName("li")[cur_index+1];
			playItem(next.id,cur_index+1);
		}
}
function loadmore(){
	if (document.getElementById("loadmore").innerHTML != 'Loading') {
		xmlTopNotice=GetXmlHttpObject();
		if (xmlTopNotice==null){alert('You need AJAX!');return;}
		var url="longer_list.php?id="+listID+"&page="+(1+page);
		xmlTopNotice.onreadystatechange=getDatas;
		xmlTopNotice.open("GET",url,true);
		xmlTopNotice.send(null);
		document.getElementById("loadmore").innerHTML = 'Loading';
	}
}
function getDatas(){
	if (xmlTopNotice.readyState==4){
		var r = xmlTopNotice.responseText;
		document.getElementById("loadmore").innerHTML = '载入更多项';
		if (r.length < 2) {
			alert("ERROR! Please retry");
		} else if (r=="OVER") {
			document.getElementById("loadmore").style.display='none';
		} else {
			document.getElementById("video_playlist_items").innerHTML+=r;
			page++;
		}
		xmlTopNotice = null;
	}
}
function GetXmlHttpObject(){
	var xmlTopNotice=null;
	try {xmlTopNotice=new XMLHttpRequest();} catch (e) {try {xmlTopNotice=new ActiveXObject("Msxml2.XMLHTTP");} catch (e)	{xmlTopNotice=new ActiveXObject("Microsoft.XMLHTTP");}}return xmlTopNotice;
}