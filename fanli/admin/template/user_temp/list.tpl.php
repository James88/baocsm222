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
$top_nav_name=array(array('url'=>u('user_temp','qunfa_tag'),'name'=>'群发方案'),array('url'=>u('user_temp','list'),'name'=>'待发列表'),array('url'=>u('user_temp','qunfa_jilu'),'name'=>'已发记录'));
include(ADMINTPL.'/header.tpl.php');
?>
<script>
function xuanze(){
	var num=0;
	var sign='';
	$('.ids').each(function(){
		if($(this).attr('checked')=='checked'){
			var signTemp=$(this).attr('sign');
			if(sign==''){
				sign=signTemp;
			}
			else if(sign!=signTemp){
				alert('只能选择相同的方案标记进行发送');
				return false;
			}
			num++;
		}
	});
	if(num==0){
		alert('请选择群发的手机号码');
		return false;
	}
	var a=confirm("确定要发送这"+num+"条短信吗？");
	if(a==true){
		$("#act").val("qunfa");
		$("#signVal").val(sign);
		return true;
	}
	else{
		return false;
	}
}
</script>
<form action="" method="get">
<table cellspacing="0" width="100%" style="border:1px  solid #DCEAF7; border-bottom:0px; background:#E9F2FB">
        <tr>
              <td width="50px">&nbsp;<img src="images/arrow.gif" width="16" height="22" align="absmiddle" /></td>
              <td width="" align="right"></td>
              <td width="750px" align="right">方案标记：<input type="text" name="sign" style=" width:100px; padding-left:5px " value="<?=$sign?>" />&nbsp;<?=select($select1_arr,$se1,'se1')?>：<input type="text" name="q" value="<?=$q?>" />&nbsp;<input type="submit" value="搜索" />&nbsp;&nbsp;共有 <b><?php echo $total;?></b> 条记录&nbsp;&nbsp;</td>
            </tr>
      </table>
      <input type="hidden" name="mod" value="<?=MOD?>" />
      <input type="hidden" name="act" value="<?=ACT?>" />
      </form>
      <form name="form2" method="get" action="" style="margin:0px; padding:0px">
      <table id="listtable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
                    <tr>
                      <th width="30px"><input type="checkbox" onClick="checkAll(this,'ids[]')" /></th>
                      <th width="50px">id</th>
                      <th width="90px">方案标记</th>
                      <th width="150px">用户名</th>
                      <th width="70px">推荐人ID</th>
                      <th width="140px">注册时间</th>
                      <th width="120px">手机号码</th>
                      <th width="140px"><a href="<?=u(MOD,'list',array('lastlogintime'=>$listorder))?>">最近登录</a></th>
                      <th width="100px">操作</th>
                      <th ></th>
                    </tr>
                    <?php if(empty($row)){?>
                    <tr><td colspan="100" style="height:50px; line-height:50px; color:#000; text-align:left; padding-left:50px">
                    您还没有设置群发条件或者已经全部发送成功：
                    <a href="<?=u(MOD,'qunfa_set',array('do'=>'sms'))?>">请创建新群发</a>&nbsp;&nbsp;&nbsp;&nbsp;
                    </td></tr>
                    <?php }?>
					<?php foreach ($row as $r){?>
					  <tr>
                        <td><input type='checkbox' class="ids" sign="<?=$r["sign"]?>" name='ids[]' value='<?=$r["id"]?>' id='content_<?=$r["id"]?>' /></td>
                        <td><?=$r["id"]?></td>
                        <td><a href="<?=u('user_temp','qunfa_set',array('sign'=>$r["sign"]))?>"><?=$r["sign"]?></a></td>
                        <td><?=$r["ddusername"]?></td>
						<td><?=$r["tjr"]?></td>
                        <td><?=$r["regtime"]?></td>
                        <td><?=$r["mobile"]?></td>
						<td><?=$r["lastlogintime"]?></td>
						<td><a href="<?=u('user','addedi',array('id'=>$r['uid']))?>">查看</a>&nbsp;<a href="<?=u('mingxi','list',array('uname'=>$r['ddusername']))?>">明细</a></td>
                        <td></td>
					  </tr>
					<?php }?>
		</table>
        <div style="position:relative; padding-bottom:10px">
            <input type="hidden" name="mod" value="<?=MOD?>" /><input type="hidden" id="signVal" name="sign" value="<?=$sign?>" /><input type="hidden" name="act" id="act" value="del" /><input type="hidden" name="do" id="do" value="sms" />
            <div style=" margin-top:15px"><input type="submit" value="删除" onclick='return confirm("确定要删除?")'/> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="sub" value="选择群发" onclick='return xuanze()'/>&nbsp;&nbsp;
            <?php if($sign!=''){?><input type="submit" name="sub" value="全部群发" onclick='var a=confirm("确定要群发?");if(a==true){$("#act").val("qunfa");return true}else{return false;}'/><?php }?>
            &nbsp;<!--<input type="submit" name="sub" value="重发" onclick='var a=confirm("确定要重发?");if(a==true){$("#act").val("qunfa");$("#chongfa").val("1");return true}else{return false;}'/>--> <!--<?=html_radio($qunfa_arr,$do,'do')?>--></div>
            <div class="megas512" style=" margin-top:10px;"><?=pageft($total,$pagesize,u(MOD,'list',$page_arr));?></div>
            </div>
       </form>
<?php include(ADMINTPL.'/footer.tpl.php');?>