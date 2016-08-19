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
	jump(-1,'设置完成');
}
else{
	$moban_name='pc_'.MOBAN_NAME;
	$tpl_data=$duoduo->select('tpl','data','title="'.$moban_name.'"');
	$tpl_data=(array)dd_unxuliehua($tpl_data);
}

$sort_arr=include(DDROOT.'/data/paipai_sort.php');
?>
<form action="<?=$action_url?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
    <tr>
    <td width="115" align="right">默认关键词：</td>
    <td >&nbsp;<input name="paipai[keyWord]" value="<?=$tpl_data['paipai']['keyWord']?$tpl_data['paipai']['keyWord']:'热卖'?>" />&nbsp;<span class="zhushi">必须填写，否则没有默认数据</span></td>
  </tr>
  <tr>
    <td align="right" >显示商品数量：</td>
    <td >&nbsp;<input name="paipai[pageSize]" value="<?=$tpl_data['paipai']['pageSize']?$tpl_data['paipai']['pageSize']:20?>" />&nbsp;<span class="zhushi">最多40个</span></td>
  </tr>
  <tr>
    <td align="right" >商品排序：</td>
    <td >&nbsp;<?=select($sort_arr,$tpl_data['paipai']['sort'],'paipai[sort]')?>&nbsp;</td>
  </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td>&nbsp;<input type="submit" class="sub" name="sub" value=" 保 存 设 置 " /></td>
  </tr>
  </table>
</form>