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
<style>
.ddopen,.taoopen,.baoming_guanlian,.jieshao,.diaoyong_guanlian,.guize_guanlian{display:none}
</style> 
<script>
function isExistOption(id,value) {
	var isExist = false;
	var count = $('#'+id).find('option').length;
	for(var i=0;i<count;i++){
		if($('#'+id).get(0).options[i].value == value){
			isExist = true;
			break;
		}
	}
	return isExist;
}

$(function(){
	$('input[name="laiyuan"]').click(function(){
		checked_radio("laiyuan");
	});
	checked_radio("laiyuan");
	
	$('#guize').change(function(){
		guige_select($(this));
		if($(this).find("option:selected").text()=='自定义'){
			alert('自定义规则为开发者所用，普通站长无需理会');
		}
	});
	<?php if($row['api_url']==''){?>
	guige_select($('#guize'));
	<?php }?>
	
	var a=$('#api_url').val();
	if(isExistOption('guize',a)){
		$('#guize').val(a);
	}
	else{
		$('#guize').val('');
	}
})
function checked_radio(name){
	$('.taoopen,.ddopen').hide();
	if($("input[name='"+name+"']:checked").val()==2){
		$('.taoopen').show();
	}
	else{
		$('.ddopen').show();
	}
}

function guige_select($t){
	$('#api_url').val($t.val());
}
</script>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>&code=<?=$code?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115" align="right">状态：</td>
    <td>&nbsp;<?=html_radio($zhuangtai_arr,$row['status'],'status')?> <span class="zhushi"><a href="http://bbs.duoduo123.com/read-1-1-198007.html" target="_blank">添加教程</a></span></td>
  </tr>
  <tr>
    <td align="right">规则名称：</td>
    <td>&nbsp;<input type="text" id="title" name="title" class="required" value="<?=$row['title']?>" /></td>
  </tr>
  <tr>
    <td align="right">规则备注：</td>
    <td>&nbsp;<input type="text" id="beizhu" name="beizhu" value="<?=$row['beizhu']?>" style="width:300px" /> <span class="zhushi">规则备注，没有可留空</span></td>
  </tr>
  <tr>
    <td align="right">采集版块：</td>
    <td>&nbsp;<?=select($bankuai_arr,$row['code'],'code')?></td>
  </tr>
  <tr>
    <td align="right">数据来源：</td>
    <td>&nbsp;<?=html_radio($laiyuan_arr,$row['laiyuan']?$row['laiyuan']:1,'laiyuan')?> <span class="zhushi">淘宝API仅有权限方可使用。 <a href="http://bbs.duoduo123.com/read-1-1-198076.html" target="_blank">申请API</a></span></td>
  </tr>
  <tbody class="ddopen">
  <tr>
    <td align="right">第三方规则地址：</td>
    <td>&nbsp;<input type="text" id="api_url" name="api_url" value="<?=$row['api_url']?>"  style="width:300px;"/>
    <select id="guize">
    <?php foreach($collect_api_list as $collect_api){?>
    <option value="<?=$collect_api['url']?>"><?=$collect_api['title']?></option>
    <?php }?>
    <option value="">自定义</option>
    </select> <span class="zhushi">可根据自己需要设置采集内容，<a href="http://soft.duoduo123.com/duoduo/caiji/" target="_blank">设置个性需求</a></span></td>
  </tr>
  <tr>
    <td align="right">价格区间：</td>
    <td>&nbsp;<input style="width:50px" name="sprice" value="<?=(float)$row['sprice']?>" type="text">— <input name="eprice" style="width:50px"  value="<?=(float)$row['eprice']?>" type="text"> <span class="zhushi">0为不限制</span></td>
  </tr>
  <tr>
    <td align="right">包含分类：</td>
    <td>
      <table width="200" border="0" cellspacing="0" cellpadding="0" style=" text-align:center">
        <tr>
          <td>规则分类</td>
          <td>本站分类</td>
        </tr>
        <?php foreach($goods_type as $type_key=>$type_title){$i++?>
        <tr>
            <td><input type="hidden" name="yun_cid[<?=$i?>][yun]" value="<?=$type_key?>"><?=$type_title?></td>
            <td id="yun_cid_<?=$i?>"><select name="yun_cid[<?=$i?>][bendi]">
            <?php foreach($cid_arr as $cid_key=>$cid_title){?><option <?php if($row['yun_cid'][$i]["bendi"]&&$row['yun_cid'][$i]["bendi"]==$cid_key){?>selected<?php }elseif($cid_key==$type_key){?> selected<?php }?> value="<?=$cid_key?>"><?=$cid_title?></option><?php }?>
            </select></td>
            </tr>
            <?php }?>
        </table>
      </td>
  </tr>
  </tbody>
  <tbody class="taoopen">
  <?php if(HASAPI==0){?>
  <tr>
    <td colspan="2" align="left">&nbsp; <span class="zhushi">对不起！您暂时无APi权限，请先申请再使用，如果已申请，请先设置。 <a href="index.php?mod=tradelist&act=set">设置</a> <a href="http://club.alimama.com/read.php?spm=0.0.0.0.My2EIN&tid=6306396&ds=1&page=1&toread=1" target="_blank">申请API</a></span></td>
    </tr>
    <?php }else{?>
    <tr>
    <td align="right">入库分类：</td>
    <td>&nbsp;<?=select($web_cid_arr,$row['web_cid'],'web_cid')?> <span class="zhushi">采集的商品入库到哪个分类里</span></td>
  </tr>
  <tr>
    <td align="right">默认数据的关键词：</td>
    <td>&nbsp;<input type="text" id="kwd" name="api_kwd" value="<?=$row['api_kwd']?>"/> <span class="zhushi">如“女装” 首页展示的关键词数据，与分类二选一，分类优先</span></td>
  </tr>
  <tr>
    <td align="right">默认数据的分类：</td>
    <td>&nbsp;<?=select($api_cid_arr,$row['api_cid'],'api_cid')?> <span class="zhushi">首页展示的关键词数据，与关键词二选一，分类优先</span></td>
  </tr>
  <tr>
    <td align="right">默认排序：</td>
    <td>&nbsp;<?=html_radio($api_sort_arr,$row['api_sort']?$row['api_sort']:'total_sales_des','api_sort')?></td>
  </tr>
  <!--<tr>
    <td align="right">默认所在地：</td>
    <td>&nbsp;<select><option selected>不限</option><option>江浙沪</option><option>北京</option><option>北京</option></select> <span class="zhushi">设置后仅显示这个佣金范围内的商品</span></td>
  </tr>-->
  <tr>
    <td align="right">店铺类型：</td>
    <td>&nbsp;<?=html_radio($is_mall_arr,$row['is_mall']?$row['is_mall']:'false','is_mall')?></td>
  </tr>
  <tr>
    <td align="right">折扣价范围：</td>
    <td>&nbsp;<input name="start_price" type="text" id="start_price" value="<?=$row['start_price']?>"  style="width:50px"/>元 ~ <input name="end_price" type="text" id="end_price" value="<?=$row['end_price']?>"  style="width:50px"/>元 <span class="zhushi">如0-10 设置后仅显示这个价格范围内的商品，0标示不限制</span></td>
  </tr>
  <tr>
    <td align="right">佣金范围：</td>
    <td>&nbsp;<input name="start_tk_rate" type="text" id="start_tk_rate" value="<?=$row['start_tk_rate']?>"  style="width:50px"/>% ~ <input name="end_tk_rate" type="text" id="end_tk_rate" value="<?=$row['end_tk_rate']?>"  style="width:50px"/>% <span class="zhushi">如：0-20 设置后仅显示这个佣金范围内的商品，0标示不限制</span></td>
  </tr>
  <tr>
    <td align="right">采集页数：</td>
    <td>&nbsp;<select name="page_no">
	<?php for($i=1;$i<=100;$i++){?>
    <option value="<?=$i?>" <?php if($row['page_no']==$i){?>selected<?php }?>>采集<?=$i?>页</option>
	<?php }?>
    </select><span class="zhushi">1次最多采集100页</span></td>
  </tr>
  <input name="page_size" type="hidden" id="page_size" value="<?=$row['page_size']?$row['page_size']:100?>"  style="width:50px"/> <!--默认100，站长不用改-->
  <?php }?>
  </tbody>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="id" value="<?=$row['id']?>" /><input type="submit" class="sub" name="sub" value=" 保 存 " /></td>
  </tr>
  
</table>
</form>
<script>
$("#code").change(function(){
	yun_cid($(this).val());
})
function yun_cid(code){
	$.ajax({
	    url: u('collect','yun_cid'),
		data:{'code':code,'count':<?=count($goods_type)?>},
		dataType:'html',
		success: function(data){
			if(data==''){
				return;
			}
			for(var i=1;i<=<?=count($goods_type)?>;i++){
				string_html='<select name="yun_cid['+i+'][bendi]">';
				string_html+=data;
				string_html+='</select>';
				$("#yun_cid_"+i).html(string_html);
			}
		}
	});
}
</script>
<?php include(ADMINTPL.'/footer.tpl.php');?>