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

include(ADMINTPL.'/header.tpl.php');
?>
<script>
$(function(){
	$('input[name="gametask[img]"]').click(function(){
		if($(this).val()!=''){
			$("#img").attr("value",$(this).val());
		}
	});
	if(parseInt($('input[name="gametask[status]"]:checked').val())==1){
		$('#gt').show();
	}else{
		 $('#gt').hide();
	}
	
	 $('input[name="gametask[status]"]').click(function(){
        if($(this).val()==1){
		   $('#gt').show();
		}
		else if($(this).val()==0){
		   $('#gt').hide();
		}
	});
})
</script>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
 		<tr>
        <td align="right" width="115">
            状态：
        </td>
        <td>
            &nbsp;
            <?=html_radio($zhuangtai_arr,$webset['gametask']['status'],'gametask[status]')?>
     </td>
    </tr>
    <tbody name="gt" id="gt" style="display:none">
  <tr class="offer_set">
    <td align="right" width="120px">Banner图片：</td>
    <td>
        <table border="0">
          <tr>
            <td>&nbsp;Banner图片1:<input <?php if($webset['gametask']['img']=='images/gametask/1.jpg') echo 'checked="checked"';?> name='gametask[img]' type='radio' value='images/gametask/1.jpg' /></td>
            <td >&nbsp;<img src="http://<?=URL?>/images/gametask/1.jpg" width="300" height="50" /></td>
          </tr>
          <tr>
            <td>&nbsp;Banner图片2:<input <?php if($webset['gametask']['img']=='images/gametask/2.jpg') echo 'checked="checked"';?>   name='gametask[img]' type='radio' value='images/gametask/2.jpg' /></td>
            <td>&nbsp;<img src="http://<?=URL?>/images/gametask/2.jpg" width="300" height="50" /></td>
          </tr>
          <tr>
            <td>&nbsp;Banner图片3:<input <?php if($webset['gametask']['img']=='images/gametask/3.jpg') echo 'checked="checked"';?>  name='gametask[img]' type='radio' value='images/gametask/3.jpg' /></td>
            <td>&nbsp;<img src="http://<?=URL?>/images/gametask/3.jpg" width="300" height="50" /></td>
          </tr>
          <tr>
            <td>&nbsp;自定义Banner图片</td>
            <td>&nbsp;<input name="gametask[img]" type="text" id="img" value="<?=$webset['gametask']['img']?>" style="width:300px" /> <input type="button" value="上传图片" onclick="javascript:openpic('<?=u('fun','upload',array('uploadtext'=>'img','sid'=>session_id()))?>','upload','700','120')" /> <span class="zhushi">可直接添加网络地址 尺寸700*120</span></td>
          </tr>
    </table>

    </td>
  </tr>
  <tr class="offer_set">
    <td align="right">Banner图片标题：</td>
    <td>&nbsp;<input name="gametask[title]" type="text" id="title" value="<?=$webset['gametask']['title']?$webset['gametask']['title']:'做任务拿奖励'?>" style="width:300px" /></td>
  </tr>
  <tr class="offer_set">
    <td align="right">Banner图片链接：</td>
    <td>&nbsp;<input name="gametask[url]" type="text" id="url" value="<?=$webset['gametask']['url']?>" style="width:300px" />&nbsp;<span class="zhushi">以http://开头；如不需要链接，留空即可</span></td>
  </tr>
  <tr class="offer_set">
    <td align="right">使用说明：</td>
    <td align="left" ><ul>
    <li>1、标题作为前台Banner图片广告的alt属性</li>
    <li>2、链接表示这个图片广告的链接</li>
    <li>3、此插件不可随便卸载重新安装，只能在线升级或者重新覆盖，重新安装可能会导致数据丢失。</li>
    </ul></td>
  </tr>
  </tbody>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="type" value="<?=$curnav?>" /><input type="submit" name="sub" value=" 保 存 " /></td>
  </tr>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php')?>