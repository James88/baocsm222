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
	$('.zhiding').jumpBox({
		title: '设置数据置顶位置和时间',
		titlebg:1,
		LightBox:'show',
		height:220,
		width:350,
		jsCode2:'setContain($(this),$content)',
		contain:$('#html_c').html()
	})
})

function setContain($t,$content){
	var $html_c=$content;
	var top=$t.attr('top');
	var id=$t.attr('data_id');
	var topStime=$t.attr('top_stime');
	var topEtime=$t.attr('top_etime');
	topStime=date(topStime);
	if(topEtime==0){topEtime=strtotime()+86400*3;}
	topEtime=date(topEtime);
	$html_c.find('input[name="top"]:eq('+top+')').attr('checked',true);
	$html_c.find('#top_stime').val(topStime);
	$html_c.find('#top_etime').val(topEtime);
	$html_c.find('#data_id').val(id);
	
	$html_c.find('#top_stime').calendar({format:'yyyy-MM-dd HH:mm:ss'});
	$html_c.find('#top_etime').calendar({format:'yyyy-MM-dd HH:mm:ss'}); 
}

function subSetTop($t){
	var action=$t.attr('action');
	var url=action+"?"+$t.serialize();
	$.getJSON(url,function(data){
		if(data.top>0){
			if(data.top==1){
				var top_fanwei='本版置顶';
			}
			else{
				var top_fanwei='全局置顶';
			}
			var str='<span title="'+'置顶时间：'+data.top_stime+'——'+data.top_etime+'">'+top_fanwei+'</span>';
		}
		else{
			var str='<?=is_kong()?>';
		}
		$('#td_top_'+data.id).html(str);
		$('#td_a_'+data.id).attr('top',data.top);
		$('#td_a_'+data.id).attr('top_stime',strtotime(data.top_stime));
		$('#td_a_'+data.id).attr('top_etime',strtotime(data.top_etime));
		jumpboxClose();
	});
	return false;
}
</script>
<style>
.jumpbox .middle_center p.title { margin-top:10px}
.jumpbox .middle_center .contain{line-height:35px;}
.jumpbox .middle_center .contain .inp{border:1px solid #ccc;padding:5px;}

.alist{ text-align:center}
.alist a,.alist a:visited{font-size:18px; color:#F30; text-decoration:underline}
</style>
<div style="display:none" id="html_c">
<form action="index.php" onsubmit="return subSetTop($(this))">置顶位置<label><input type="radio" checked name="top" value="0">无</label>&nbsp;<label><input type="radio" name="top" value="1">本版</label>&nbsp;<label><input type="radio" name="top" value="2">全局</label><br/>开始时间&nbsp;<input class="inp" value="" id="top_stime" name="top_stime"><br/>结束时间&nbsp;<input class="inp" id="top_etime" name="top_etime" value=""><br/><input style="margin-left:90px; margin-top:10px; padding:5px 10px" name="sub" type="submit" value="确定"/><input type="hidden" name="mod" value="<?=MOD?>"/><input type="hidden" name="act" value="<?=ACT?>"/><input type="hidden" name="do" value="set_top"/><input type="hidden" id="data_id" name="id" value=""/></form>
</div>
<form name="form1" action="" method="get">

<table cellspacing="0" width="100%" style="border:1px  solid #DCEAF7; border-bottom:0px; background:#E9F2FB">
        <tr>
              <td class="bigtext">&nbsp;<img src="images/arrow.gif" width="16" height="22" align="absmiddle" />&nbsp;<a href="<?=u(MOD,'addedi')?>" class="link3">[添加商品]</a>&nbsp;<a href="<?=u(MOD,'s_list')?>"  title="点击去排序" class="link3">[排序商品]</a>&nbsp;<?php if($_GET['reycle']==1){?><a href="<?=u(MOD,ACT)?>" class="link3">[返回列表]</a><?php }else{?><a href="<?=u(MOD,ACT,array('reycle'=>1))?>" class="link3">[回收站]</a><?php }?>&nbsp;<a href="<?=u(MOD,ACT,array('guoqi'=>1))?>" title="删除到期商品" class="link3" onclick="return confirm('确认要删除到期商品？');">[删过]</a>&nbsp;</td>
              <td align="right" class="bigtext">板块：<?=select($bankuai,$_GET['code'],'code')?>&nbsp;类型：<?=select($leixing_arr,$_GET['leixing'],'leixing')?>&nbsp;分类：<?=select($cid_arr,$_GET['cid'],'cid')?>&nbsp;<?=select($shangpin_s_arr,$_GET['shangpin_s'],'shangpin_s')?>：<input type="text" style="width:120px" name="title" value="<?=$_GET['title']?>" />&nbsp;会员名：<input style="width:80px" type="text" name="ddusername" value="<?=$_GET['ddusername']?>" />&nbsp;<input type="submit" value="筛选" />&nbsp;&nbsp;</td>
            </tr>
      </table>

      <input type="hidden" name="mod" value="<?=MOD?>" />
      <input type="hidden" name="act" value="<?=ACT?>" />
      </form>
      <form name="form2" method="get" action="" style="margin:0px; padding:0px;">
      <table id="listtable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
        <tr>
          <th width="40px" ><input type="checkbox" onClick="checkAll(this,'ids[]')" /></th>
          <th width="80px">置顶</th>
          <th width="">商品名</th>
          <th width="50px">图片</th>
          <th width="70px">板块</th>
		  <th width="70px">分类</th>
          <th width="50px">原价</th>
		  <th width="50px">促销价</th>
          <!--<th width="80px">掌柜</th>-->
          <th width="80px">报名人</th>
          <th width="120px">开始时间</th>
          <th width="120px">结束时间</th>
          <th width="120px">操作</th>
        </tr>
		<?php foreach ($data as $r){?>
	    <tr id="tr_<?=$r['id']?>">
          <td><input type='checkbox' name='ids[]' value='<?=$r["id"]?>' id='content_<?=$r["id"]?>' /></td>
          <td id="td_top_<?=$r['id']?>"><?php if($r["top"]>0){?> <span title="<?php echo "置顶时间：".date('Y-m-d H:i:s',$r['top_stime']).'——'.date('Y-m-d H:i:s',$r['top_etime']);?>"><?php if($r['top']==1){echo "本版置顶";}else{echo "全局置顶";if($r['top_etime']>0&&$r['top_etime']<TIME){echo "到期";}};?></span><?php }else{echo is_kong();}?></td>
          <td><a href="../<?=u('goods','view',array('code'=>$r['code'],'id'=>$r['id']))?>" target="_blank" class="ddnowrap" style="width:220px;" title="<?=$r["title"]?>"><?=$r["title"]?></a></td>
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
		  <td><a href="<?=u(MOD,'addedi',array('id'=>$r['id']))?>" class=link4>修改</a> <a id="td_a_<?=$r['id']?>" data_id="<?=$r['id']?>" top="<?=$r['top']?>" top_stime="<?=$r['top_stime']?>" top_etime="<?=$r['top_etime']?>" style="cursor:pointer" class="link4 zhiding">置顶</a></td>
        </tr>
		<?php }?>
		<tr>
          <th width="40" ><input type="checkbox" onClick="checkAll(this,'ids[]')" /></th>
          <th colspan="100"><div align="left" style="padding-left:10px">
            <input type="hidden" name="mod" value="<?=MOD?>" /><input type="hidden" name="act" value="del" />
            <?php if($reycle==1){?>
            <input type="hidden" id="do_input" name="do" value="del" /><input type="submit" value="删除" class="myself" onclick='return confirm("确定要删除?")'/> &nbsp;<input type="submit" value="还原" class="myself" onclick='$("#do_input").val("reset");return confirm("确定要还原?")'/>
            <?php }else{?>
			<input type="submit" value="删除" class="myself" onclick='return confirm("确认要删除转移到回收站?")'/>
            <?php }?>
          </div></th>
        </tr>
        </table>
        <div style="position:relative; padding-bottom:10px">
            <div class="megas512" style=" margin-top:15px;"><?=pageft($total,$pagesize,u(MOD,ACT,$page_arr));?></div>
            </div>
       </form>
<div id="paixu" style="display:none">
<div style="line-height:50px;" class="alist">
<a href="<?=u(MOD,'paixu')?>">排序商品</a> &nbsp;<a href="<?=u(MOD,'paixu')?>">随机排序</a>
</div>
</div>

<div id="yulan" style="display:none">
<div style="line-height:50px; padding:0px 10px; text-align:left" class="alist">
<?php foreach($bankuai_yulan as $row){?>
<a target="_blank" style="word-break:keep-all;white-space:nowrap;" href="<?=l('goods','index',array('do'=>'yulan','code'=>$row['code']))?>"><?=$row['title']?></a> &nbsp; 
<?php }?>
</div>
</div>

<?php include(ADMINTPL.'/footer.tpl.php');?>