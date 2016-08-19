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

function get_shuoming($file,$plugin=''){
	if($plugin!=''){
		$file='plugin/'.$plugin.'/cron/'.$file;
	}
	else{
		$file='comm/cron/'.$file;
	}
	$a=file_get_contents(DDROOT.'/'.$file);
	preg_match('#/\*\*([\s\S]+)\*\*/#',$a,$b);
	return trim($b[1]);
}

include(DDROOT.'/comm/cron.class.php');

include(ADMINTPL.'/header.tpl.php');
?>

<?php if($_GET['set_chufa']){$cron_chufa_arr=array(0=>'网站触发',1=>'服务器触发');?>
<script>
$(function(){
<?=radio_guanlian('cron_chufa')?>
})
</script>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>&set_chufa=1" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115" align="right">触发形式：</td>
    <td>&nbsp;<?=html_radio($cron_chufa_arr,$webset['cron_chufa'],'cron_chufa')?></td>
  </tr>
  <tbody class="cron_chufa_guanlian">
   <tr>
    <td align="right">触发地址：</td>
    <td>&nbsp; <?=SITEURL?>/?mod=cron <span class="zhushi">在服务器添加访问该网址的计划任务，可有效的保证任务的稳定执行（建议设置每分钟执行一次）</span></td>
    </tr>
  </tbody>
  <tr>
     <td align="right">&nbsp;</td>
     <td>&nbsp;<input type="submit" name="sub" value=" 保 存 设 置 " /></td>
  </tr>
</table>
</form>
<?php }else{?>
<form name="form1" action="" method="get">

<table cellspacing="0" width="100%" style="border:1px  solid #DCEAF7; border-bottom:0px; background:#E9F2FB">
        <tr>
              <td class="bigtext">&nbsp;<img src="images/arrow.gif" width="16" height="22" align="absmiddle" />&nbsp;<a href="<?=u(MOD,'addedi')?>" class="link3">[添加计划任务]</a>&nbsp;<a href="<?=u(MOD,ACT,array('set_chufa'=>1))?>" class="link3">[触发形式]</a></td>
              <td align="right" class="bigtext">共有 <b><?php echo $total;?></b> 条任务&nbsp;&nbsp;</td>
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
          <th width="110px">任务名称</th>
          <th width="150px">脚本文件</th>
          <th width="70px">状态</th>
          <th width="60px">类型</th>
          <th width="100px">时间</th>
          <th width="120px">上次执行时间</th>
          <th width="120px">下次执行时间</th>
          <th width="70px">任务进度</th>
          <th width="100px">反馈描述</th>
          <th width="120px">操作</th>
          <th></th>
        </tr>
        <?php foreach($row as $r){?>
	    <tr>
          <td><input <?php if($r['sys']==1){?>title="系统数据，不准删除"  disabled="disabled"<?php }?> type='checkbox' name='ids[]' value='<?=$r["id"]?>' id='content_<?=$r["id"]?>' /></td>
          <td><?=$r["title"]?></td>
          <td><?=$r["filename"]?></td>
          <td><?=$zhuangtai_arr[$r["status"]]?></td>
          <td><?=$leixing_arr[$r["leixing"]]?></td>
          	<?php
			if($r['dd']==1){
				$t='系统分配';
			}
		  	elseif($r['fangshi']==1){
				$t='每天'.sprintf('%02d',$r['execute_time']).'点';
			}
			elseif($r['fangshi']==2){
				$t='每'.$r['interval_time'].'分钟';
			}
			elseif($r['fangshi']==3){
				$t=$r['random'].'/1000概率';	
			}
		  	?>
          <td><?=$t?></td>
          <td><?=is_kong(date('Y-m-d H:i',strtotime($r['last_time'])))?></td>
          	<?php
			$next_time=date('Y-m-d H:i',strtotime(cron_next_time($r)));
			if($r['fangshi']==3){
				$next_time=is_kong();
			}
			if($r['jindu']==0){
				$jindu='完成';
			}
			else{
				$jindu='进行中';
			}
			?>
          <td><?=$next_time?></td>
          <td><?=$jindu?></td>
          <td><span class="ddnowrap" style="width:90px" title="<?=is_kong($r['msg'])?>"><?=is_kong($r['msg'])?></span></td>
         	 <?php
		  		if($r['leixing']!=1){
					$r["plugin_name"]='';
				}
		  ?>
          <td><a href="<?=u(MOD,'addedi',array('id'=>$r['id']))?>">修改</a> <a href="../<?=u('cron','run',array('cron_id'=>$r['id']))?>">执行</a> <a href="javascript:alert('<?=get_shuoming($r["filename"],$r["plugin_name"])?>')">说明</a></td>
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
<?php }?>
<?php include(ADMINTPL.'/footer.tpl.php');?>