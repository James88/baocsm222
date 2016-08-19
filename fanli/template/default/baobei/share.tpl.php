<?php
$commentDefaultVal='说说你对这件宝贝的评价吧';
$num=$webset['baobei']['word_num'];
$type=$duoduo->select_all('type','*',"tag='goods' order by sort=0 asc,sort asc,id desc limit 8");
foreach($type as $k=>$vo){
	$cat_arrs[$k]['url']=u('baobei','list',array('cid'=>$vo['id']));
	$cat_arrs[$k]['title']=$vo['title'];
	$cat_arrs[$k]['cid']=$vo['id'];
}
?>
<script src="js/jquery.qqFace.js"></script>
<script language="javascript">
commentDefaultVal='<?=$commentDefaultVal?>';
num=<?=$num?>;
var nick='';
var tao_id='';
var image='';
var title='';
var price='';
var shop_title='';
var user_id='';
var logo='';
regTaobaoUrl = /(.*\.?taobao.com(\/|$))|(.*\.?tmall.com(\/|$))/i;
function getTaoItem(url){
    if(url==''){
		alert('网址不能为空！');
		return false;
	}
	if (!url.match(regTaobaoUrl)){
		alert('这不是一个淘宝网址！');
		return false;
	}

	$('#subShare').attr('disabled',false);
}

function uploadCall(divId,imgUrl){
	$("#img_show").attr('src',imgUrl);
}

