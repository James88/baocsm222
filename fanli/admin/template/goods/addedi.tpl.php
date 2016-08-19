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
$credit=include(DDROOT.'/data/tao_level.php');
$credit[21]='天猫商城';
?>
<style>
.tpxzf{float:left; width:80px; height:80px; margin-right:5px; cursor:pointer; }
.tpxzb{border:2px solid #666}
</style>
<script>
window.alert = function(text,cb) {
	_alert(text,cb);
}

SITEURL="<?=SITEURL?>/";
CURURL="<?=CURURL?>/";
function getTaoItem(url){
    if(url==''){
		alert('网址不能为空！');
		return false;
	}	
	var ajax_url='<?=u('goods','addedi')?>&url='+encodeURIComponent(url)+'&t=<?=time()?>';
	$('#getGoodsItem').attr('disabled',true).val('数据获取中...');
	$.getJSON(ajax_url,function(result){
		$('#getGoodsItem').attr('disabled',false).val('获取商品信息');
		if(result.s==0){
			alert(result['r']);
			return false;
		}
		data=result['r'];
		if(typeof result.tip!='undefined' && result.tip!=''){
			alert(result.tip);
		}
		<?php if(empty($row['id'])){?>
		if(data['cun']==1){
			if (!confirm("该商品已经存在，确认添加？")) {
				return;
			}
		}
		<?php }?>
		for(var i in data){
			if(i=='baoyou'){/*大于0表示不包邮*/
				if(data[i]==0){
					$('input:radio[name="baoyou"]').eq(0).attr("checked",'checked');
				}else{
					$('input:radio[name="baoyou"]').eq(1).attr("checked",'checked');
				}
			}else if(i=='shop_url'){
				$("#shop_url").attr('href',data[i]);
			}else{
				$('#'+i).val(data[i]);
			}
		}
		
		if(typeof data['small_images']!='undefined'){
			var html='';
			for(var i in data['small_images']){
				if(i==0){
					var c='tpxzf tpxzb';
				}
				else{
					var c='tpxzf';
				}
				html+='<img onclick="setTp($(this))" class="'+c+'" src="'+data['small_images'][i]+'_80x80.jpg" />'
			}
			$('#tpxztr').show().find('td:eq(1)').html(html);
		}
	});
}

function setTp($t){
	var src=$t.attr('src');
	$('#tpxztr img').removeClass('tpxzb');
	$t.addClass('tpxzb');
	src=src.replace('_80x80.jpg','');
	$('#img').val(src);
}

$(function(){
	$("#shouji_price_btn").click(function(){
		if($("#laiyuan_type").val()>2||$("#laiyuan_type").val()==0){
			alert("目前只限淘宝");return;
		}
		var url='<?=u(MOD,'addedi',array('do'=>'shouji_price'))?>&url='+encodeURIComponent($("#url").val())+'&t=<?=time()?>';
		$.getJSON(url,function(data){
			if(data>0){
				$("#shouji_price").val(data);
			}else{
				alert('无法自动获取手机价格');
			}
		});
	});
	
	$('#shop_url').click(function(){
		var url=$('#lq_url').val();
		if(url==''){
			alert('地址为空');
			return false;
		}
		else{
			$("#shop_url").attr('href',url);
		}
	});
	$('#code').change(function(){
		var code=$("#code").val();
		$.getJSON('<?=u(MOD,'addedi',array('do'=>'shijian'))?>&code='+code,function(data){
			$("#sdatetime").val(data.starttime);
			$("#edatetime").val(data.endtime);
			$("#edatetime_url").attr('href',"index.php?mod=bankuai&act=addedi&code="+code);
		});
	})
})
</script>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>&code=<?=$code?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115" align="right">使用教程：</td>
    <td>&nbsp;<span class="zhushi"><a href="http://bbs.duoduo123.com/read-1-1-198283.html" target="_blank">查看教程</a></span></td>
  </tr>
  <tr>
    <td width="115" align="right">商品网址：</td>
    <td>&nbsp;<input type="text" id="url" name="url" value="<?=$row['url']?>" style="width:300px" /> <input onClick="getTaoItem($('#url').val())" class="sub" id="getGoodsItem" type="button" value="获取商品信息" /><span class="zhushi tishi"></span></td>
  </tr>
   <tr>
    <td align="right">所属商城：</td>
    <td>&nbsp;<input name="laiyuan" type="text" id="laiyuan" value="<?=$row['laiyuan']?>" /></td>
  </tr>
  <tr>
    <td align="right">商品分类：</td>
    <td>&nbsp;<?=select($cid_arr,$row['cid'],'cid')?> <span class="zhushi"><a href="<?=u('goods_type','addedi')?>">增加</a></span></td>
  </tr>
<tr>
    <td align="right">版块分类：</td>
    <td>&nbsp;<?=select($bankuai,$row['code'],'code')?> <span class="zhushi"><a href="<?=u('bankuai','addedi')?>">增加</a></span></td>
  </tr>
  <tr>
    <td align="right">商品名称：</td>
    <td>&nbsp;<input name="title" type="text" id="title" value="<?=$row['title']?>" style="width:300px" /></td>
  </tr>
  <?php
  $img=tb_img($row['img'],50);
  if(!preg_match('/^http/',$img)){
     $img='../'.$img;
  }
  ?>
  <tr>
    <td align="right">图片：</td>
    <td>&nbsp;<input name="img" type="text" id="img" value="<?=$row['img']?>" style="width:300px"  /><?php if($row['img']!=''){?><img style="width:25px; height:25px; margin-bottom:-8px; *margin-bottom:-6px;" src="<?=$img?>" /><?php }?>  <input onClick="javascript:openpic('<?=u('fun','upload',array('uploadtext'=>'img','sid'=>session_id()))?>','upload','450','350')" class="sub" type="button" value="上传" /> <span class="zhushi">可使用远程图片地址 <a href="<?=SITEURL.'/'.$row['img']?>" target="_blank">查看</a></span></td>
  </tr>
  <tr <?php if(empty($row['small_images'])){?>style="display:none"<?php }?> id="tpxztr">
    <td align="right">图片选择：</td>
    <td style="padding:5px;">
	<?php 
	foreach($row['small_images'] as $v){
		if($v==$row['img']){
			$c='tpxzf tpxzb';
		}
		else{
			$c='tpxzf';
		}
	?>
    <img onclick="setTp($(this))" class="<?=$c?>" src="<?=$v?>_80x80.jpg" />
	<?php }?></td>
  </tr>
  <tr>
    <td align="right">现价：</td>
    <td>&nbsp;<input style="width:60px" name="discount_price" type="text" id="discount_price" value="<?=$row['discount_price']?>" />  原价：<input style="width:60px" name="price" type="text" id="price" value="<?=$row['price']?>" /> 手机价：<input name="shouji_price" style="width:60px" type="text" id="shouji_price" value="<?=$row['shouji_price']?>" /> <input class="sub" type="button" id="shouji_price_btn" value="查询" /> <span class="zhushi">可空，有手机专享价格再加,目前只限淘宝</span></td>
  </tr>
  <tr>
    <td align="right">属性：</td>
    <td>&nbsp;<?php foreach($goods_attribute as $kk=>$attr){?><label><input <?php if(in_array($attr['id'],$row['goods_attribute'])){?>checked="checked"<?php }?> name='goods_attribute[<?=$kk?>]' type='checkbox' value='<?=$attr['id']?>' />  <?=$attr['title']?></label><?php }?><span class="zhushi"> 可多选；<a href="index.php?mod=goods_attribute&act=list">增加</a></span>
     </td>
  </tr>
  <tr>
    <td align="right">推荐理由：</td>
    <td>&nbsp;<textarea id="content" name="content"><?=$row['content']?></textarea> <br /> <span class="zhushi" style=" padding:5px;">可留空，值得买版块一般需要加</span></td>
  </tr>
  <tr>
    <td align="right">开始时间：</td>
    <td>&nbsp;<input name="starttime" type="text" id="sdatetime" value="<?php if(empty($row['id'])){echo date('Y-m-d H:i:s',$starttime);}else{echo date('Y-m-d H:i:s',$row['starttime']?$row['starttime']:'');}?>" /></td>
  </tr>
  <tr>
    <td align="right">结束时间：</td>
    <td>&nbsp;<input name="endtime" type="text" id="edatetime" value="<?php if($row['endtime']>0){echo date('Y-m-d H:i:s',$row['endtime']);}elseif($row['id']==0){echo date('Y-m-d H:i:s',time()+7*24*3600);}?>" /> <span class="zhushi"><a id="edatetime_url" href="index.php?mod=bankuai&act=addedi&code=<?=$row['code']?>">修改默认</a></span></td>
  </tr>
    <tr>
    <td align="right">总佣金比例：</td>
    <td>&nbsp;<input name="fanli_bl" type="text" id="fanli_bl" value="<?=$row['fanli_bl']?>"  style="width:60px"/>% &nbsp;</span> 加高返利图标：<label><input <?php if(empty($row['fanli_ico'])){?>checked="checked"<?php }?> name='fanli_ico' type='radio' value='0' />不</label>&nbsp;&nbsp;<label><input <?php if($row['fanli_ico']==1){?>checked="checked"<?php }?> name='fanli_ico' type='radio' value='1' />是</label> <span class="zhushi">如果是则显示高返图章</span></td>
  </tr>
  <tr>
    <td align="right">优惠券：</td>
    <td>&nbsp;满：<input name="price_man" type="text" id="price_man" value="<?=$row['price_man']?>"  style="width:50px"/> 立减 <input name="price_jian" type="text" id="price_jian" value="<?=$row['price_jian']?>"  style="width:50px"/> 领取地址：<input name="lq_url" type="text" id="lq_url" value="<?=$row['lq_url']?>" style="width:300px" /> <span class="zhushi">可空<?php if($row['lq_url']){?>，<a href="<?=$row['lq_url']?>" id="shop_url" target="_blank">去查看</a><?php }?></span></td>
  </tr>
   <tr>
    <td align="right">专属推广地址：</td>
    <td>&nbsp;<input name="tg_url" type="text" id="tg_url" value="<?=$row['tg_url']?>" style="width:300px"  /> <span class="zhushi">阿里妈妈获取的专属推广地址</span></td>
  </tr>
  <tr class="extend_line"><td colspan="2">高级设置（请点击）</td></tr>
  <tbody class="gaojiset">
  <tr>
    <td align="right">掌柜：</td>
    <td>&nbsp;<input name="nick" type="text" id="nick" value="<?=$row['nick']?>" /></td>
  </tr>
  <tr>
    <td align="right">销量：</td>
    <td>&nbsp;<input name="sell" type="text" id="sell" value="<?=(int)$row['sell']?>" /></td>
  </tr>
  <tr>
    <td align="right">状态：</td>
    <td>&nbsp;<?=html_radio($oversell_arr,$row['oversell'],'oversell')?></td>
  </tr>
  <tr>
    <td align="right">顶：</td>
    <td>&nbsp;<input name="ding" type="text" id="ding" value="<?=$row['ding']?>" /></td>
  </tr>
  <tr>
    <td align="right">踩：</td>
    <td>&nbsp;<input name="cai" type="text" id="cai" value="<?=$row['cai']?>" /></td>
  </tr>
  <tr>
    <td align="right">评论人数：</td>
    <td>&nbsp;<input name="pinglun" type="text" id="pinglun" value="<?=$row['pinglun']?>" /><?php if($row['id']){?><span class="zhushi"><a href="<?=u('goods_comment','list',array('data_id'=>$row['id']))?>">查看评论</a></span><?php }?></td>
  </tr>
  <tr>
    <td align="right">审核人：</td>
    <td>&nbsp;<input name="auditor" type="text" id="auditor" value="<?=$row['auditor']?>" /></td>
  </tr>
  <tr>
    <td align="right">会员名：</td>
    <td>&nbsp;<input type="text" id="ddusername" name="ddusername" value="<?php $uid=$row['uid']?$row['uid']:$_GET['uid']; if($uid){echo $duoduo->select('user','ddusername','id='.$uid);}?>" /> <span class="zhushi">可为空</span></td>
  </tr>
  <tr>
    <td align="right">添加时间：</td>
    <td>&nbsp;<?=date('Y-m-d H:i:s',$row['addtime']?$row['addtime']:time())?></td>
  </tr>
  <tr>
    <td align="right">cpc推广：</td>
    <td>&nbsp;<?=html_radio($zhuangtai_arr,$row['yun_jump'],'yun_jump')?><span class="zhushi">cpc推广相关以活动公告为准，<a href="http://bbs.duoduo123.com/thread-page-1-80.html" target="_blank">查看</a></span></td>
  </tr>
  </tbody>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="laiyuan_type" id="laiyuan_type" value="<?=(int)$row['laiyuan_type']?>" /><input type="hidden" name="data_id" id="data_id" value="<?=$row['data_id']?>" /><input type="hidden" name="id" value="<?=$row['id']?>" /><input type="submit" class="sub" name="sub" value=" 保 存 " /></td>
  </tr>
</table>
</form>
<script>
$(function(){
	$.ajax({
		url: "<?=u('goods','addedi',array('do'=>'tishi'))?>",
		dataType:'json',
		success: function(data){
			$(".tishi").html(data.r);
		}
	});
});
</script>
<?php include(ADMINTPL.'/footer.tpl.php');?>