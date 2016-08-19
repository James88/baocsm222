<?php 
/**
 * ============================================================================
 * 版权所有 多多科技，保留所有权利。
 * 网站地址: http://soft.duoduo123.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/

if(!defined('ADMIN')){
	exit('Access Denied');
}
no_cache();
if(MOD!='plugin' || ACT!='admin'){
	$mod_act_name=$duoduo->select('menu','title','`mod`="'.MOD.'" and act="'.ACT.'"');
}

$no_taobaoke=array('tao_index'=>array('tag'));

if(TAOTYPE==1 && isset($no_taobaoke[MOD]) &&  in_array(ACT,$no_taobaoke[MOD])){
	echo script('alert("您当前为无淘宝客初级包模式，无法使用'.$mod_act_name.'");window.history.go(-1)');exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?=$mod_act_name?></title>
<link href="images/skin.css" rel="stylesheet" type="text/css" />
<link href="../css/jumpbox.css" rel="stylesheet" type="text/css" />
<link href="../css/lhgcalendar.css" rel="stylesheet" type="text/css"/>
<script src="../js/jquery.js" type="text/javascript"></script>
<script src="../data/error.js" type="text/javascript"></script>
<script src="../js/fun.js" type="text/javascript"></script>
<script src="../js/jumpbox.js" type="text/javascript"></script>
<script src="../js/lhgcalendar.js" type="text/javascript"></script>
<script src="kindeditor/kindeditor.js" type="text/javascript"></script>
<script>
function openpic(url,name,w,h)
{
    window.open(url,name,"top=100,left=400,width=" + w + ",height=" + h + ",toolbar=no,menubar=no,scrollbars=yes,resizable=no,location=no,status=no");
}

if(!-[1,]==true){
	IE=1;
}
else{
	IE=0;
}

//全选/取消
function checkAll(o,checkBoxName){
	var oc = document.getElementsByName(checkBoxName);
	for(var i=0; i<oc.length; i++) {
		if(oc[i].disabled==false){
		    if(o.checked){
				oc[i].checked=true;	
			}else{
				oc[i].checked=false;	
			}
		}
	}
}

function copy(mytext) { 
    window.clipboardData.setData("Text",mytext);
    alert("复制成功");
} 

function inputBlur(t){
	var v=t.val();
	var p=t.parent('td');
	var f=p.attr('field');
	var tableid=p.attr('tableid');
	var url=p.attr('url');
	var table=p.attr('table');
	var $t=t;
	
	if(f=='sort'){
		if(!(/^[0-9]+$/).test(v) && v!='——'){
			alert('格式错误');
			return false;
		}
	}
	
	if(typeof table=='undefined' || table==''){
		<?php if(strstr(MOD,'type')){?>
		table='type';
		<?php }else{?>
		table='<?=MOD?>';
		<?php }?>
	}
	var data={'id':tableid,'f':f,'v':v,'table':table};
	if(typeof url!='undefined' && url!=''){
		url=url;
	}
	else{
		<?php if(strstr(MOD,'type')){?>
		url='<?=u('type',ACT)?>';
		<?php }else{?>
		url='<?=u(MOD,ACT)?>';
		<?php }?>
		data.public_sub=1;
	}
	$.get(url,data,function(data){
		p.html(v);
		p.attr('status','a');
		
		if(f=='sort'){
			$('.input').each(function(){
				var field=$(this).attr('field');
				if(field=='sort' && $(this).attr('tableid')!=tableid){
					var val=parseInt($(this).text());
					if(val==v){
						$(this).text('——');
					}
				}
			});
		}
	})
}

var editorSets = {
	extraFileUploadParams: {
		'admin': '<?=authcode('1','ENCODE')?>'
	}
};

$(function(){
	$('.extend_line').click(function(){
		var a=parseInt($(this).attr('data'));
		if(a==1){
			$(this).attr('data',0);
			$('.gaojiset').hide();
			$(this).css('backgroundImage','url(images/extends_down.gif)');
		}
		else{
			$(this).attr('data',1);
			$('.gaojiset').show();
			$(this).css('backgroundImage','url(images/extends_up.gif)');
		}
	});
	
	$('.input').dblclick(function(){
		var v=$(this).html();
		var s=$(this).attr('status');
		var w=$(this).attr('w');
		if(s=='a'){
			$(this).attr('status','b');
			$(this).html('<input value="'+v+'" onblur="inputBlur($(this))"  style="width:'+w+'px" />');
			$(this).find('input').focus().select();
		}
	});
	
	$('#sday').calendar({format:'yyyyMMdd'}); 
	$('#eday').calendar({format:'yyyyMMdd'});
	
	$('#sdate').calendar({format:'yyyy-MM-dd'}); 
	$('#edate').calendar({format:'yyyy-MM-dd'});
	
	$('#sdatetime').calendar({format:'yyyy-MM-dd HH:mm:ss'});
	$('#edatetime').calendar({format:'yyyy-MM-dd HH:mm:ss'}); 

	if($('#content').length>0){   
		KindEditor.options.filterMode = false;
	    editor = KindEditor.create('#content',editorSets);
	}
	
    $('#listtable tr').hover(function(){
	    $(this).addClass('trbg');
	},function(){
        $(this).removeClass('trbg');
	});
	//$('input[type=text],input[type=password],input[type=undefined]').addClass('input-text');
	$('input').each(function(){
		var type=$(this).attr('type');
		if(type=='text' || type=='password' || typeof type=='undefined'){
			$(this).addClass('input-text');
		}
	});
	
	$('.showpic').hover(function(){
		var pic=http_pic($(this).attr('pic'));
		$(this).css('position','relative');
	    $(this).html('<img style="position:absolute;display:none;top:-100px;*top:0px; right:50px; max-width:300px" src="'+pic+'" onload="imgAuto(this,300,300)"/>' );
	},function(){
		$(this).css('position','static');
	    $(this).html('查看');
	});
	
	$('form[name=form1]').not('.myself').submit(function(){
		var re=checkForm($(this));
		if(re==false){
			return false;
		}
		var token='<?=$_SESSION['token']?>';
		var method=$(this).attr('method');
		if(method.toLowerCase()=='post'){
			var action=$(this).attr('action');
			if(action=='') action='index.php';
			$(this).attr('action',action+'&token='+token);
		}
		var $sub=$(this).find('input[type=submit]');
	    $sub.attr('disabled','true');
		$sub.val('提交中...');
		<?php
		if($_GET['from_url']!=''){
			$from_url=$_GET['from_url'];
		}
		else{
			if(strpos($_SERVER['HTTP_REFERER'],'mod=index')===false){
				$from_url=$_SERVER['HTTP_REFERER'];
			}
		}
		$from_url=str_replace('http://','duoduo://',$from_url);
		?>
		if($(this).attr('method')=='post'){
			var action=$(this).attr('action');
			$(this).attr('action',action+'&from_url='+urlencode('<?=$from_url?>'));
		}
		$sub.after('<input type="hidden" name="sub" value="1" />');
		return true;
	});
	<?php if($_GET['form_table_id']!='' && MOD=='template'){?>
	$('#default_form').hide();
	$('#<?=$_GET['form_table_id']?>').show();
	<?php }?>
	
	<?php if($reycle==1){?>
	var a=$('.autol span b').html();
	$('.autol span b').html(a+'回收站');
	<?php }?>
})

function top_nav_click(id,$t){
	$('#top_name .menu').attr('class','auto2 menu');
	$t.attr('class','auto menu');
	$('.from_table').hide();
	$('#'+id).show();
}

function smtpSetTip(id,wrod,tip){
	if(tip==0) return false;
	alert(wrod);
	var tag=0;
	var $t=$('#'+id);
	$t.show();
	setInterval(function(){
		if(tag==0){
			$t.css('color','red');
			tag=1;
		}
		else{
			$t.css('color','black');
			tag=0;
		}
	},500)
}
</script>
</head>
<body style=" min-height:500px; min-width:1200px;">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="17" valign="top" background="images/mail_leftbg.gif"><img src="images/left-top-right.gif" width="17" height="29" /></td>
    <td valign="top" id="top_name" background="images/content-bg.gif">
    <?php 
	$cur_url=CUR_URL;
	$a=explode('/'.ADMIN_NAME.'/',$cur_url);
	$cur_url=$a[1];
	if(!empty($top_nav_name)){?>
	<?php 
	$k=-1;
	foreach($top_nav_name as $i=>$a){
		$k++;
		if(isset($a['id']) && $a['id']!=''){
			$top_nav_name[$i]['top_nav_type']=1;
			if(isset($_GET['form_table_id']) && $_GET['form_table_id']!='' && $a['id']==$_GET['form_table_id']){ 
				$top_nav_name[$i]['class']='autol';
			}
			else{
				if($k==0 && $_GET['form_table_id']==''){
					$top_nav_name[$i]['class']='autol';
				}
				else{
					$top_nav_name[$i]['class']='auto2';
				}
			}
		}
		else{
			$top_nav_name[$i]['top_nav_type']=2;
			if((isset($_GET['curnav']) && $_GET['curnav']==$a['curnav']) || (!isset($_GET['curnav']) && MOD.'_'.ACT==tiqu_mod_act($a['url'],1))){
				$top_nav_name[$i]['class']='autol';
			}
			else{
				$top_nav_name[$i]['class']='auto2';
			}
		}
	}
	
	foreach($top_nav_name as $i=>$a){
	?>
    <span <?php if($a['top_nav_type']==1){?>onclick="top_nav_click('<?=$a['id']?>',$(this))"<?php }?> class="<?=$a['class']?> menu"><span><b><a <?php if($a['top_nav_type']==2){?>href="<?=$a['url']?>"<?php }?>><?=$a['name']?></a></b></span><i></i></span>
    <?php }?>
	<?php }else{?>
    <span class="autol"><span><b><?=$mod_act_name?></b></span><i></i></span> 
    <?php }?>
    </td>
    
    <td width="16" valign="top" background="images/mail_rightbg.gif"><img src="images/nav-right-bg.gif" width="16" height="29" /></td>
  </tr>
  <tr>
    <td valign="middle" background="images/mail_leftbg.gif">&nbsp;</td>
    <td valign="top" bgcolor="#F7F8F9">