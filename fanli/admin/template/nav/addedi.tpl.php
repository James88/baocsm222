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

$diaoyong_arr=array(0=>'自定义',1=>'模块',2=>'板块');
$lianjie_arr=array(0=>'本站',1=>'外链');

include(ADMINTPL.'/header.tpl.php');

$has_son = $duoduo->count('nav','pid="'.$row['id'].'"');
if($row['pid']>0 || $has_son<=0){
	$nav_arr=$duoduo->select_2_field('nav','id,title','pid=0');
	$nav_arr[0]='无';
	ksort($nav_arr);
}
elseif($_['id']>0){
	$nav_arr = -1;
}
foreach($nav_arr as $k=>$v){
	if($v==$row['title']){
		unset($nav_arr[$k]);
	}
}
$bankuai_arr[''] = '无';
$bankuai = $duoduo->select_all('bankuai','code,title',' 1 order by sort desc,id desc');
foreach($bankuai as $k=>$v){
	$bankuai_arr[$v['code']] = $v['title'];
}

if((int)$id==0){
	$row['diaoyong']=1;
}
?>
<style>
.bankuai_name,.lianjieurl{ display:none}
</style>
<script>
navArr=new Array();
<?php foreach($nav_tag as $k=>$v){?>
navArr[<?=$k?>]='<?=$v?>';
<?php }?>
$(function(){
	$('#pid').change(function(){
		if($(this).val()>0){
			$('#tag').val(navArr[$(this).val()]);
		}
	});
	
	$('#sm').jumpBox({  
		height:200,
		width:600,
		contain:$('#mydiv').html()
    });	
})

$(function(){
	$('input[name="diaoyong"]').click(function(){
		diaoyong_radio($(this));
	});
	diaoyong_radio($('input[name="diaoyong"]:checked'));
	
	$('input[name="lianjie"]').click(function(){
		lianjie_radio($(this));
	});
	lianjie_radio($('input[name="lianjie"]:checked'));
	
	$('#mod_name').change(function(){
		mod_name_select($(this));
	});
	
	$('#bankuai_name').change(function(){
		bankuai_select($(this));
	});
})

function mod_name_select($t){
	$('#mod').val($t.val());
	$('#tag').val($t.val());
	if($('#act').val()==''){
		$('#act').val('index');
	}
}

function bankuai_select($t){
	$('#code').val($t.val());
}

function diaoyong_radio($t){
	$('#_mod_name').removeAttr('name');
	$('.mod_name,.bankuai_name').hide();
	if($t.val()==1){
		$('.mod_name').show();
		$('.mod_name').removeAttr('disabled');
	}
	else if($t.val()==2){
		$('.mod_name').show().val('goods');
		$('.mod_name').attr('disabled','true');
		$('.bankuai_name').show();
		$('#code').val($('#bankuai_name').val());
		$('#_mod_name').attr('name','mod_name').val('goods');
	}
	if($t.val()>0){
		mod_name_select($('#mod_name'));
	}
	if($t.val()!=2){
		$('#code').val('');
	}
}

