var isBig = 0;
var xmlTopNotice;
var obj2translate;
google.load("language", "1");
function bos() {
	var blank1 = document.getElementById('falseVideoField');
	var blank2 = document.getElementById('spacer1');
	var videof = document.getElementById('trueVideoField');
	if (isBig==1) {
		videof.style.height = 391;
		videof.style.width = 640;
		videof.style.left = 8;
		blank1.style.height = 391;
		blank2.style.height = 1;
		isBig=0;
	} else {
		videof.style.height = "80%";
		videof.style.width = "80%";
		videof.style.left = "10%";
		blank1.style.height = 1;
		blank2.style.height = "85%";
		isBig=1;
	}
}
function jumpcommentpage(page){
xmlTopNotice=GetXmlHttpObject();
if (xmlTopNotice==null){document.getElementById("comments_jar").innerHTML='You need AJAX!';return;}
var url="comments.php?id="+videoID+"&page="+page;
xmlTopNotice.onreadystatechange=getDatas;
xmlTopNotice.open("GET",url,true);
xmlTopNotice.send(null);
document.getElementById("comments_jar").innerHTML='Loading comments...';
}
function translatecomment(id){
obj2translate = document.getElementById("comment_"+id);
google.language.translate(obj2translate.innerText, "", "zh-CN", function(result) {
  if (!result.error) {
    obj2translate.innerHTML = result.translation;
  } else {
    alert('Can Not translate. Please try again.');
  }
});
}
function getDatas(){
if (xmlTopNotice.readyState==4){document.getElementById("comments_jar").innerHTML=xmlTopNotice.responseText;}
}
function GetXmlHttpObject(){
var xmlTopNotice=null;try {xmlTopNotice=new XMLHttpRequest();} catch (e) {try {xmlTopNotice=new ActiveXObject("Msxml2.XMLHTTP");} catch (e)	{xmlTopNotice=new ActiveXObject("Microsoft.XMLHTTP");}}return xmlTopNotice;
}