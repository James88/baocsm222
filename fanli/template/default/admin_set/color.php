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

if($_POST['sub']!=''){
	$moban_name='pc_'.$_GET['tpl'];
	unset($_POST['sub']);
	unset($_POST['tpl']);
	$tpl_data=(array)dd_unxuliehua($duoduo->select('tpl','data','title="'.$moban_name.'"'));
	foreach($_POST as $k=>$v){
		$tpl_data[$k]=$v;
	}
	
	$data=array('title'=>$moban_name,'data'=>dd_xuliehua($tpl_data));
	$tpl_id=(int)$duoduo->select('tpl','id','title="'.$moban_name.'"');
	if($tpl_id==0){
		$duoduo->insert('tpl',$data);
	}
	else{
		$duoduo->update('tpl',$data,'id="'.$tpl_id.'"');
	}
	
	dd_set_cache('tpl/'.$moban_name,$tpl_data);
	ob_start();
	?>
.c_bgcolor,.n-h-list li a span,.admin_xfl .admin_xfl_xz{background-color:<?=$tpl_data['qianse']?>;}
.c_border,.jy_nav a:hover,.admin_xfl ul{border-color:<?=$tpl_data['qianse']?>;}
.loginWays1 span em,.loginWays1 #menu_usernav em{border-color: <?=$tpl_data['qianse']?> transparent transparent;}
.dd_color,.c_fcolor,.c_fcolor:link,.c_fcolor:visited,.home-tab li.current .home-tab-super strong,.home-tab .home-tab-super:hover strong,.dddefault #navc a.sub_on,.topleft .topleftA a:hover,.topright  a:hover,#fonta a:hover,.jy_nav a:hover, a:hover,.n-h-list li a:hover{color:<?=$tpl_data['qianse']?>;}
.c_bgcolor a.anav:hover,#fontc{background:<?=$tpl_data['shense']?>;}
.c_hborder,.dddefault #navc a.sub_on{border-color:<?=$tpl_data['shense']?>}
    <?php
	$c=ob_get_contents();
	create_file(DDROOT.'/data/plugin/default/color.css',$c);
	ob_clean();
	$a=glob(DDROOT.'/data/css/*');
	foreach($a as $v){
		unlink($v);
	}
	jump(-1,'设置完成');
}
else{
	$moban_name='pc_'.MOBAN_NAME;
	$tpl_data=$duoduo->select('tpl','data','title="'.$moban_name.'"');
	$tpl_data=(array)dd_unxuliehua($tpl_data);
}

$qianse_arr=array('ff6600','dd0010','1ba358','f53e7b','2f97f0','953ddf');
$shense_arr=array('e84b0b','b1191a','006a30','de1163','1280dd','6e20b0');
?>
<style>
.yanse{display:inline-block; height:18px; width:18px; margin-bottom:-5px; _margin-bottom:-3px;  margin-right:5px; cursor:pointer;border:1px solid #FFF}
.cur{ border:1px solid #000}
</style>
<script>
$(function(){
	$('.qianse').click(function(){
		var bg=$(this).attr('bg');
		$('.qianse').removeClass('cur');
		$(this).addClass('cur');
		$('#qianse').val(bg);
	});
	$('.shense').click(function(){
		var bg=$(this).attr('bg');
		$('.shense').removeClass('cur');
		$(this).addClass('cur');
		$('#shense').val(bg);
	});
})
</script>
<div class="explain-col">建议当前色和着重色是同一色系，当前色较浅，着重色较深。</div>

<form action="<?=$action_url?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
    <tr>
      <td width="115px" align="right">当前色：</td>
      <td>&nbsp;<input name="qianse" type="text" value="<?=$tpl_data['qianse']?$tpl_data['qianse']:'#ff6600'?>" id="qianse" style="width:60px" /> <?php foreach($qianse_arr as $v){?><span class="yanse qianse <?php if('#'.$v==$tpl_data['qianse']){?>cur<?php }?>" bg="#<?=$v?>" style="background:#<?=$v?>"></span><?php }?> <span class="zhishi">仅供参考，可自行设置</span></td>
    </tr>
    <tr>
      <td align="right">着重色：</td>
      <td>&nbsp;<input name="shense" type="text" value="<?=$tpl_data['shense']?$tpl_data['shense']:'#e84b0b'?>" id="shense" style="width:60px" /> <?php foreach($shense_arr as $v){?><span class="yanse shense <?php if('#'.$v==$tpl_data['shense']){?>cur<?php }?>" bg="#<?=$v?>" style="background:#<?=$v?>"></span><?php }?> <span class="zhishi">仅供参考，可自行设置</span></td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td>&nbsp;<input type="submit" name="sub" class="sub" value=" 保 存 设 置 " /></td>
  </tr>
  </table>
</form>