$(function(){
	var word = '';
	var timeoutid = null;
	dataUrl="http://suggest.taobao.com/sug?q=";
	var topOffset=15;
	var leftOffset=-3;
	inputId='s-txt'; //输入框ID
	$inputId=$('#'+inputId);
	var left=$inputId.offset().left+leftOffset;
	var top=$inputId.height()+$inputId.offset().top+topOffset;
	width=363;//$inputId.width();  //搜索框长度
	taobaokeytips='taobaokeytips'; //提示层id
	$inputId.attr('autocomplete','off');
	$("body").append('<div id="'+taobaokeytips+'"></div>'); //添加容器
    $('#'+taobaokeytips).css('left',left+'px').css('top',top+'px').css('width',width+'px');
	var txt=$("#s-txt").attr('placeholder');
	$("#s-txt").attr('value',txt);
    $('#s-txt').click(function(){
		var q=$("#s-txt").val();
		if(q==txt){
			$("#s-txt").attr('value','');
		}
		if(q!=txt && q!=''){
			autocomplete();
		}
	});
   /*$('body').keydown(function(){
	    if(event.keyCode==13){
		    if($('#'+taobaokeytips).css('display')=='block'){
				return false;
			}
			else{
			    return true;
			}
		}
	});*/
	$('#s-txt').blur(function(){
		var q=$("#s-txt").val();
		if(q==''){
			$("#s-txt").attr('value',txt);
		}
	});
	$("#"+inputId).keyup(function(event){
		var mod=$('#mod').val();
		var act=$('#act').val();
		var neword = $(this).attr("value");
		var word=inArray(neword,noWordArr);
		if(word!=''){
			return false;
		}
		
		if(neword=='' || neword.indexOf("http://") >= 0 ){      
    		return false;  
		} 

		var myEvent = event || window.event; 
		var keyCode = myEvent.keyCode;              //获得键值
		switch(keyCode){
			case 38 : //按了上键  
				if($("#"+taobaokeytips).css("display") == "block"){       
					var arr = $("#"+taobaokeytips+" li").filter(".current");
					if(arr.length != 0){
						var index = $("#"+taobaokeytips+" li").index(arr[0]);
						var shangcheng_id = $("#"+taobaokeytips+" li").eq(index-1).attr("id");
						if(shangcheng_id>0){
							document.getElementById("mod").value = 'mall'; 
							document.getElementById("act").value = 'view';
							document.getElementById("id").value = shangcheng_id; 
							document.formname.action = 'index.php';   
						}else{
							document.formname.action = 'index.php'; 
							document.getElementById("mod").value = $("#"+taobaokeytips+" li").eq(index-1).attr("mod");
							document.getElementById("act").value = $("#"+taobaokeytips+" li").eq(index-1).attr("act");
						}
						switch(index){
							case 0:
								$("#"+taobaokeytips+" li").eq(index).removeClass("current");
							break;
							default:
								$("#"+taobaokeytips+" li").eq(index).removeClass("current");
								
								$("#"+taobaokeytips+" li").eq(index-1).addClass("current");	
						}
					}
					else{
						var shangcheng_id = $("#"+taobaokeytips+" li").eq(length-1).attr("id");
						if(shangcheng_id>0){
							document.getElementById("mod").value = 'mall'; 
							document.getElementById("act").value = 'view';
							document.getElementById("id").value = shangcheng_id; 
							document.formname.action = 'index.php';
						}else{
							document.formname.action = 'index.php'; 
							document.getElementById("mod").value = $("#"+taobaokeytips+" li").eq(length-1).attr("mod");
							document.getElementById("act").value = $("#"+taobaokeytips+" li").eq(length-1).attr("act");
						}
						$("#"+taobaokeytips+" li").eq($("#"+taobaokeytips+" li").length-1).addClass("current");
					}
				}else{autocomplete()};
				break;
			case 40 : //按了下键
				
				if($("#"+taobaokeytips).css("display") == "block"){ 
					var arr = $("#"+taobaokeytips+" li").filter(".current");
					if(arr.length != 0){
						var index = $("#"+taobaokeytips+" li").index(arr[0]);
						var shangcheng_id = $("#"+taobaokeytips+" li").eq(index+1).attr("id");
						if(shangcheng_id>0){
							document.getElementById("mod").value = 'mall'; 
							document.getElementById("act").value = 'view';
							document.getElementById("id").value = shangcheng_id;
							document.formname.action = 'index.php';   
						}else{
							document.formname.action = 'index.php'; 
							document.getElementById("mod").value = $("#"+taobaokeytips+" li").eq(index+1).attr("mod");
							document.getElementById("act").value = $("#"+taobaokeytips+" li").eq(index+1).attr("act");
						}
						switch(index){
							case $("#"+taobaokeytips+" li").length-1:
								
								$("#"+taobaokeytips+" li").eq(index).removeClass("current");
								
							break;
							default:
								$("#"+taobaokeytips+" li").eq(index).removeClass("current");
								
								$("#"+taobaokeytips+" li").eq(index+1).addClass("current");	
						}
					}
					else{
						var shangcheng_id = $("#"+taobaokeytips+" li").eq(0).attr("id");
						if(shangcheng_id>0){
							document.getElementById("mod").value = 'mall'; 
							document.getElementById("act").value = 'view';
							document.getElementById("id").value = shangcheng_id;
							document.formname.action = 'index.php';   
						}else{
							document.formname.action = 'index.php'; 
							document.getElementById("mod").value = $("#"+taobaokeytips+" li").eq(0).attr("mod");
							document.getElementById("act").value = $("#"+taobaokeytips+" li").eq(0).attr("act");
						}
						$("#"+taobaokeytips+" li").eq(0).addClass("current");
					}
				} else { autocomplete() };
				
				break;
			case 13 : //按了回车
				if($('#'+taobaokeytips).css("display") == "block"){ 
					var arr = $("#"+taobaokeytips+" li").filter(".current");
					arr.click();
					if(arr.length != 0){
						var index = $("#"+taobaokeytips+" li").index(arr[0]);
						$('#'+taobaokeytips).css("display","none");
					};
				}else{if(neword != word)autocomplete()}
				break;
			default:
				if (neword != "" && neword != word) {
					clearTimeout(timeoutid); //取消上次未完成的延时操作					
					//500ms后执行，执行一次
					timeoutid = setTimeout(function(){
						callback();
					},300)
				} else { $('#'+taobaokeytips).css("display","none");word = neword; }
			}
	})
	//---------------------------------------------------------------------------------------------
	
	$("body").bind("click",function(event){     var element = event.target;    if(element.id != 's-txt'){ setTimeout(function(){$('#'+taobaokeytips).css("display","none")},100)}})
	
	function autocomplete(){
		callback();
		/*var neword = $("#"+inputId).attr("value");
		var url = dataUrl + neword + "&code=utf-8&callback=callback"
		var s = document.createElement("script"); 
		s.setAttribute("src", url);
		s.setAttribute("id", "GetOrder");
		document.getElementsByTagName("head")[0].appendChild(s);
		word = neword;
		var children = document.getElementById("GetOrder");
		var parent = children.parentNode;
		parent.removeChild(children);*/
	}
});

