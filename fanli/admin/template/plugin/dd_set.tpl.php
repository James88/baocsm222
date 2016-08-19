<?php
if(!defined('ADMIN')){
	exit('Access Denied');
}
?>
  <tr>
    <td width="115px" align="right">状态：</td>
    <td>&nbsp;<?=html_radio(array(0=>'关闭',1=>'开启'),$plugin['status']?$plugin['status']:0,'status')?> <span class="zhushi"><a href="<?=u(MOD,'update',array('code'=>$plugin['code'],'plugin_id'=>$plugin_id,'do'=>'update','over'=>1))?>">更新</a>（此更新只针对手动上传应用文件的情况下使用，只更新应用信息，不更新应用文件。同步应用信息，会更新应用版本号）</span></td>
  </tr>
  <?php if(!empty($plugin_set['search'])){$plugin_search_arr=dd_get_cache('plugin_nav_search');if(isset($plugin_search_arr[$plugin['code']])){$plugin_search=1;}else{$plugin_search=0;}?>
  <tr>
    <td align="right">搜索状态：</td>
    <td>&nbsp;<?=html_radio(array(0=>'关闭',1=>'开启'),$plugin_search,'search')?></td>
  </tr>
  <tr>
    <td align="right">搜索名称：</td>
    <td>&nbsp;<input name="search_name" type="text" id="search_name" value="<?=$plugin_set['search']['search_name']?>" style="width:300px" /></td>
  </tr>
  <tr>
    <td align="right">搜索名称宽度：</td>
    <td>&nbsp;<input name="search_width" type="text" id="search_width" value="<?=$plugin_set['search']['search_width']?>" style="width:300px" /> <span class="zhushi">（单位：像素）</span></td>
  </tr>
  <tr>
    <td align="right">搜索提示：</td>
    <td>&nbsp;<input name="search_tip" type="text" id="search_tip" value="<?=$plugin_set['search']['search_tip']?>" style="width:300px" /></td>
  </tr>
  <?php }?>
<script>
$(function(){
	$('input[name=status]').click(function(){
		var a=$('input[name=status]:checked').val();
		if(a==0){
			$('input[name=search]').eq(a).attr("checked", "checked");
		}
		
	});
});
</script>