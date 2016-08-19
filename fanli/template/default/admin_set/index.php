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
	$duoduo->update('tpl',array('title'=>'pc_default'),'title="default"');
	$moban_name='pc_'.MOBAN_NAME;
	$tpl_data=$duoduo->select('tpl','data','title="'.$moban_name.'"');
	$tpl_data=(array)dd_unxuliehua($tpl_data);
}
?>
<form action="<?=$action_url?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
    <tr>
      <td width="115px" align="right">网站logo：</td>
      <td>&nbsp;<input name="logo" type="text" value="<?=$tpl_data['logo']?$tpl_data['logo']:'images/logo.png'?>" id="logo" class="btn3" style="width:300px" /> <input class="sub" type="button" value="上传logo" onclick="javascript:openpic('<?=u('fun','upload',array('uploadtext'=>'logo','name'=>'logo','sid'=>session_id()))?>','upload','450','350')" /> <span class="zhushi">根据模版logo实际尺寸上传，格式不限。默认模板logo大小：230px*70px</span></td>
    </tr>
    <tr>
      <td align="right">预载图片：</td>
      <td>&nbsp;<input name="loading_img" type="text" value="<?=$tpl_data['loading_img']?$tpl_data['loading_img']:'images/lazy.gif'?>" id="loading_img" class="btn3" style="width:300px" /> <input class="sub" type="button" value="上传预载图片" onclick="javascript:openpic('<?=u('fun','upload',array('uploadtext'=>'loading_img','sid'=>session_id()))?>','upload','450','350')" /> <span class="zhushi">根据模版预载图片实际尺寸上传，格式不限。默认模板大小：300px*300px，可gif</span>
    </td>
    <tr>
      <td align="right">微信二维码：</td>
      <td>&nbsp;<input name="erweima" type="text" value="<?=$tpl_data['erweima']?>" id="erweima" class="btn3" style="width:300px" /> <input class="sub" type="button" value="上传二维码" onclick="javascript:openpic('<?=u('fun','upload',array('uploadtext'=>'erweima','sid'=>session_id()))?>','upload','450','350')" /> <span class="zhushi">可直接添加网络地址</span></td>
    </tr>
    <tr>
      <td align="right">商品首页样式：</td>
      <td>&nbsp;<?=select($bankuai_tpl_arr,$tpl_data['bankuai_tpl'],'bankuai_tpl')?> <span class="zhushi">商品显示的列表形式，具体可参考模板说明内解释</span>
    </td>
    <tr>
      <td align="right">每页商品数：</td>
      <td>&nbsp;<input name="pagesize" type="text" value="<?=$tpl_data['pagesize']!==''?$tpl_data['pagesize']:36?>" id="pagesize"  />（个）<span class="zhushi">默认模板建议设置3或者4的倍数</span></td>
    </tr>
    <tr>
      <td align="right">每页加载数：</td>
      <td>&nbsp;<input name="ajax_load_num" type="text" value="<?=$tpl_data['ajax_load_num']!==''?$tpl_data['ajax_load_num']:5?>" id="pagesize"  />（次）<span class="zhushi">页面加载多少次后显示分页</span></td>
    </tr>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td>&nbsp;<input type="submit" name="sub" class="sub" value=" 保 存 设 置 " /></td>
  </tr>
  </table>
</form>