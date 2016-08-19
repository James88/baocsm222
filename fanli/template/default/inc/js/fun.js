function postForm(action,input){
	var postForm = document.createElement("form");
    postForm.method="post" ;
    postForm.action = action ;
	var k;
    for(k in input){
		if(input[k]!=''){
			var htmlInput = document.createElement("input");
			htmlInput.setAttribute("name", k) ;
            htmlInput.setAttribute("value", input[k]);
            postForm.appendChild(htmlInput) ;
		}
	}
	document.body.appendChild(postForm) ;
    postForm.submit() ;
    document.body.removeChild(postForm) ;
}

function arr2param(arr){
	var param='';
	var k;
    for(k in arr){
		if(arr[k]!=''){
		    param+='&'+k+'='+arr[k];
		}
	}
	return param;
}

function AddFavorite(sURL, sTitle){
 try{
  window.external.addFavorite(sURL, sTitle);
  }
 catch (e){
  try{
   window.sidebar.addPanel(sTitle, sURL, "");
   }
  catch (e)
  {
   alert("加入收藏失败，您的浏览器不允许，请使用Ctrl+D进行添加");
  }
 }
}

function showLogin()
{
    $('#menu_weibo_login').toggle();
}

function showHide(id)
{
    $('#'+id).toggle();
}

function goodsShoucang($t){
	if(DDUID==0){
		alert('登陆后才能收藏！');
		window.location=u('user','login')+'&url='+encodeURIComponent(window.location.href);
	}
	var data_id=$t.attr('data_id');
	$.ajax({
		url: SITEURL+u('ajax','shoucang'),
		data:{id:data_id},
		dataType:'jsonp',
		jsonp:"callback",
		success: function(data){
			if(data.s==0){
				alert(data.r);
				window.location=u('user','login')+'&url='+encodeURIComponent(window.location.href);
			}
			else if(data.s==1){ 
				alert(data.r);
				if(data.quxiao==1){
					$t.find('.like-ico').removeClass('l-active');
					$t.attr('title','加入收藏');
				}else{
					$t.find('.like-ico').addClass('l-active');
					$t.attr('title','已收藏');
				}
			}
		 }
	});
}

function LazyLoad($t){
	$t=$t||$('.list-good');
	var $objImg=$t.find("img.lazy");
	$objImg.lazyload({
		threshold:20,
		failure_limit:50
	});
	
	$t.find('.my-like').click(function(){
		goodsShoucang($(this));
	});
	
	var $cellObj=$t.find(".erweima");
	if($cellObj){
		$cellObj.jumpBox({  
			LightBox:'show',
			height:220,
			width:380,
			defaultContain:1,
			jsCode:'if(shoujiBuy($(this))==false){var jumpBoxStop=1;}'
		});
	}
}

function shoujiBuy($t){
	var id=$t.attr('id');
	if(DDUID==0){
		alert('请先登录');
		window.location.href=SITEURL+'index.php?mod=user&act=login&from='+urlencode(location.href);
		return false;
	}	
	var url=$t.attr('url');
	var youhui=$t.attr('youhui');
	var $jumpbox=$('#jumpbox');
	$jumpbox.find('.erweima-pic').attr('src','images/blank.png');
	$jumpbox.find('.youhui').html('——');
	$jumpbox.find('.url').attr('href','');
	$jumpbox.find('.erweima-pic').attr('src',erweima_api(id));
	$jumpbox.find('.youhui').html(youhui);
	$jumpbox.find('.url').attr('href',url);
}