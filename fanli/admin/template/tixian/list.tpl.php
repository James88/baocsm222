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
include(ADMINTPL.'/tixian/ddshouquan.tpl.php');

?>

<form action="" method="get">
<table cellspacing="0" width="100%" style="border:1px  solid #DCEAF7; border-bottom:0px; background:#E9F2FB">
        <tr>
              <td>&nbsp;<img src="images/arrow.gif" width="16" height="22" align="absmiddle" />&nbsp;<a class="link3" href="<?=u(MOD,ACT,array('type'=>2,'status'=>0))?>">[金额提现]</a> <a class="link3" href="<?=u(MOD,ACT,array('type'=>1,'status'=>0))?>">[集分宝提现]</a> &nbsp;<a target="_blank" class="link3" href="<?=u(MOD,ACT,array('daochu'=>1))?>">[导出集分宝]</a>&nbsp;<?php if($reycle==1){?><a href="<?=u(MOD,ACT)?>" class="link3">[返回列表]</a><?php }else{?><a href="<?=u(MOD,ACT,array('reycle'=>1))?>" class="link3">[回收站]</a><?php }?>  <?php if($sum!=''){ ?> <a href="https://shenghuo.alipay.com/send/payment/fill.htm" target="_blank" class="link3">[立即支付]</a>&nbsp;&nbsp;&nbsp;<?php if($type>0){?>需支出：<span style="color:#F00;"><?=$sum?></span> <?=$type_arr[$type]?><?php }?> <?php }?></td> 
              <td align="right"><?=select($select_arr,$se,'se')?>：<input style="width:120px" type="text" name="q" value="<?=$q?>" />&nbsp;状态：<?=select($status_arr,$status,'status')?>&nbsp;类型：<?=select($type_arr,$type,'type')?>&nbsp;提现工具：<?=select($tool_arr,$tool,'tool')?>&nbsp;<input type="submit" value="搜索" />&nbsp;共有 <b><?php echo $total;?></b> 条记录&nbsp;&nbsp;</td>
            </tr>
      </table>
      <input type="hidden" name="mod"  value="<?=MOD?>" />
      <input type="hidden" name="act" value="<?=ACT?>" />
      </form>
      <form name="form2" method="get" action="" style="margin:0px; padding:0px">
      <table id="listtable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
                    <tr>
                      <th width="3%"><input type="checkbox" onClick="checkAll(this,'ids[]')" /></th>
                      <th width="5%">ID</th>
                      <th width="8%">用户名</th>
                      <th width="">提现平台</th>
                      <th width="10%"><?=$type_arr[$type]?></th>
                      <th width="130px">提交时间</th>
                      <th width="130px">处理时间</th>
                      <th width="9%">真实姓名</th>
                      <th width="9%">手机</th>
                      <th width="50px">状态</th>
                      <th width="115px">操作</th>
                    </tr>
					<?php 
					foreach ($row as $r){
						$a=(int)$duoduo->select('tixian','id','uid="'.$r['uid'].'" and id<"'.$r['id'].'"');
						if($a==0){
							$first=1;
						}
						else{
							$first=0;
						}
					?>
					  <tr>
                        <td><input type='checkbox' name='ids[]' value='<?=$r["id"]?>' id='content_<?=$r["id"]?>' /></td>
                        <td><?=$r['id']?></td>
                        <td><a href="<?=u('mingxi','list',array('uname'=>$r["ddusername"]))?>" title="查看明细" style="text-decoration:underline"><?=$r["ddusername"]?></a><?php if($first==1){?>  <span style="color:#F00" title="首次提现">[new]</span><?php }?></td>
						<td class=b><?=$tool_arr[$r['tool']].'：'.$r["code"]?></td>
                        <td class=a><?=(float)($r["money2"]==0?$r["money"]:$r["money2"])?>（<?=$type_arr[$r['type']]?>）</td>
                        <td><?=date('Y-m-d H:i:s',$r["addtime"])?></td>
                        <td><?=$r["dotime"]?date('Y-m-d H:i:s',$r["dotime"]):'-- --'?></td>
                        <td class=c><?=$r["realname"]?></td>
                        <td class=d><?=$r["mobile"]?></td>
                        <td class=e <?php if($r["status"]==2){?> title="<?=$r["why"]?>"<?php }?>><?=$status_arr[$r["status"]]?><?php if($r['api_return']!='' && $r['status']==0){?>[<span title="<?=$r['api_return']?>">平台反馈</span>]<?php }?></td>
						<td><a href="<?=u(MOD,'addedi',array('id'=>$r['id'],'do'=>'yes'))?>">确认</a>&nbsp;<a href="<?=u(MOD,'addedi',array('id'=>$r['id'],'do'=>'no'))?>">退回</a>&nbsp;<a href="<?=DD_OPEN_URL?>/index.php?m=TxBan&a=add&<?php if($r['tool']==1){echo 'alipay';}elseif($r['tool']==2){echo 'tenpay';}elseif($r['tool']==3){echo 'bank_code';}?>=<?=urlencode($r['code'])?>&realname=<?=urlencode($r['realname'])?>&phone=<?=urlencode($r['mobile'])?>&name=<?=get_domain(URL)?>">加黑</a></td>
					  </tr>
					<?php }?>
		</table>
        <div style="position:relative; padding-bottom:10px;">
            <input type="hidden" name="mod" value="<?=MOD?>" /><input type="hidden" id="act" name="act" value="del" /><input type="hidden" name="type" value="<?=$type?>" /><input type="hidden" id="msg" name="msg" value="" />
            <?php if($reycle==1){?>
            <input type="hidden" id="do_input" name="do" value="del" />
            <div style="position:absolute; left:5px; top:5px"><input type="submit" value="删除" class="myself" onclick='return confirm("确定要删除?")'/> &nbsp;<input type="submit" value="还原" class="myself" onclick='$("#do_input").val("reset");return confirm("确定要还原?")'/></div>
            <?php }else{?>
            <div style="position:absolute; left:5px; top:10px"><input type="submit" value="删除" onclick='return confirm("确认要删除转移到回收站?")'/> <input id="plqr" type="submit" value="批量确认提现" onclick='$("#act").val("list");return confirm("确定要批量提现?")'/>    <input id="pltz" type="submit" value="批量发送站内信" onclick='$("#msg").val("1");$("#act").val("list");return confirm("确定要批量发送站内信?")'/>         </div>
            <?php }?>
            <div class="megas512" style=" margin-top:15px;"><?=pageft($total,$pagesize,u(MOD,'list',$page_arr));?></div>
            </div>
       </form>
<script>
<?php if($type==1 && $webset['tixian']['ddpay']==1){?>
var needJfb=<?=$sum?>;
var haveJfb=<?=$open_jifenbao?>;
$(function(){
	if(needJfb>haveJfb){
		$('#plqr').attr('disabled','disabled');
		$('#plqr').attr('title','集分宝余额不足').after('（集分宝余额不足，<a href="<?=DD_OPEN_JFB_HELP_URL?>" target="_blank">充值说明</a>）');
	}
})
<?php }?>
</script>
<?php include(ADMINTPL.'/footer.tpl.php');?>