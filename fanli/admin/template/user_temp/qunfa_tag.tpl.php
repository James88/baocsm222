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

function zishu($a){
	preg_match_all('/./us', $a, $match);
	return $sms_num=count($match[0]);
}

if($_GET['do']=='del'){
	$id_arr=$_GET['ids'];
	foreach($id_arr as $v){
		$duoduo->delete('qunfa_tag','sign="'.$v.'"',0);
		$duoduo->delete('user_temp','sign="'.$v.'"',0);
	}
	jump(u(MOD,ACT),'删除成功！');
}

$qunfa_status_arr=array(1=>'未群发',2=>'<span style=" color:orange">待审核</span>',3=>'<span style=" color:green">发送成功</span>',-1=>'<span style=" color:red">被拒绝</span>',);

if($webset['sms']['pwd']==''){
	jump(u('sms','set'),'请先设置短信密钥');
}

$ddopen=fs('ddopen');
$ddopen->sms_ini($webset['sms']['pwd']);

$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=20;
$frmnum=($page-1)*$pagesize;
$select1_arr=array('sign'=>'方案标记','title'=>'群发标题');
$se1 = $_GET['se1'];
$q = $_GET['q'];
$where=1;
if($q!=''){
	$where=$se1.' like "%'.$q.'%"';
	$page_arr['se1']=$se1;
	$page_arr['q']=$q;
}
$total=$duoduo->count(ACT,$where);
$list=$duoduo->select_all(ACT,'*',$where.' order by id desc limit '.$frmnum.','.$pagesize);

$qunfa_sign='';
foreach($list as $row){
	if($row['status']!=1){
		$qunfa_sign.=$row['sign'].',';
	}
}
$qunfa_sign=preg_replace('/,$/','',$qunfa_sign);
$re=$ddopen->sms_qunfa($qunfa_sign);
//print_r($re);
foreach($re['r'] as $k=>$row){
	foreach($list as $key=>$arr){
		if($arr['sign']==$row['sign']){
			$list[$key]['status']=(int)$row['status'];
			$list[$key]['msg']=$row['msg'];
			$data=array('status'=>$list[$key]['status'],'msg'=>$list[$k]['beizhu']);
			$duoduo->update('qunfa_tag',$data,'id="'.$list[$key]['id'].'"');
		}
	}
}

$top_nav_name=array(array('url'=>u('user_temp','qunfa_tag'),'name'=>'群发方案'),array('url'=>u('user_temp','list'),'name'=>'待发列表'),array('url'=>u('user_temp','qunfa_jilu'),'name'=>'已发记录'));
include(ADMINTPL.'/header.tpl.php');

$dd_open_status=dd_get(DD_OPEN_URL.'/1.txt');
if($webset['sms']['pwd']!=''){
	$ddopen->sms_ini($webset['sms']['pwd']);
	$a=$ddopen->get_user_sms();
	if($a['s']==1){
		$sms_tip='<span style="color:#060">您的通知短信（<b>'.$a['r']['sms'].'</b>条）；群发短信（<b>'.$a['r']['sms_qunfa'].'</b>条）</span>';
		$sms_sign=$a['r']['sms_sign'];
	}
	else{
		$sms_tip=$a['r'];
		$err=1;
	}
}
?>
<br/>
<div class="explain-col">
<table cellspacing="0" width="100%">
        <tr>
          <td width="120" style="color:#F00">&nbsp;短信监控信息</td>
          <td width="180" height="15">&nbsp;服务器状态：<?php if($dd_open_status=='ok'){?><span style="color:#060" title="与平台连接正常">正常</span><?php }else{?><span style="color:red" title="与平台连接异常">异常</span><?php }?></td> 
          <td width="380" class="tip">状态信息：<?=$sms_tip?> <?php if($err==1){?><a href="<?=u("sms","set")?>" title="短信设置">短信设置</a><?php }?></td>
          <?php if(DLADMIN!=1){?>
          <td width="112"><a href="<?=DD_OPEN_SMS_HELP_URL?>?type=sms_qunfa" target="_blank" style=" color:#F00" title="购买短信">购买短信</a></td>
          <td width="">&nbsp;&nbsp;<a href="<?=DD_OPEN_URL?>/top/zizhu.php?type=sms&type=sms_qunfa&domain=<?=get_domain()?>" style=" color:#F0F" title="淘宝购买付款后点次来自助充值短信">自助充值短信</a></td>
          <?php }?>
        </tr>
      </table>