$(function(){
	$('#subShare').attr('disabled',true);
	<?php if(MOD=='user' && ACT=='tradelist'){?> //晒单
	$('.shai').jumpBox({  
		id:'jumpbox_share',
		height:300,
		width:590,
		defaultContain:1,
		button:1,
		jsCode2:"var $parentDiv=$(this).parent('td');taoIid=$parentDiv.attr('iid');title=$parentDiv.attr('trade_title');taoUrl='http://item.taobao.com/item.htm?id='+taoIid;$('#taoIid').val(taoIid);$('#tao_url').val(taoUrl);$('#title').html(title);getTaoItem(taoUrl);trade_id=$parentDiv.attr('trade_id');"
    });
	$('.reshai').jumpBox({  
		id:'jumpbox_share',
		height:320,
		width:590,
		defaultContain:1,
		button:1,
		jsCode2:"var $parentDiv=$(this).parent('td');taoIid=$parentDiv.attr('iid');title=$parentDiv.attr('trade_title');taoUrl='http://item.taobao.com/item.htm?id='+taoIid;$('#taoIid').val(taoIid);$('#tao_url').val(taoUrl);$('#title').html(title);getTaoItem(taoUrl);trade_id=$parentDiv.attr('trade_id');userimg=$parentDiv.attr('userimg');$('#userimg').val(userimg);$('#img_show').attr('src',userimg);reason=$parentDiv.attr('reason');$('#reason').html(reason);comment=$parentDiv.attr('comment');$('#comment').html(comment);cid=$parentDiv.attr('cid');$('#radio'+cid).attr('checked','ture');"
	});
	<?php }else{?>  //直接分享
    $('#startShare').jumpBox({  
		id:'jumpbox_share',
		height:300,
		width:590,
		defaultContain:1,
		button:1,
		jsCode2:"$('#shareContain .funtip .taourl').click();"
    });
	<?php }?>
	$('#openem').qqFace({
		id : 'facebox1', //表情盒子的ID
		assign:'comment', //给那个控件赋值
		path:'images/face/',
		num:30
	});
	$('#shareContain .funtip .taourl').click(function(){
	    $('#jiantou').css('left','118px');
		$('#tishi').html('在此直接粘贴宝贝的链接地址');
		$('#dopic').show();
		$('#shareContain #tao_url').focus()
	});
	$('#shareContain #dopic #get_tao_img').click(function(){
	    var url=$('#tao_url').val();
		getTaoItem(url);
	});
	$('#comment').bind('focus keyup input paste',function(){  //采用几个事件来触发（已增加鼠标粘贴事件）   
	     $('#num').text(num-$(this).attr("value").length)  //获取评论框字符长度并添加到ID="num"元素上  
	});
	$('#shaiForm').submit(function(){
		var comment=$('#comment').val();
		var cid = $("input[name='shaicat'][type='radio']:checked").val();
		var num=parseInt($('#num').text());
		var url=$('#tao_url').val();
		var userimg=$('#userimg').val();
		if(typeof cid=='undefined'){
		    alert(errorArr[25]);
			return false;
		}
		else if(num<0){
		    alert(errorArr[26]);
			$('#comment').focus();
			return false;
		}
		else if(comment=='' || comment==commentDefaultVal){
		    alert(errorArr[27]);
			$('#comment').focus();
			return false;
		}
		else{
		    $('#subShare').attr('disabled',true);
			if(typeof trade_id=='undefined'){
			    trade_id=0;
			}
			$.ajax({
	            url: "<?=u('ajax','save_share')?>",
		        data:{url:url,trade_id:trade_id,userimg:userimg,comment:comment,cid:cid},
		        dataType:'jsonp',
				jsonp:"callback",
		        success: function(data){
			        if(data.s==0){
						$('#subShare').attr('disabled',false);
			            alert(errorArr[data.id]);
			        }
			        else if(data.s==1){
			            alert('您好，已经成功发布了<?php if($webset['baobei']['user_show']==1){?>，请等待管理员审核，审核后才能正常显示<?php }?>');
					    location.replace(location.href);//closeShare();
			        }
		         }
	        });
			return false;
		}
	});
	
	$('#tao_url').blur(function(){
		var url=$('#tao_url').val();
		getTaoItem(url);
	});
});
function openpic(url,name,w,h)
{
    window.open(url,name,"top=100,left=400,width=" + w + ",height=" + h + ",toolbar=no,menubar=no,scrollbars=yes,resizable=no,location=no,status=no");
}
</script>
<div class="LightBox" id="LightBox"></div><div id="jumpbox_share" show="0" class="jumpbox"><div class="top_left"></div><div class="top_center"></div><div class="top_right"></div><div class="middle_left"></div><div class="middle_center"><div class="close"><a></a></div><p style="height:22px"></p><div class="contain">
<div id="shareHtml">
<div id="shareContain">
<form id="shaiForm">

	<div class="taourl">
    	<div style="float:left; border:1px solid #ccc; border-radius:5px; padding:5px; margin-right:10px;">
        	<img id="img_show" src="images/user_show.png" width="50" height="50" />
        </div>
      <table border="0" style="float:left;">
        <tr>
    	  <td><span id="title"></span></td>
    	  <td></td>
  		</tr>
  		<tr>
    	  <td><input type="text" id="userimg" value="" placeholder="请上传你的靓照！" style="border: 2px solid #F64B78; width:300px; padding:5px; color:#999999" /></td>
    	  <td><input class="sharebtn" type="button" value="上传图片" onclick="javascript:var taoIid=$('#taoIid').val();openpic('<?=str_replace(SITEURL,CURURL,u('fun','upload',array('uploadtext'=>'userimg','default_img'=>'images/user_show.png','sid'=>session_id())))?>&picname=baobei_'+taoIid+DDUID,'upload','500','500')" /></td>
  		</tr>
	  </table>
      <div style="clear:both;"></div>
    </div>
	
    <div class="share_cat" style="padding-left:5px; margin-top:15px">
      <ul>
        <?php foreach($cat_arrs as $k=>$v){?>
        <li><label><input name="shaicat" value="<?=$v['cid']?>" type="radio" id="radio<?=$v['cid']?>"><?=$v['title']?></label></li>
        <?php }?>
      </ul>
    </div>
    <div class="shareform" style="margin-top:10px; height:156px">
      
      <div id="expression" style=" float:left">
      <ul>
      </ul>
      <!--<div style=" float:left; margin-left:2px;cursor:pointer; width:30px" onclick="$('#expression').fadeOut('slow');">关闭</div>-->
      </div>
        <div class="shareComment" style="width:auto">
        <table border="0">
  <tr>
    <td><textarea id="comment" style="width:400px; padding-right:5px" onfocus="if(this.value==commentDefaultVal){this.value=''};"><?=$commentDefaultVal?></textarea></td>
    <td><span style="color:#999999; font-size:14px; padding-left:10px">评论内容</span></td>
  </tr>
</table>

        
          
        </div>
        <div style="clear:both"></div>
      
      <div class="funtip" style="width:400px">
        <div class="picfunc">
          <a left="19px" id="openem">添加表情</a>
        </div>
        <div class="wordtip">还可以输入<b id="num"><?=$num?></b>个字</div>
      </div>
      
      <div style="clear:both"></div>
    <div class="shareSubmit" style=" padding-left:150px; margin-top:15px">
    	 <input id="tao_url" type="hidden" name="tao_url" value=""/>
         <input id="taoIid" type="hidden" value=""/>
   		 <input id="subShare" type="submit" value="发 布"/>
    </div>
      
    </div>
    
      </form>
      <div id="reason" style="float:left; clear:both; margin-top:-10px;"></div>
    </div>
</div>
</div></div><div class="middle_right"></div><div class="end_left"></div><div class="end_center"></div><div class="end_right"></div></div>