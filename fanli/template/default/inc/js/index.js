// JavaScript Document
$(function(){
	$("#KinSlideshow").KinSlideshow({
		btn:{btn_fontHoverColor:"#FFFFFF"},
		titleFont:{TitleFont_size:14,TitleFont_color:"#FFFFFF"},
		titleBar:{titleBar_height:30}
	});
	
	ajaxMall(0,20);
	
	$('.shangjia .fenlei2 ul li a').hover(function(){
        $('.shangjia .fenlei2 ul li').removeClass('fontL');
		$(this).parent('li').addClass('fontL');
		var cid=$(this).parent('li').attr('cid');
		ajaxMall(cid,20);
	});
	
	$('.leimu .kuang01').keyup(function(){
	    var val=$(this).val();
		if(val!=''){
		    ajaxMall(val,20);
		}
	});
	dd=setTimeout("shengSlider=new slider({id:'gundong'});",3000);
	
	$(".biaoti").each(function(){
    	$(this).find('li:last').attr('id','fontf');
 	});
});

function aa(){
	if("undefined" != typeof shengSlider){
		clearInterval(dd);
		if(shengSlider.stop==1){
			dd=setTimeout("shengSlider=new slider({id:'gundong'});",3000);
		}
	}
}

function bb(){
	if("undefined" != typeof shengSlider){
		shengSlider.stop=1;
	}
	else{
	    shengSlider = new Object();
		shengSlider.stop=1;
	}
}

function H$(i) {return document.getElementById(i)}
function H$$(c, p) {return p.getElementsByTagName(c)}
var slider = function () {
	function inits (o) {
		this.id = o.id;
		this.at = o.auto ? o.auto : 3;
		this.o = 0;
		this.stop=o.stop?o.stop:0;
		this.pos();
	}
	inits.prototype = {
		pos : function () {
			clearInterval(this.__b);
			if(this.stop==1) return false;
			this.o = 0;
			var el = H$(this.id), li = H$$('li', el), l = li.length;
			var _t = li[l-1].offsetHeight;
			var cl = li[l-1].cloneNode(true);
			cl.style.opacity = 0; cl.style.filter = 'alpha(opacity=0)';
			el.insertBefore(cl, el.firstChild);
			el.style.top = -_t + 'px';
			this.anim();
		},
		anim : function () {
			var _this = this;
			this.__a = setInterval(function(){_this.animH()}, 20);
		},
		animH : function () {
			var _t = parseInt(H$(this.id).style.top), _this = this;
			if (_t >= -1) {
				clearInterval(this.__a);
				H$(this.id).style.top = 0;
				var list = H$$('li',H$(this.id));
				H$(this.id).removeChild(list[list.length-1]);
				this.__c = setInterval(function(){_this.animO()}, 20);
				//this.auto();
			}else {
				var __t = Math.abs(_t) - Math.ceil(Math.abs(_t)*.07);
				H$(this.id).style.top = -__t + 'px';
			}
		},
		animO : function () {
			this.o += 20;
			if (this.o == 100) {
				clearInterval(this.__c);
				H$$('li',H$(this.id))[0].style.opacity = 1;
				H$$('li',H$(this.id))[0].style.filter = 'alpha(opacity=100)';
				this.auto();
			}else {
				H$$('li',H$(this.id))[0].style.opacity = this.o/100;
				H$$('li',H$(this.id))[0].style.filter = 'alpha(opacity='+this.o+')';
			}
		},
		auto : function () {
			var _this = this;
			this.__b = setInterval(function(){_this.pos()}, this.at*1000);
		}
   }
	return inits;
}();