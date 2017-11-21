//Cross platform support for the total height of the document
function getDocHeight() {
	var d=document, b = d.body, e=d.documentElement;
	return Math.max(
	b.scrollHeight, e.scrollHeight,	b.offsetHeight, e.offsetHeight,	b.clientHeight, e.clientHeight
	);
}

// Cross platform support for the inner height of the client window
function getWinHeight() {
	var w=window, d=document, e=d.documentElement,g=d.getElementsByTagName('body')[0],
	y = w.innerHeight || e.clientHeight || g.clientHeight;
	return y;
}

// Cross platform support to get the Y coordinate of the top of the visible part of the page
function getScrollPosition() {
	var w=window, d=document, e=d.documentElement;
	var scrollposition = (w.pageYOffset || e.scrollTop)  - (e.clientTop || 0);
	return scrollposition;
}
// prevent the default action of a form or link tag with browser support for
// IE8, IE9+ and other browsers
function stopDefaultAction(e) {
	if(e.preventDefault) {
		e.preventDefault();
	} else {
		e.returnValue=false;
	}
}

function createXHR() {
	if (window.XMLHttpRequest) {
		return new XMLHttpRequest();
	}
	else if(window.ActiveXObject) {
		return new ActiveXObject("Microsoft.XMLHTTP");
	}
}
// Cross browser compatible event target
function getTargetElement(e) {
	var targetelement=null;
	targetelement=(e.target || e.srcElement || e.toElement)
	return targetelement;
}
// Set Cookie
function setCookie(name,value,days) {
	var expires = "";
	if (days) {
		var thedate = new Date();
		thedate.setTime(thedate.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+thedate.toUTCString();
	}
	document.cookie = name+"="+escape(value)+((days==null) ? "" : expires+"; path=/OneStopStoveShop/");
}

// Get cookie
function getCookie(c_name) {
	if (document.cookie.length>0) {
		c_start=document.cookie.indexOf(c_name+"=");
		if (c_start!=-1) {
			c_start=c_start+c_name.length+1;
			c_end=document.cookie.indexOf(";",c_start);
			if (c_end==-1) { c_end=document.cookie.length; }
			return unescape(document.cookie.substring(c_start,c_end));
		}
	}
	return null;
}

function getWinWidth() {
	var w=window, d=document, e=d.documentElement,g=d.getElementsByTagName('body')[0],
	x = w.innerWidth || e.clientWidth || g.clientWidth;
	return x;
}