function callback(a){
	var key = $('#s-txt').val();
	var str = "";
	var url = '';
	$.ajax({
		url: SITEURL+u('ajax','callback_search'),
		data:{'q':key},
		dataType:'jsonp',
		jsonp:"callback",
		success: function(data){
			key_1 = '【<b style="color:#F60;font-family:宋体; display:inline-block; max-width:225px; line-height:13px; overflow: hidden;white-space: nowrap;text-overflow: ellipsis;">'+key+'</b>】';
			for(var i in data){	
				data[i]['title'] = '<span style=\"color:#F60\">'+data[i]['title']+'</span>';
				str += "<li><a href='index.php?mod=mall&act=view&id="+data[i]['id']+"' target='_blank'><span style='vertical-align:middle;float:left;width:200px;padding-left:20px'><img src=\""+data[i]['img']+"\" height='20px' style='line-height:30px;vertical-align:middle;'><span style='margin-left:10px;vertical-align:middle;'>" + data[i]['title'] + "</span></span><span style='vertical-align:middle;color:#F60;float:right;width:100px'>最高返利"+data[i]['fan']+"</span><div style='clear:both;'></div></li>";
			}
			for(var k in sousuoxiala){
				str += "<li mod='"+sousuoxiala[k][0]+"' act='"+sousuoxiala[k][1]+"' style='font-family:宋体;'><a style='margin-left:10px; font-family:宋体;text-decoration:none;display:inline-block;' href='index.php?mod="+sousuoxiala[k][0]+"&act="+sousuoxiala[k][1]+"&q="+encodeURIComponent(key)+"' target='_blank'> 搜" + key_1 + " "+sousuoxiala[k][2]+"</a></li>";
			}
			//str += "<li onclick=\"javascript:window.location.href='index.php?mod=mall&act=goods&q="+encodeURIComponent(key)+"'\" class='li_border'><a href=index.php?mod=mall&act=goods&q="+encodeURIComponent(k target="" style='margin-left:10px'> 搜" + key_1 + " 全网比价</a></li>";
			//	str += "<li onclick=\"javascript:window.location.href='index.php?mod=paipai&act=list&q="+encodeURIComponent(key)+"'\" class='li_border'><a style='margin-left:10px'> 搜" + key_1  + " 相关拍拍宝贝</a></li>";
			//	str += "<div id='s8_tao'><li onclick=\"javascript:window.location.href='index.php?mod=tao&act=view&q="+encodeURIComponent(key)+"'\" class='li_border'><a style='margin-left:10px'> 搜" + key_1  + " 相关淘宝宝贝</a></li></div>";
			$('#'+taobaokeytips).html('<ul>'+str+'</ul>');
			$('#'+taobaokeytips).show();
		}
	});
}