function lianjie_radio($t){
	if($t.val()==1){
		$('.lianjieurl').show();
		$('.zidingyiurl').hide();
	}
	else{
		$('.lianjieurl').hide();
		$('.zidingyiurl').show();
	}
}
</script>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115px" align="right">名称：</td>
    <td>&nbsp;<input name="title" type="text" id="title" value="<?=$row['title']?>" /> <span class="zhushi">&nbsp;<a href="http://bbs.duoduo123.com/read-1-1-198023.html" target="_blank">添加教程</a></span></td>
  </tr>
  
  <tr>
    <td align="right">链接类型：</td>
    <td>&nbsp;<?=html_radio($lianjie_arr,$row['lianjie'],'lianjie')?></td>
  </tr>
  <tbody class="lianjieurl">
  <tr>
    <td align="right">链接：</td><!--仅点外连时出现-->
    <td>&nbsp;<input name="url" type="text" id="url" value="<?=$row['url']?>" style="width:300px" /> <span class="zhushi">以http://开头，添加绝对地址</span></td>
  </tr>
  </tbody>
  <!--点击链接类型本站时出现，与链接不同时出现-->
  <tbody class="zidingyiurl">
  <tr>
    <td align="right">调用类型：</td>
    <td>&nbsp;<?=html_radio($diaoyong_arr,$row['diaoyong'],'diaoyong')?></td>
  </tr>
  <!--点调用类型自定义出现开始-->
  <tr class="mod_name">
    <td align="right">模块名：</td>
    <td>&nbsp;<?=select($dd_mod_act_arr,$row['mod_name'],'mod_name')?> <input type="hidden" id="_mod_name" name="" value="" /></td>
  </tr>
  <tr class="bankuai_name">
    <td align="right">版块名：</td>
    <td>&nbsp;<?=select($bankuai_arr,$row['bankuai_name'],'bankuai_name')?></td>
  </tr>
  <tr>
    <td align="right">模块：</td><!--调用模板内模块目录名称-->
    <td>&nbsp;<input name="mod" type="text" id="mod" value="<?=$row['mod']?>"/></td>
  </tr>
  <tr>
    <td align="right">行为：</td><!--调用对应模块内文件名称-->
    <td>&nbsp;<input name="act" type="text" id="act" value="<?=$row['act']?>" /></td>
  </tr>
  <tr class="bankuai">
    <td align="right">板块：</td>
    <td>&nbsp;<input name="code" type="text" id="code" value="<?=$row['code']?>" /><span class="zhushi">此项无需人工填写</span></td>
  </tr>
  <tr>
    <td align="right">导航标记：</td><!--默认模块名称-->
    <td>&nbsp;<input name="tag" type="text" id="tag" value="<?=$row['tag']?>"/> <span class="zhushi"><a style=" cursor:pointer; text-decoration:underline" id="sm" >设置向导</a> 用于模板导航关联</span></td>
  </tr>
  </tbody>
  <!--点击链接类型结束-->
  <!--调用类型自定义结束-->
  <tr>
    <td align="right">跳转方式：</td>
    <td>&nbsp;<?=html_radio($target,$row['target'],'target')?></td>
  </tr>
  <tr>
    <td align="right">是否隐藏：</td>
    <td>&nbsp;<?=html_radio($status,$row['hide'],'hide')?></td>
  </tr>
  <tr>
    <td align="right">状态：</td>
    <td>&nbsp;<?=html_radio($type,$row['type'],'type')?></td>
  </tr>
  <tr>
    <td align="right">是否是应用：</td>
    <td>&nbsp;<?=html_radio($shifou_arr,$row['plugin'],'plugin')?> <span class="zhushi">此导航是否是一个应用插件</span></td>
  </tr>
  <tbody class="lianjieurl">
  <tr>
    <td align="right">是否提示登陆：</td>
    <td>&nbsp;<?=html_radio(array(0=>'否',1=>'是'),$row['tip'],'tip')?> <span class="zhushi">用于自定义链接，当自定义链接为空是，此项无效</span></td>
  </tr>
  </tbody>
  <tr>
    <td align="right">父导航：</td>
    <td>&nbsp;<?php if($nav_arr==-1){?> <span class="zhushi">当前导航已是父导航，不能为其指定父导航</span><?php }else{?><?=select($nav_arr,$row['pid'],'pid')?> <span class="zhushi">选择父标签后，导航标记要与父导航标记相同</span><?php }?> </td>
  </tr>
  <tr>
    <td align="right">短说明：</td>
    <td>&nbsp;<input name="alt" type="text" id="alt" value="<?=$row['alt']?>" /> <span class="zhushi">只适用于子导航</span></td>
  </tr>
  <tr>
    <td align="right">排序：</td>
    <td>&nbsp;<input name="sort" type="text" id="sort" value="<?=$row['sort']?>" /> <span class="zhushi">数字越小越靠前,1为最小值</span></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="id" value="<?=$row['id']?>" /><input type="submit" class="sub" name="sub" value=" 保 存 " /></td>
  </tr>
</table>
</form>
<div id="mydiv" style="display:none; ">
<div  style="font-size:14px; color:#666666; font-family:'宋体'; line-height:20px; padding-top:20px">
<p>情况1：如无特殊需求，导航标记与模块相同</p>
<p>情况2：如果需要把某个导航设置为子导航，那么它的导航标记应该和主导航的相同。</p>
</div>
</div>
<?php include(ADMINTPL.'/footer.tpl.php');?>