</div>
<br/>
<form action="" method="get">
<table cellspacing="0" width="100%" style="border:1px  solid #DCEAF7; border-bottom:0px; background:#E9F2FB">
        <tr>
              <td width="100px">&nbsp;<img src="images/arrow.gif" width="16" height="22" align="absmiddle" />&nbsp;<a href="<?=u(MOD,'qunfa_set')?>" class="link3 chuangjian">[创建群发]</a></td>
              <td width="700px" align="right"><?=select($select1_arr,$se1,'se1')?>：<input type="text" name="q" value="<?=$q?>" />&nbsp;<input type="submit" value="搜索" />&nbsp;&nbsp;共有 <b><?php echo $total;?></b> 条记录&nbsp;&nbsp;</td>
            </tr>
      </table>
      <input type="hidden" name="mod" value="<?=MOD?>" />
      <input type="hidden" name="act" value="<?=ACT?>" />
      </form>
      <form name="form2" method="get" action="" style="margin:0px; padding:0px">
      <table id="listtable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
                    <tr>
                      <th width="30px"><input type="checkbox" onClick="checkAll(this,'ids[]')" /></th>
                      <th width="80px">方案标记</th>
                      <th width="100px">群发标题</th>
                      <th width="310px">群发内容</th>
                      <th width="50px">字数</th>
                      <th width="70px">申请数量</th>
                      <th width="70px">已提交</th>
                      <th width="100px">操作</th>
                      <th width="80px">状态</th>
                      <th width="120px">备注</th>
                      <th></th>
                    </tr>
                    <?php if(empty($list)){?>
                    <tr><td colspan="100" style="height:50px; line-height:50px; color:#000; text-align:left; padding-left:50px">
                    您还没有群发方案：
                    <?php foreach($qunfa_arr as $k=>$v){?>
                    <a class="chuangjian" href="<?=u(MOD,'qunfa_set',array('do'=>$k))?>"><?=$v?>创建群发</a>&nbsp;&nbsp;&nbsp;&nbsp;
                    <?php }?>
                    </td></tr>
                    <?php }?>
					<?php foreach ($list as $r){?>
					  <tr>
                        <td><input type='checkbox' name='ids[]' value='<?=$r["sign"]?>' id='content_<?=$r["id"]?>' /></td>
                        <td><a href="<?=u('user_temp','list',array('sign'=>$r["sign"]))?>"><?=$r["sign"]?></a></td>
						<td><?=$r["title"]?></td>
                        <td style="text-align:left"><span  class="ddnowrap" style="width:300px; " title="<?=$r["content"]?>"><?=$r["content"]?></span></td>
                        <td><?=zishu($r["content"])?></td>
                        <td><?=$r["num"]?></td>
                        <td><?=$r["ynum"]?></td>
						<td><a href="<?=u('user_temp','qunfa_set',array('sign'=>$r["sign"]))?>">查看</a>&nbsp;
                        <?php if($r["num"]>$r["ynum"]){?>
                        <a href="<?=u('user_temp','list',array('sign'=>$r["sign"],'do'=>'sms'))?>">群发</a>&nbsp;</td>
                        <?php }?>
                        <td><?=$qunfa_status_arr[$r["status"]]?></td>
                        <td><span  class="ddnowrap" style="width:110px; " title="<?=$r["msg"]?>"><?=$r["msg"]?$r["msg"]:'——'?></span></td>
                        <td></td>
					  </tr>
					<?php }?>
		</table>
        <div style="position:relative; padding-bottom:10px">
            <input type="hidden" name="mod" value="<?=MOD?>" /><input type="hidden" name="act" id="act" value="<?=ACT?>" /><input type="hidden" name="do" id="do" value="del" />
            <div style=" margin-top:15px">
            <div class="megas512" style=" margin-top:10px;"><?=pageft($total,$pagesize,u(MOD,'list',$page_arr));?></div>
            <input type="submit" value="删除" onclick='return confirm("确定要删除?")'/></div>
       
            </div>
       </form>

<?php include(ADMINTPL.'/footer.tpl.php');?>
<?php
if($err==1){
	jump(u('sms','set'),$sms_tip);
}
?>
<script>
if(<?=(int)$a['r']['sms_qunfa']?>==0){
	var w='您的群发短信数量为0，请先购买充值';
	alert(w);
	$('.chuangjian').removeAttr('href').attr('title',w).click(function(){alert(w)});
}
</script>