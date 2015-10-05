function searchfilter(a,b) {
	document.getElementById(b).value=encodeURI(document.getElementById(a).value).split('').reverse().join('');
}