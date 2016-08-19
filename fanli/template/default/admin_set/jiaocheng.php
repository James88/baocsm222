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

$jiaocheng=$tpl_data['jiaocheng'];
$mall_view_url_id=$duoduo->select('mall','id','1=1 order by id asc');

$jiaocheng_arr = array (
	array (
		'title' => '商城返利教程地址',
		'code' => 'mall',
		'url' => SITEURL.'/index.php?mod=mall&act=index',
	),
	array (
		'title' => '淘宝返利教程地址',
		'code' => 'tao',
		'url' => SITEURL.'/index.php?mod=tao&act=index',
	),
	array (
		'title' => '商城订单状态地址',
		'code' => 'mall_order',
		'url' => SITEURL.'/index.php?mod=user&act=tradelist&do=mall',
	),
	array (
		'title' => '站内购物引导地址',
		'code' => 'zhannei',
		'url' => SITEURL.'/index.php?mod=goods&act=index',
	),
	array (
		'title' => '清除cookie教程地址',
		'code' => 'cookie',
		'url' => SITEURL.'/index.php?mod=mall&act=view&id='.$mall_view_url_id,
	),
	array (
		'title' => '会员等级说明地址',
		'code' => 'dengji',
		'url' => SITEURL.'/index.php?mod=user&act=index',
	),
	array (
		'title' => '添加订单号教程',
		'code' => 'tbnick',
		'url' => SITEURL.'/index.php?mod=user&act=info&do=tbnick',
	)
);
?>
<form action="<?=$action_url?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
    <? foreach($jiaocheng_arr as $r){ ?>
        <tr>
        <td align="right" width="180"><?=$r['title']?>：</span>
        </td>
        <td >&nbsp;<input style="width:400px"  name="jiaocheng[<?=$r['code']?>]" value="<?=$jiaocheng[$r['code']]?>" />&nbsp;<a href="<?=$r['url']?>" target="_blank">查看显示位置</a></td>
      </tr>
    <?php }?>
  <tr>
	<td align="right"></td>
	<td>&nbsp;<input type="submit" name="sub" class="sub" value=" 保 存 设 置 " /></td>
  </tr>
</table>
</form>