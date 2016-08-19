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


if($id==0){
	$row['status']=1;
}

include(ADMINTPL.'/header.tpl.php');
?>
<style>
.web_cid,.tuijian,.baoming_guanlian,.jieshao,.diaoyong_guanlian,.duofenlei,.duofenlei,.notaoapi,.data_from_guanlian{ display:none}
.w5{ width:50px}
</style> 
<script>
$(function(){
	/*$('input[name="status"]').click(function(){
		status_radio();
	});
	status_radio();*/
   	
	$('input[name="data_from"]').click(function(){
		if($(this).val()==0){
			$('.data_from_guanlian').hide();
			$('.data_from_fanguanlian').show();
		}
		else{
			$('.data_from_guanlian').show();
			$('.data_from_fanguanlian').hide();
			$("input[name='yugao']").eq(0).attr("checked","checked");
			$("input[name='baoming']").eq(0).attr("checked","checked");
			baoming_radio();
		}
	});
	if($('input[name="data_from"]:checked').val()==0){
		$('.data_from_guanlian').hide();
	}
	else{
		$('.data_from_guanlian').show();
	}
	
	$('input[name="baoming"]').click(function(){
		baoming_radio();
	});
	baoming_radio();
			
	$('input[name="tuijian"]').click(function(){
		tuijian_radio();
	});
	tuijian_radio();
	
	$('input[name="fenlei"]').click(function(){
		fenlei_radio();
	});
	fenlei_radio();
	<?php if($row['data_from']==0){?>time_type();<?php }?>
	$("input[name='time_type']").click(function(){
		time_type();
 	});
	
	<?=radio_guanlian('mobile_status')?>;
	<?=radio_guanlian('yugao')?>;
})

function baoming_radio(){
	if($("input[name='baoming']:checked").val()==1){
		$('.baoming_guanlian').show();
	}
	else{
		$('.baoming_guanlian').hide();
	}
}

function status_radio(){
	if($("input[name='status']:checked").val()==1){
		$('#addeditable tr').show();
	}
	else{
		$('#addeditable tr').hide();
		$('#addeditable tr:first').show();
		$('#addeditable tr:last').show();
	}
}

function tuijian_radio(){
	if($("input[name='tuijian']:checked").val()==1){
		$('.tuijian').show();
	}
	else{
		$('.tuijian').hide();
	}
}

function fenlei_radio(){
	$('.web_cid,.duofenlei,.danfenlei').hide();
	if($("input[name='fenlei']:checked").val()==1){
		$('.web_cid').show();
		$('.duofenlei').show();
	}
	else{
		$('.danfenlei').show();
	}
}

function time_type(){
	var time_type=$("input[name='time_type']:checked").val();
	if(time_type==0){
		$("#zj_stime").show();
		$("#gd_stime").hide();
	}else{
		$("#zj_stime").hide();
		$("#gd_stime").show();
	}
}
</script>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>&code=<?=$code?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115px" align="right">状态：</td>
    <td>&nbsp;<?=html_radio($zhuangtai_arr,$row['status'],'status')?> <span class="zhushi"><a href="http://bbs.duoduo123.com/read-1-1-198005.html" target="_blank">添加教程</a></span></td>
  </tr>
  <tr>
    <td align="right">板块名称：</td>
    <td>&nbsp;<input type="text" id="title" name="title" value="<?=$row['title']?>" /></td>
  </tr>
  <tr>
    <td align="right">板块标识码：</td>
    <td>&nbsp;<?php if($row['code']){?><?=$row['code']?><input type="hidden" name="code" value="<?=$row['code']?>" />&nbsp;&nbsp;&nbsp;<span class="zhushi">设置后不可修改</span><?php }else{?><input type="text" id="code" name="code" value="<?=$row['code']?>" /> <span class="zhushi">建议使用建议的拼音或者英文缩写，如jiu，zhidemia，不能重复，创建后不能修改。</span><?php }?></td>
  </tr>
  <tr>
    <td align="right">版块Banner：</td>
    <td>&nbsp;<input name="banner_img" id="banner_img" value="<?=$row['banner_img']?>"> <input class="sub" type="button"  value="上传图片" onclick="javascript:openpic('<?=u('fun','upload',array('uploadtext'=>'banner_img','sid'=>session_id()))?>','upload','450','350')" /> <span class="zhushi">可直接添加网络地址，可留空，仅对应版块页面才显示，图片制作注意参考模板说明</span></td>
  </tr>
  <tr>
    <td align="right">banner背景色：</td>
    <td>
    <table border="0" class="yanse">
    <tr>
    <td>&nbsp;<input name="banner_color" id="banner_color" value="<?=$row['banner_color']?>"> </td>
    <?=seban()?>
    <td><span class="zhushi">16进制色值</span></td>
  </tr>
</table>
    </td>
  </tr> 
  
  <tr>
    <td align="right">页面背景色：</td>
    <td>
    <table border="0" class="yanse">
    <tr>
    <td>&nbsp;<input name="bg_color" id="bg_color" value="<?=$row['bg_color']?>"> </td>
    <?=seban()?>
    <td><span class="zhushi">16进制色值</span></td>
  </tr>
