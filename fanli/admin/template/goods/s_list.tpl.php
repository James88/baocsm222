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

$bankuai_yulan=$duoduo->select_all('bankuai','title,code');

include(ADMINTPL.'/header.tpl.php');
?>
<script>
$(function(){
	$('#zhixingsort').jumpBox({
		LightBox:'show',
		height:80,
		width:250,
		contain:$('#paixu').html()
	})
	
	$('#yulansort').jumpBox({
		LightBox:'show',
		height:150,
		width:350,
		contain:$('#yulan').html()
	})
})
</script>
<style>


.alist{ text-align:center}
.alist a,.alist a:visited{font-size:18px; color:#F30; text-decoration:underline}
</style>

<form name="form1" action="" method="get">

<table cellspacing="0" width="100%" style="border:1px  solid #DCEAF7; border-bottom:0px; background:#E9F2FB">
        <tr>
              <td class="bigtext">&nbsp;<img src="images/arrow.gif" width="16" height="22" align="absmiddle" />&nbsp;<a href="<?=u(MOD,'list')?>" class="link3">[返回列表]</a>&nbsp;<a href="<?=u(MOD,ACT,array('leixing'=>1))?>" class="link3">[当日商品]</a>&nbsp;<a href="<?=u(MOD,ACT,array('leixing'=>3))?>" class="link3">[明日商品]</a>&nbsp;&nbsp;<a href="<?=u(MOD,ACT,array('wufanli'=>1,'leixing'=>$_GET['leixing']))?>" title="仅删除当天和预告无返利的商品" class="link3" onclick="return confirm('确认要删除当天和预告无返利的商品？');">[删无]</a>&nbsp;<a style=" cursor:pointer" id="zhixingsort" title="不设置商品排序将自动随机排序当天商品" class="link3">[执行排序]</a>&nbsp;<a style="cursor:pointer" id="yulansort" target="_blank" class="link3">[排序预览]</a></td>
              <td align="right" class="bigtext">板块：<?=select($bankuai,$_GET['code'],'code')?>&nbsp;分类：<?=select($cid_arr,$_GET['cid'],'cid')?>&nbsp;商品：<input type="text" style="width:120px" name="title" value="<?=$_GET['title']?>" />&nbsp;会员名：<input style="width:80px" type="text" name="ddusername" value="<?=$_GET['ddusername']?>" /><input style="width:80px" type="hidden" name="leixing" value="<?=$_GET['leixing']?>" />&nbsp;<input type="submit" value="筛选" />&nbsp;&nbsp;</td>
            </tr>
      </table>

      <input type="hidden" name="mod" value="<?=MOD?>" />
      <input type="hidden" name="act" value="<?=ACT?>" />
      </form>
      <form name="form2" method="get" action="" style="margin:0px; padding:0px;">
      <table id="listtable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
        <tr>
          <th width="40" ></th>
          <th width="70">排序</th>
          <th width="">商品名</th>
          <th width="50">图片</th>
          <th width="70">板块</th>
		  <th width="70">分类</th>
          <th width="50">原价</th>
		  <th width="50">促销价</th>
          <!--<th width="80px">掌柜</th>-->
          <th width="80">报名人</th>
          <th width="120">开始时间</th>
          <th width="120">结束时间</th>
          <th width="120px">操作</th>
        </tr>
		<?php foreach ($data as $r){?>
	    <tr id="tr_<?=$r['id']?>">
          <td><input type='checkbox' name='ids[]' value='<?=$r["id"]?>' id='content_<?=$r["id"]?>' /></td>
          <td class="input" field='sort' url='<?=u(MOD,ACT,array('update'=>'sort'))?>' w='40' tableid="<?=$r["id"]?>" status='a' title="双击编辑"><?=is_kong($r['sort'])?></td>
          <td><a href="../<?=u('goods','view',array('id'=>$r['id']))?>" target="_blank" class="ddnowrap" style="width:220px;" title="<?=$r["title"]?>"><?=$r["title"]?></a></td>
          <td class="showpic" pic="<?=tb_img($r['img'],'200')?>">查看</td>
		  <td><?=is_kong($r['bankuai_title'])?></td>
          <td><?=$r['cid_title']?></td>
		  <td><?=$r["price"]?></td>
          <td><?php if($r["discount_price"]>0){?><?=$r["discount_price"]?><?php }?></td> 
          <!--<td><span class="ddnowrap" style="width:70px" title="<?=$r["nick"]?>"><?=$r["nick"]?></span></td>-->
          <td><span class="ddnowrap" style="width:70px" title="<?=is_kong($r['ddusername'])?>"><?=is_kong($r['ddusername'])?></span></td>
          
          <?php
			$yulan=0;
			$start_tip='';
			$end_tip='';
			if($r["starttime"]>TIME){
				$start_tip='style="color:#090" title="未开始"';
				$yulan=1;
			}
			
			if($r["endtime"]>0 && $r["endtime"]<=TIME){
				$end_tip='style="color:#F00" title="已到期"';
			}
			?>
          
          <td><span <?=$start_tip?>><?=is_kong(date('Y-m-d H:i',$r["starttime"]))?></span></td>
          <td><span <?=$end_tip?>><?=is_kong(date('Y-m-d H:i',$r["endtime"]))?></span></td>
		  <td><a href="<?=u(MOD,'addedi',array('id'=>$r['id']))?>" class=link4>修改</a></td>        </tr>
		<?php }?>
		<tr>
          <th width="40" ><input type="checkbox" onClick="checkAll(this,'ids[]')" /></th>
          <th colspan="11"><div align="left">
            <input type="hidden" name="mod" value="<?=MOD?>" />
            <input type="hidden" name="act" value="del" />
            <input type="hidden" id="do_input" name="do" value="del" />
            <input type="submit" value="删除" class="myself" onclick='return confirm("确定要删除?")'/>
          </div></th>
        </tr>
        </table>
        <div style="position:relative;">
            <div class="megas512" style=" margin-top:15px;"><?=pageft($total,$pagesize,u(MOD,ACT,$page_arr));?></div>
        </div>
</form>
<div id="paixu" style="display:none">
<div style="line-height:50px; padding-top:10px" class="alist">
<?php
$_page_arr=$page_arr;
$_page_arr['from']=u(MOD,ACT,$page_arr);
?>
<a href="<?=u(MOD,'paixu',array('from'=>u(MOD,ACT,$page_arr)))?>">按设置排序</a> &nbsp;<a href="<?=u(MOD,'paixu',$_page_arr)?>">随机排序</a>
</div>
</div>

<div id="yulan" style="display:none">
<div style="line-height:50px; padding:0px 10px; text-align:left" class="alist">
<?php foreach($bankuai_yulan as $row){?>
<a target="_blank" style="word-break:keep-all;white-space:nowrap;" href="<?=l('goods','index',array('do'=>'yulan','code'=>$row['code'],'leixing'=>$_GET['leixing']))?>"><?=$row['title']?></a> &nbsp; 
<?php }?>
</div>
</div>

<?php include(ADMINTPL.'/footer.tpl.php');?>