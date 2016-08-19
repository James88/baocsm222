// JavaScript Document
function sousuo(){
	var v=$('#keywords').val()
	if(v==''){
		alert('请输入搜索内容');
		return false;
	}
	regTaobaoUrl = /(.*\.?taobao.com(\/|$))|(.*\.?tmall.com(\/|$))/i;
	if(v.match(regTaobaoUrl) || (!isNaN(v) && v.length>=8 && v.length<=15)){
		$('#m').val('view');
	}
}

function sousuo2(){
	var v=$('#keywords2').val()
	if(v==''){
		alert('请输入搜索内容');
		return false;
	}
	regTaobaoUrl = /(.*\.?taobao.com(\/|$))|(.*\.?tmall.com(\/|$))/i;
	if(v.match(regTaobaoUrl) || (!isNaN(v) && v.length>=8 && v.length<=15)){
		$('#m2').val('view');
	}
}

function toastOpen(a){
	alert(a);
}

function checkForm($this,cb){
	var $input={};	
	var word='';
	var status=true;
	var ddPatternArr={'email':/^[-_A-Za-z0-9\.]+@([_A-Za-z0-9]+\.)+[A-Za-z0-9]{2,3}$/,'int':/^[0-9]+$/,'num':/^[0-9]+(.[0-9]{2})?$/,'float':/^[0-9]+\.?[0-9]+$/,'mobile':/^1\d{10}$/,'alipay':'email|mobile'};
	var input={};
	var $form=$this;
	
	function tip(word2){
		if(word!=''){
			toastOpen(word);
		}
		else{
			toastOpen(word2);
		}
		$input[0].focus();
		status=false;
		return false;
	}
	
	function getAttr(name){
		return $input.attr(name);
	}
	
	$this.find('input').each(function(){
		if(status==false){ //return false不能退出循环，所以增加了这个判断（可能是jqmobi不行吧，jquery没测试）
			return false;
		}
		
		$input=$(this);
		
		if(getAttr('type')=='submit'){
			return false;
		}
		
		word=getAttr('word');
		if(word==null){
			word='';
		}
		var str=$(this).val();
		if(getAttr('dd-required')!=null && str==''){
			return tip('此项必填');
			return false;
		}
		
		if(getAttr('dd-equal')!=null){
			if(str!=$('#'+getAttr('dd-equal')).val()){
				return tip('与要求项不相符');
			}
		}

		if(getAttr('dd-max')!=null){
			var ddMax=parseFloat($(this).attr('dd-max'));
			str=parseFloat(str);
			if(str>ddMax){
				return tip('数值错误');
			}
		}
		
		if(getAttr('dd-min')!=null){
			var ddMin=parseFloat(getAttr('dd-min'));
			str=parseFloat(str);
			if(str<ddMin){
				return tip('数值错误');
			}
		}
		
		if(getAttr('dd-maxl')!=null){
			var ddMaxl=getAttr('dd-maxl');
			var l=str.length;
			if(l>ddMaxl){
				return tip('长度错误');
			}
		}
		
		if(getAttr('dd-minl')!=null){
			var ddMinl=getAttr('dd-minl');
			var l=str.length;
			if(l<ddMinl){
				return tip('长度错误');
			}
		}
		var ddType=getAttr('dd-type');
		if(ddType!='' && ddType!=null){
			if(typeof ddPatternArr[ddType]!='undefined'){
				if(typeof ddPatternArr[ddType]=='string'){
					var regArr=ddPatternArr[ddType].split('|');
					var l=regArr.length;
					var i=0;
					for(var i=0;i<l;i++){
						if(ddPatternArr[regArr[i]].test(str)==true){
							i++;
						}
					}
					if(i==0){
						return tip('此项格式错误');
					}
				}
				else if(ddPatternArr[ddType].test(str)==false){
					return tip('此项格式错误');
				}
				
			}
		}
		if(getAttr('dd-pattern')!=null && getAttr('dd-pattern')!=''){
			var reg = eval($(this).attr('dd-pattern'));
			if(reg.test(str)==false){
				return tip('此项格式错误');
			}
		}
		
		var name=getAttr('name');
		input[name]=str;
	});
	if(status==true){
		cb(input,$form);
	}
	return false;
}

function ddSerialize(obj){
	var s='';
	for(var i in obj){
		s+='&'+i+'='+encodeURIComponent(obj[i]);
	}
	return s;
}