</table>
    </td>
  </tr>
  
  <tr>
    <td align="right">全局置顶商品：</td>
    <td>&nbsp;<?=html_radio($quanju_arr,$row['quanju'],'quanju')?> <span class="zhushi">是否调用全局置顶商品</span></td>
  </tr>
  <tr>
    <td align="right">WAP首页调用：</td>
    <td>&nbsp;<?=html_radio($zhuangtai_arr,$row['mobile_status'],'mobile_status')?> <span class="zhushi">无线只支持淘宝商品，板块里的其他类型商品会自动过滤</span></td>
  </tr>
  <tbody class="mobile_status_guanlian" style="display:none">
  <tr>
    <td align="right">图标：</td>
    <td>&nbsp;<input name="mobile_logo" id="mobile_logo" value="<?=$row['mobile_logo']?>"> <input class="sub" type="button"  value="上传图片" onclick="javascript:openpic('<?=u('fun','upload',array('uploadtext'=>'mobile_logo','sid'=>session_id()))?>','upload','450','350')" /> <span class="zhushi">可直接添加网络地址，开启无线后不可留空，建议大小：60*60</span></td>
  </tr>
  </tbody>
  <tr>
    <td align="right">列表样式：</td>
    <td>&nbsp;<?=select($bankuai_tpl_arr,$row['bankuai_tpl'],'bankuai_tpl')?> <span class="zhushi">商品显示的列表形式，具体可参考模板说明内解释</span></td>
  </tr>
  <tr>
    <td align="right">分类显示：</td>
    <td>&nbsp;<?=html_radio($fenlei_arr,$row['fenlei'],'fenlei')?><span class="web_cid"><?php foreach($web_cid_arr as $k=>$v){?><label><input <?php if(in_array($k,$row['web_cid'])){?>checked<?php }?><?php if(empty($row['id'])){?>checked<?php }?> name="web_cid[<?=$k?>]" type="checkbox" value="<?=$k?>" /><?=$v?></label><?php }?></span>
 	<span class="zhushi web_cid">按需要选择，不显示留空，可多选。<a href="index.php?mod=goods_type&act=list">增加</a></span></td>
  </tr>
  <tr>
    <td align="right">数据来源：</td>
    <td>&nbsp;<?=html_radio($data_from_arr,$row['data_from'],'data_from')?> <span class="zhushi">淘宝api只能展示淘宝类商品</span> <?php if(HASAPI==0){?><span class="data_from_guanlian zhushi notaoapi">对不起！您暂时无APi权限，请先申请再使用，如果已申请，请先设置。 <a href="index.php?mod=tradelist&act=set">设置</a> <a href="http://club.alimama.com/read.php?spm=0.0.0.0.My2EIN&tid=6306396&ds=1&page=1&toread=1" target="_blank">申请API</a></span><?php }?></td>
  </tr>
  <?php if(HASAPI==1){?>
  <tr class="data_from_guanlian">
    <td align="right">对应分类：</td>
    <td class="duofenlei">
      <table border="0" cellspacing="0" cellpadding="0" style=" text-align:center">
        <tr>
          <td width="100">板块分类</td>
          <td>淘宝分类<span class="zhushi">（分类和关键词至少设置一项）</span></td>
        </tr>
         <?php foreach($web_cid_arr as $wk=>$wv){?>
        <tr>
            <td><?=$wv?></td>
            <td><?=select($api_cid_arr,$row['yun_cid'][$wk]['cat'],'yun_cid['.$wk.'][cat]')?> 关键字：<input type="text" style="width:60px;" name="yun_cid[<?=$wk?>][q]" value="<?=$row['yun_cid'][$wk]['q']?>" /></td>
            </tr>
            <?php }?>
                    </table>
      </td>
      <td class="danfenlei">&nbsp;<?=select($api_cid_arr,$row['dan_api']['cat'],'dan_api[cat]')?> <input type="text" name="dan_api[q]" value="<?=$row['dan_api']['q']?>" style="width:60px;" /> <span class="zhushi">分类和关键词至少设置一项</span></td>
  </tr>
  <tr class="data_from_guanlian">
    <td align="right">数据排序：</td>
    <td>&nbsp;<?=html_radio($api_sort_arr,$row['api_sort']?$row['api_sort']:'total_sales_des','api_sort')?></td>
  </tr>
  <?php }?>
  
  <tr class="data_from_fanguanlian" <?php if($row['data_from']==1){?>style="display:none"<?php }?>>
    <td align="right">预告：</td>
    <td>&nbsp;<?=html_radio($yugao_arr,$row['yugao'],'yugao')?> <span class="zhushi">是否开启预告链接</span></td>
  </tr>
  <tr class="yugao_guanlian">
    <td align="right">预告时间：</td>
    <td>&nbsp;每日：<input name="yugao_time" type="text" id="yugao_time" value="<?=$row['yugao_time']?>" style="width:80px; text-align:center" />&nbsp;<span class="zhushi">例如：10:00，即每日10：00 才能点击查看。</span></td>
  </tr>
  <tr class="data_from_fanguanlian" <?php if($row['data_from']==1){?>style="display:none"<?php }?>>
    <td align="right">活动开始：</td>
    <td>&nbsp;每日：<input name="huodong_time" type="text" id="huodong_time" value="<?=$row['huodong_time']?>" style="width:80px; text-align:center" />点&nbsp;<span class="zhushi">例如：15点开始，必须使用24小时制。</span></td>
  </tr>
  <tr class="data_from_fanguanlian" <?php if($row['data_from']==1){?>style="display:none"<?php }?>>
    <td align="right">商家报名：</td>
    <td>&nbsp;<?=html_radio($baoming_arr,$row['baoming'],'baoming')?><?php if($webset['shangjia']['status']==0){?><a href="<?=u('shangjia','set')?>">您的商家报名当前是关闭状态，请先开启</a><?php }?></td>
  </tr>
  <tr class="baoming_guanlian">
    <td align="right">板块图标：</td>
    <td>&nbsp;<input name="bankuai_img" id="bankuai_img" value="<?=$row['bankuai_img']?>"> <input class="sub" type="button"  value="上传图片" onclick="javascript:openpic('<?=u('fun','upload',array('uploadtext'=>'bankuai_img','sid'=>session_id()))?>','upload','450','350')" /> <span class="zhushi">可直接添加网络地址，显示在商家报名页面，建议大小：142*142像素</span></td>
  </tr>
  <tr class="baoming_guanlian">
    <td align="right">板块介绍：</td>
    <td>&nbsp;<textarea style="width:680px; height:80px" name="bankuai_desc" id="content"><?=$row['bankuai_desc']?></textarea> <span class="zhushi">显示在商家报名页面图标的下面</span></td>
  </tr>
  <tr class="baoming_guanlian">
    <td align="right">鹊桥地址：</td>
    <td>&nbsp;<input type="text" id="url" name="url" value="<?=$row['url']?>" style="width:300px" /><span class="zhushi">如果填写了直接会跳转阿里妈妈鹊桥报名地址页面。否则站内提交</span></td>
  </tr>
  <tr>
    <td align="right">排序：</td>
    <td>&nbsp;<input type="text" id="sort" name="sort" value="<?=(int)$row['sort']?>" style="width:60px" /> <span class="zhushi">排序越小越靠前</span></td>
  </tr>
  <tr>
    <td align="right">首页推荐：</td>
    <td>&nbsp;<?=html_radio($tuijian_arr,$row['tuijian'],'tuijian')?> </td>
  </tr>
  <tr class="data_from_fanguanlian" <?php if($row['data_from']==1){?>style="display:none"<?php }?>>
    <td align="right">默认开始时间：</td>
    <td>&nbsp;<label><input <?php if($row['time_type']==0){?>checked="checked"<?php }?>  name="time_type" type='radio' value='0' />直接开始</label> <label><input <?php if($row['time_type']==1){?>checked="checked"<?php }?> name="time_type" type='radio' value='1' />固定时间</label> <span class="zhushi"></span></td>
  </tr>
  <tr id="zj_stime" class="data_from_fanguanlian" <?php if($row['data_from']==1){?>style="display:none"<?php }?>>
    <td align="right">直接开始时间：</td>
    <td>&nbsp;<input name="zj_stime" type="text" id="nick" value="<?=(int)$row['zj_stime']?>"  style="width:80px; text-align:center" />小时后 <span class="zhushi">0为马上开始，如“10”即添加后10小时后显示</span></td>
  </tr>
  <tr id="gd_stime" class="data_from_fanguanlian" <?php if($row['data_from']==1){?>style="display:none"<?php }?>>
    <td align="right">固定开始时间：</td><!--仅选择固定时间开始出现-->
    <td>&nbsp;<label><input <?php if($row['gd_stime']==0){?>checked="checked"<?php }?> name='gd_stime' type='radio' value='0' />今天</label> <label><input <?php if($row['gd_stime']==1){?>checked="checked"<?php }?> name='gd_stime' type='radio' value='1' />明天</label> <input name="gd_minute" type="text" id="nick" value="<?=$row['gd_minute']?>" style="width:80px; text-align:center" /> <span class="zhushi">注意时间格式：“7:00”，设置分无效，最小到小时</span></td>
  </tr>
  <tr class="data_from_fanguanlian" <?php if($row['data_from']==1){?>style="display:none"<?php }?>>
    <td align="right">默认结束时间：</td>
    <td>&nbsp;<input name="etime" type="text" id="etime" value="<?=(int)$row['etime']==0?30:(int)$row['etime']?>" style="width:80px; text-align:center" /> 天后 <span class="zhushi">以天为单位</span></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="id" value="<?=$row['id']?>" /><input type="hidden" name="mobile_title" value="" /><input type="submit" class="sub" name="sub" value=" 保 存 " /></td>
  </tr>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>