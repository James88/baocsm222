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

<form name="form1" action="" method="get">

<table cellspacing="0" width="100%" style="border:1px  solid #DCEAF7; border-bottom:0px; background:#E9F2FB">
        <tr>
              <td class="bigtext">&nbsp;<img src="images/arrow.gif" width="16" height="22" align="absmiddle" />&nbsp;<a href="<?=u(MOD,'addedi')?>" class="link3">[添加规则]</a></td>
              <td align="right" class="bigtext">共有 <b><?php echo $total;?></b> 条采集规则&nbsp;&nbsp;</td>
            </tr>
      </table>

      <input type="hidden" name="mod" value="<?=MOD?>" />
      <input type="hidden" name="act" value="<?=ACT?>" />
      <input type="hidden" name="code" value="<?=$code?>" />
      </form>
      <form name="form2" method="get" action="" style="margin:0px; padding:0px;">
      <table id="listtable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
        <tr>
          <th width="40px" ><input type="checkbox" onClick="checkAll(this,'ids[]')" /></th>
          <th width="150px">规则名称</th>
          <th width="100px">采集版块</th>
          <th width="60px">状态</th>
          <th width="300px">备注说明</th>
          <th width="150px">最近采集时间</th>
          <th width="100px">采集人</th>
          <th width="150px">操作</th>
          <th></th>
        </tr>
        <?php foreach($data as $vo){?>
        <tr>
          <td><input type='checkbox' name='ids[]' value='<?=$vo["id"]?>' id='content_<?=$vo["id"]?>' <?php if($vo['sys']==1){?> title="默认数据，不能删除" disabled<?php }?> /></td>
          <td><a href="<?=u('goods','list',array('code'=>$vo["code"]))?>"><?=$vo['title']?></a></span></td>
          <td><?=$vo['bankuai_title']?></td>
          <td><?=$zhuangtai_arr[$vo['status']]?></td>
          <td><?=is_kong($vo['beizhu'])?></td>
          <td><?=is_kong(date('Y-m-d H:i:s',$vo['update_time']))?></td>
          <td><?=$vo['admin_name']?></td>
          <?php
		  $cron_id=(int)$duoduo->select('cron','id','leixing=2 and dev="'.$vo['id'].'"');
		  ?>
          <td>
          <a href="<?=u(MOD,'addedi',array('id'=>$vo['id']))?>">修改</a>
          <a url="../<?=u('cron','run',array('jiaoben'=>'caiji','id'=>$vo['id']))?>" laiyuan="<?=$vo['laiyuan']?>" style="cursor:pointer" class="collect">采集</a>
          <?php if($cron_id>0){?>
          <a href="<?=u('cron','addedi',array('id'=>$cron_id))?>">计划任务</a>
          <?php }?>
          </td>
          <td></td>
        </tr>
        <?php }?>
        </table>
        <div style="position:relative; padding-bottom:10px">
            <input type="hidden" name="mod" value="<?=MOD?>" /><input type="hidden" name="act" value="del" />
            <div style="position:absolute; left:5px; top:5px"><input type="submit" value="删除" class="myself" onclick='return confirm("确认要删除?")'/> </div>
            <div class="megas512" style=" margin-top:15px;"><?=pageft($total,$pagesize,u(MOD,ACT,$page_arr));?></div>
            </div>
       </form>
<style>.alist{line-height:50px; padding-top:10px;}.alist a{font-size:16px;margin-right:30px;text-decoration:underline; cursor:pointer}</style>
<div id="paixu" style="display:none">
<div class="alist">
<input name="tiaozhua_url" value="" id="tiaozhua_url" type="hidden">
<a onClick="tiaozhuan(this,1)" >当天</a><a onClick="tiaozhuan(this,3)">近2天</a><a onClick="tiaozhuan(this,8)">近一周</a><a onClick="tiaozhuan(this,31)">近1月</a>
</div>
</div>
<script>
$(function(){
	$('.collect').jumpBox({
		LightBox:'show',
		height:70,
		width:350,
		jsCode:'var laiyuan=$(this).attr("laiyuan");if(laiyuan==2){window.location=$(this).attr("url");var jumpBoxStop=1;$(this).html("跳转中")}',
		jsCode2:'setContain($(this),$content)',
		contain:$('#paixu').html()
	});	
})
function setContain($t,$content){
	var url=$t.attr('url');
	$content.find('#tiaozhua_url').val(url);
}
function tiaozhuan($t,caiji_time){
	var url=$content.find('#tiaozhua_url').val();
	window.location=url+"&caiji_time="+caiji_time;
}
</script>
<?php include(ADMINTPL.'/footer.tpl.php');?>