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
	$moban_name='wap_'.$_GET['tpl'];
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
	
	dd_set_cache('tpl/'.$moban_name,$_POST);
	jump(-1,'设置完成');
}
else{
	$moban_name='wap_'.MOBAN_NAME;
	$tpl_data=$duoduo->select('tpl','data','title="'.$moban_name.'"');
	$tpl_data=(array)dd_unxuliehua($tpl_data);
}
?>
<form action="<?=$action_url?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  
    <tr>
        <td width="115px" align="right">logo：</td>
        <td>&nbsp;<input name="logo" type="text" value="<?=$tpl_data['logo']?>" id="logo" class="btn3" style="width:300px" /> <input class="sub" type="button" value="上传logo" onclick="javascript:openpic('<?=u('fun','upload',array('uploadtext'=>'logo','name'=>'mlogo','sid'=>session_id()))?>','upload','450','350')" /> 
        <span class="zhushi">建议尺寸大小：100px*40px；透明 白色字体 png24格式</span></td>
    </tr>
    <tr>
        <td align="right">预载图片：</td>
        <td>&nbsp;<input name="loading_img" type="text" value="<?=$tpl_data['loading_img']?>" id="loading_img" class="btn3" style="width:300px" /> <input class="sub" type="button" value="上传预载图片" onclick="javascript:openpic('<?=u('fun','upload',array('uploadtext'=>'loading_img','do'=>'httpurl','sid'=>session_id()))?>','upload','450','350')" /> <span class="zhushi">根据模版预载图片实际尺寸上传，格式不限。默认模板大小：150px*150px，可gif</span>
        </td>
    </tr>
    <tr>
        <td align="right">首页宣传语：</td>
        <td>&nbsp;<input name="advertise" value="<?=$tpl_data['advertise']?$tpl_data['advertise']:'口袋中的购物返利神器！'?>"/><span class="zhushi">字数不要太多</span></td>
    </tr>
  <tr>
    <td align="right">底部版权：</td>
    <td>&nbsp;<textarea name="banquan" id="content" style="width:480px; margin-left:5px;"><?=$tpl_data['banquan']?></textarea>&nbsp;<span class="zhushi">如：Copyright ©2008-2014 XXXX版权所有</span></td>
  </tr>
    <tr>
    <td align="right">模版颜色：</td>
    <td>
    <table border="0" class="yanse">
    <tr>
    <td>&nbsp;<input name="color" value="<?=$tpl_data['color']?$tpl_data['color']:'#EC1A5B'?>"/> </td>
    <?=seban()?>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;适用于wap页有头底部颜色</td>
  </tr>
</table>
 </td>
  </tr>
    <tr>
        <td align="right">底部导航：</td>
        <td>&nbsp;<?=html_radio($zhuangtai_arr,$tpl_data['foot_open'],'foot_open')?> </td>
    </tr>
    <tr>
     <td align="right">&nbsp;</td>
     <td>&nbsp;<input type="submit" name="sub" value=" 保 存 设 置 " /></td>
  </tr>
  </table>
</form>