function ddJoin(url,p){
	p=p||'';
	if(typeof p=='object'){
		p=ddSerialize(p);
	}
	if(url.indexOf('?')<0){
		p=p.replace('&','?');
	}
	url+=p;
	return url;
}

window.alert = function(text,cb) {
	var time=1500;
	$('body').append('<div style="position: fixed;	top:0;	left:0;	width:100%;	height:100%;background:rgba(0, 0, 0, 0.7);	display:none;z-index:20000;" id="mcover" onClick="document.getElementById(\'mcover\').style.display=\'\';"><div style="z-index:20001; margin:auto; text-align:center;" class="rongqi"><span style="background:#666; padding:0.5em 1em; color:#FFF;border-radius:0.5em;">'+text+'</span></div></div>');
	var h=$(window).height();
	$('#mcover').show().find('.rongqi').css('margin-top',(h*0.4)+'px');
	setTimeout(function(){
		document.getElementById('mcover').style.display='none';
		$('#mcover').remove();
		if(cb && typeof cb == 'function'){
			cb();
		}
		else if(cb){
			window.location.href=cb;
		}
	},time);
}

function imagesLoad(url,t){
	if(t.getAttribute('onloadover')==1){
		return false;
	}
	var img=new Image();
    img.src=url;
	if (img.complete) {
		t.setAttribute('src',url);
	} else {
		img.onload = function () {
			t.setAttribute('src',url);
			img.onload = null;
			t.setAttribute('onloadover',1);
		}
	}
}

function log(str){
	console.log(str);
}

function　time(type){
	type=type||1;
	if(type==1){
		var t=Date.parse(new Date())/1000;
	}
	else{
		var t=Date.parse(new Date());
	}
	return t;
}

String.prototype.Trim = function() 
{ 
    return this.replace(/(^\s*)|(\s*$)/g, ""); 
} 

function setCookie(name, value,expiredays) {
	expiredays=expiredays||3 * 24 * 60 * 60 * 1000;
	var exp = new Date();
	exp.setTime(exp.getTime() + expiredays); //3天过期
	var s = name + "=" + encodeURIComponent(value) + ";expires=" + exp.toGMTString()+";path=/";
	document.cookie=s;
}
//取得cookie
function getCookie(name){
	
    var str=document.cookie.split(";")
    for(var i=0;i<str.length;i++){
        var str2=str[i].split("=");
		str2[0]=str2[0].Trim();
        if(str2[0]==name){
		    return unescape(str2[1]);
	    }
    }
}
//删除cookie
function delCookie(name){
 var date=new Date();
 date.setTime(date.getTime()-10000);
 document.cookie=name+"=n;expire="+date.toGMTString();
}

/*获取模板函数*/
function getTpl(_function){
	var tpl=_function.toString();
	tpl=tpl.replace(/function\s*\w+\s*\(\)\s*{\/\*/,'').replace(/\*\/;}$/,'');
	return tpl;
	//alert(tpl.match(/^[\w]+\snav_tpl\(\)\{\s+\/\*([\w\s*\/\\<>'"=#;:$.()]+)\*\/\s+\}$/i)[1]);
}

/*循环对象模板*/
function getTplObj(tplName,obj){
	var tpl=getTpl(tplName);
	var _tpl='';
	var str='';
	
	if(typeof obj[0]=='undefined'){
		_tpl=tpl;
		for(var j in obj){
			var pattern = "\{\\$"+j+"\}";
			var reg = new RegExp(pattern, "g");
			_tpl=_tpl.replace(reg,obj[j]);
		}
		return _tpl;
	}
	else{
		for(i in obj){
			_tpl=tpl;
			for(var j in obj[i]){
				var pattern = "\{\\$"+j+"\}";
				var reg = new RegExp(pattern, "g");
				_tpl=_tpl.replace(reg,obj[i][j]);
			}
			str+=_tpl;
		}
		return str;
	}
}

$.ajaxSetup ({ 
    cache: false //关闭AJAX相应的缓存 
});

function ddAlert(tip,url){
	url=url||'';
	alert(tip);
	if(url!=''){
		if(typeof url=='function'){
			setTimeout(function(){url();},1000);
		}
		else{
			setTimeout(function(){window.location.href=url;},1000);
		}
	}
}