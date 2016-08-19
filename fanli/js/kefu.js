//<![CDATA[
var tips;
var theTop = 145
/*这是默认高度,越大越往下*/
;
var old = theTop;
function initFloatTips() {
    tips = document.getElementById('divQQbox');
    moveTips();
};
function moveTips() {
    var tt = 50;
    if (window.innerHeight) {
        pos = window.pageYOffset

    } else if (document.documentElement && document.documentElement.scrollTop) {
        pos = document.documentElement.scrollTop
    } else if (document.body) {
        pos = document.body.scrollTop;
    }
    pos = pos - tips.offsetTop + theTop;
    pos = tips.offsetTop + pos / 10;
    if (pos < theTop) pos = theTop;
    if (pos != old) {
        tips.style.top = pos + "px";
        tt = 10;
        //alert(tips.style.top);
    }
    old = pos;
    setTimeout(moveTips, tt);
}
//!]]>
initFloatTips();
function OnlineOver() {
    document.getElementById("divMenu").style.display = "none";
    document.getElementById("divOnline").style.display = "block";
    document.getElementById("divQQbox").style.width = "145px";
}

function OnlineOut() {
    document.getElementById("divMenu").style.display = "block";
    document.getElementById("divOnline").style.display = "none";
}

if (typeof(HTMLElement) != "undefined") //给firefox定义contains()方法，ie下不起作用
{
    HTMLElement.prototype.contains = function(obj) {
        while (obj != null && typeof(obj.tagName) != "undefind") { //通过循环对比来判断是不是obj的父元素
            　　　　
            if (obj == this) return true;　　　　obj = obj.parentNode;　　
        }
        return false;
    };
}
function hideMsgBox(theEvent) { //theEvent用来传入事件，Firefox的方式
    if (theEvent) {　
        var browser = navigator.userAgent; //取得浏览器属性
        if (browser.indexOf("Firefox")>0 || browser.indexOf("Chrome")>0){
	　　 	if (document.getElementById('divOnline').contains(theEvent.relatedTarget)) {
	　　 		return; 
			} 
		}
		else if (browser.indexOf("MSIE")>0){
			if (document.getElementById('divOnline').contains(event.toElement)) { 
				return; 
			}
		}
    }
    /*要执行的操作*/
    document.getElementById("divMenu").style.display = "block";
    document.getElementById("divOnline").style.display = "none";
}