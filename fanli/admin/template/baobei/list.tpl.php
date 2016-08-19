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
$cid_arr[] = '全部';
$type=$duoduo->select_all('type','*',"tag='goods'");
foreach($type as $k=>$vo){
	$cid_arr[$vo['id']]=$vo['title'];
}
$status_arr1['-1'] = '全部';
$status_arr=array('已审核','拒绝','待审核');
$status_arr=$status_arr1+$status_arr;

$status_color_arr=array('color:green','color:red','');
include(ADMINTPL.'/header.tpl.php');
?>
<form action="" method="get">
<table cellspacing="0" width="100%" style="border:1px  solid #DCEAF7; border-bottom:0px; background:#E9F2FB">
        <tr>
              <td width="500">&nbsp;<img src="images/arrow.gif" width="16" height="22" align="absmiddle" />&nbsp;&nbsp;<?php if($reycle==1){?><a href="<?=u(MOD,ACT)?>" class="link3">[返回列表]</a><?php }else{?><a href="<?=u(MOD,ACT,array('reycle'=>1))?>" class="link3">[回收站]</a><?php }?></td>
              <td width=""></td>
              <td width="700" align="right"><?=select($select_arr,$se,'se')?>：<input type="text" name="q" value="<?=$_GET['q']?>" />&nbsp;<?=select($cid_arr,$cid,'cid')?>&nbsp;<?=select($status_arr,$status,'status')?>&nbsp;<input type="submit" value="搜索" />&nbsp;&nbsp;共有 <b><?php echo $total;?></b> 条记录&nbsp;&nbsp;</td>
            </tr>
      </table>
      <input type="hidden" name="mod" value="<?=MOD?>" />
      <input type="hidden" name="act" value="<?=ACT?>" />
      </form>
      <form name="form2" method="get" action="" style="margin:0px; padding:0px">
      <table id="listtable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
                    <tr>
                      <th width="40"></th>
                      <th width="50">排序</th>
                      <th width="250">商品名</th>
                      <th width="80">会员</th>
                      <th width="70">分类</th>
                      <th width="100">上传图片</th>
                      <th width="5%">价格</th>
                      <th width="5%">红心</th>
                      <?php if($webset['baobei']['user_show']==1){?>
                      <th width="5%">审核</th>
                      <?php }?>
                      <th width="140px">添加时间</th>                     
                      <th width="140px">操作</th>
                      <th></th>
                    </tr>
					<?php foreach ($row as $r){?>
					  <tr>
                        <td><input type='checkbox' name='ids[]' value='<?=$r["id"]?>' id='content_<?=$r["id"]?>' /></td>
                        <td class="input" field='sort' w='50' tableid="<?=$r["id"]?>" status='a' title="双击编辑"><?=$r["sort"]==DEFAULT_SORT?'——':$r["sort"]?></td>
                        <td><a href="<?='../'.u('baobei','view',array('id'=>$r['id']))?>" target="_blank" class="ddnowrap" style="width:240px; " title="<?=$r["title"]?>"><?=$r["title"]?></a></td>
                        <td><?=$r["ddusername"]?></td>
                        <td><?=$cid_arr[$r["cid"]]?></td>
                        <td class="showpic" pic="<?=$r["userimg"]?$r["userimg"]:tb_img($r["img"],200)?>">查看</td>
                        <td><?=$r["price"]?></td>
                        <!--<td><?=$r["commission"]?></td>-->
                        <td><?=$r["hart"]?></td>
                        <?php if($webset['baobei']['user_show']==1){?>
                        <td style=" <?=$status_color_arr[$r['status']]?>"><?=$status_arr[$r['status']]?></td>
                        <?php }?>
                        <td><?=date('Y-m-d H:i:s',$r["addtime"])?></td>
						<td><a href="<?=u(MOD,'addedi',array('id'=>$r['id']))?>">查看</a> <a href="<?=u('baobei_comment','list',array('sid'=>$r["id"]))?>">评论（<?=$r['comment_num']?>）</a></td>
                        <td></td>
					  </tr>
					<?php }?>
                    <tr>
                      <th width="40" ><input type="checkbox" onClick="checkAll(this,'ids[]')" /></th>
                      <th colspan="11"><div align="left">
                        <input type="hidden" name="mod" value="<?=MOD?>" /><input type="hidden" name="act" id="act" value="del" />
			<?php if($reycle==1){?>
            <input type="hidden" id="do_input" name="do" value="del" />
            <input type="submit" value="删除" class="myself" onclick='return confirm("确定要删除?")'/> &nbsp;<input type="submit" value="还原" class="myself" onclick='$("#do_input").val("reset");return confirm("确定要还原?")'/>
            <?php }else{?>
            <input type="submit" value="审核" class="myself" name="audit" onclick='$("#act").val("list");return confirm("确定要批量审核(状态必须是待审核)?")'/> &nbsp;<input type="submit" value="删除" class="myself" onclick='return confirm("确认要删除转移到回收站?")'/>&nbsp;
            <?php }?></div></th>
        			</tr>
		</table>
            <div class="megas512" style=" margin-top:15px;"><?=pageft($total,$pagesize,u(MOD,'list',$page_arr));?></div>
            </div>
       </form>
<?php include(ADMINTPL.'/footer.tpl.php');?>