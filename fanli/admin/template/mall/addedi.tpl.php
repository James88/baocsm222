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
if($need_zhlm==1){
	if($webset['weiyi']['status']==0){
		unset($lm['5']);
	}
	if($webset['wujiumiao']['status']==0){
		unset($lm['6']);
	}
	if($webset['chanet']['status']==0){
		unset($lm['1']);
	}
	if($webset['linktech']['status']==0){
		unset($lm['2']);
	}
	if($webset['yiqifa']['status']==0){
		unset($lm['3']);
	}
	if($webset['duomai']['status']==0){
		unset($lm['4']);
	}
	if($webset['yqh']['status']==0){
		unset($lm['7']);
	}
}else{
	foreach($lm as $key=>$vo){
		if($key!=8&&$key!=9&&$key!=50){
			unset($lm[$key]);
		}
	}
}
$row['id'] = $row['id']?$row['id']:0;
include(ADMINTPL.'/header.tpl.php');
?>
<style>
.tuan{ display:none}
</style>
<script>
lmArr=new Array();
<?php $m=0; foreach($lianmeng as $k=>$arr){?>
lmArr[<?=$k?>]=new Array();
lmArr[<?=$k?>]['title']='<?=$arr['title']?>';
lmArr[<?=$k?>]['code']='<?=$arr['code']?>';
lmArr[<?=$k?>]['helpurl']='<?=$arr['helpurl']?>';
<?php if($m==0){$cur_helpurl=$arr['helpurl'];$m++;} }?>


function getPinyin(){
    var title=$('#title').val();
	$.post('../<?=u('ajax','pinyin')?>',{title:title},function(data){
	    $('#pinyin').val(data);
	});
}

function openwinx(url,name,w,h)
{
	api_city=$('#api_city').val();
	id=$('#id').val();
	if(api_city==''){
	    alert('城市api连接不能为空');
	}
	else if(id==''){
	    alert('保存商城后从新打开再生成城市api');
	}
	else{
	    window.open(url,name,"top=100,left=400,width=" + w + ",height=" + h + ",toolbar=no,menubar=no,scrollbars=yes,resizable=no,location=no,status=no");
	}
}

function b(){
	<?php foreach($lianmeng as $k=>$arr){?>
    $('.<?=$arr['code']?>_tr').hide();
	<?php }?>
}

function c(lm){
	$("#mall_url_title").html("官网：");
	$("#mall_title").html("商城名称：");
	if(lm==8 && <?=$row['id']?>==0){
		$("#username").hide();
		$('#getmallinfo').hide();
		var add_type=$('input[name="add_type"]:checked').val();
		<?php foreach($lianmeng as $k=>$arr){?>
		$('.<?=$arr['code']?>_tr').hide();
		<?php }?>
		if(add_type==1){
			$('#qtlm').show();
			$('.zhlm_tr_url').show();
			$('.zhlm_tr').hide();
		}else{
			$('#qtlm').hide();
			$('.zhlm_tr_url').hide();
			$('.zhlm_tr').show();
		}
		return false;
	}else{
		$('.zhlm_tr_url').hide();
		$('#qtlm').show();
		$('.zhlm_tr').hide();
	}
    b();
	if(lm!=8){
		$('.'+lmArr[lm]['code']+'_tr').show();
	}
	if(lm=='7' || lm=='5'){
		$('#getmallinfo').show();
	}
	else{
		$('#getmallinfo').hide();
	}

	if(lm==9){
		$('#fanlixingshi').hide();
		$("#username").show();
	}
	else if(lm==50){
		$("#mall_url_title").html("推广地址：");
		$("#mall_title").html("频道名称：");
		$('#fanlixingshi').hide();
	}else{
		$('#fanlixingshi').show();
		$("#username").hide();
	}
	
}

$(function(){
	//选择更新字段
	$('input[name="update_jizhi"]').click(function(){
		var update_jizhi=$('input[name="update_jizhi"]:checked').val();
		if(update_jizhi==1){
			$('#mall_field').show();
		}else{
			$('#mall_field').hide();
		}
	})
	$("#update_field_btn").click(function(){
		var update_jizhi=$('input[name="update_jizhi"]:checked').val();
		var mall_field = '';
		if(update_jizhi==1){
			var checkedObj = $("[name='mall_field']:checked");//获取当前checked的value值 如果选中多个则循环
				checkedObj.each(function(){var ischeck = this.value;
				if(mall_field){
					mall_field +=',';
				}
				mall_field +=ischeck;
			});
		}
		$("#update_field_btn").val("保存设置中...");
		$.ajax({
			url: "<?=u(MOD,ACT)?>",
			data:{'mall_field':mall_field},
			type:'get',
			dataType:'json',
			success: function(data){
				$("#update_field_btn").val("保存成功，更新中");
				window.location="<?='../'.u('cron','run',array('jiaoben'=>'cron_mall','from'=>ADMINDIR."/".u('mall','list')))?>";
			 }
		});
	})
	//选择商城
	$("#mall_url").change(function(){
		var mall_url=$("#mall_url").val();
		if(mall_url==''){
			return false;
		}
		$("#mall_url_s").val(mall_url);
		get_mall_url(mall_url);
	})
	$('#getmallinfo_button').click(function(){
		get_mall_url($("#url").val());
	})
	$('#zhlm_getmallinfo_button').click(function(){
		var url=$("#mall_url_s").val();
		$("#mall_url").find("option:contains("+url+")").attr("selected",true);
		get_mall_url(url);
	})
	function get_mall_url(mall_url){
		if(mall_url==''){
			alert('网址必须填写');
			$('#mall_url_s').focus();
		}
		else{
			var lm = $('#lm').val();
			c(lm);
			if(lm=='1'){
				var ajaxUrl='../index.php?mod=ajax&act=chanet&do=get_info';
				var lianmeng='chanet';
			}
			else if(lm=='5'){
				var ajaxUrl='../index.php?mod=ajax&act=weiyi&do=get_info';
				var lianmeng='weiyi';
			}else if(lm=='8'){
				var ajaxUrl=  '<?=u(MOD,ACT)?>&mall_url='+encodeURIComponent(mall_url);
				var lianmeng='zhlm';
			}
			$(this).attr('disabled','disabled');
			var button=$(this);
			$.ajax({
                url: ajaxUrl,
				data:{url:mall_url},
                type: 'POST',
                dataType: 'json',
                error: function(XMLHttpRequest,textStatus, errorThrown){
                    alert('链接不通');
					//alert(XMLHttpRequest.status);
                 //alert(XMLHttpRequest.readyState);
				 //alert(textStatus);
					$('#showmall a').html('<b style=" font-weight:blod; color:red">查看全部</b>');
					return false;
                },
                success: function(data){
					button.attr('disabled',false);
					if(lianmeng=='taobao'){
						if(data.s==0){
							alert('无此商城信息');
						}else{
							$('#tbnick').val(data.r);			
						}
						return false;
					}
					if (typeof  data.url=='undefined' || data==null){
					    alert('无此商城信息');
					    $('#showmall a').html('<b style=" font-weight:blod; color:red">查看全部</b>');
					    return false;
					}
					else{
					    $('#url').val(data.url);
						$('#title').val(data.title);
						getPinyin();
						$('#fan').val(data.fan);
						if(lianmeng=='chanet'){
							$('#chanet_draftid').val(data.chanet_draftid);
							$('#chanetid').val(data.chanetid);
						}
						else if(lianmeng=='weiyi'){
							$('#weiyiid').val(data.weiyiid);
						}
						$('#img').val(data.img);
						$('#edate').val(data.edate);
						$('#cid').val(data.cid);
						$('#sort').val(data.sort);
						$('#des').html(data.des);
						editor.html(data.content);
					}
                }
            });
		}
	}
	$('input[name="add_type"]').click(function(){
		var add_type=$('input[name="add_type"]:checked').val();
		if(add_type==1){
			$('#qtlm').show();
			$('.zhlm_tr_url').show();
			$('.zhlm_tr').hide();
		}else{
			$('#qtlm').hide();
			$('.zhlm_tr_url').hide();
			$('.zhlm_tr').show();
		}
	})
	
		   
	
	var lm = $('#lm').val();
	var catname = $('#cid').find("option:selected").text();
	if(catname.indexOf("团购")>=0){
		$('.tuan').show();
	}
	c(lm);
	
    $('#lm').change(function(){
	    var lm = $(this).val();
		if(lm==50){
			var mall_url_zhushi='输入推广地址 <a id="helpurl" target="_blank" href="'+lmArr[lm]['helpurl']+'">获取推广地址教程</a>';
		}else{
			var mall_url_zhushi='输入淘宝/天猫店铺地址，或各商城的官方主页 <a id="helpurl" target="_blank" href="'+lmArr[lm]['helpurl']+'">添加商城教程</a>';
		}
		$("#mall_url_zhushi").html(mall_url_zhushi);
		c(lm);
	});
	$('#cid').change(function(){
	    catname=$(this).find("option:selected").text();
		if(catname.indexOf("团购")>=0){
		    $('.tuan').show();
		}
		else{
		    $('.tuan').hide();
		}
	});
	$('#tiqu').click(function(){
	    var url=$('#yiqifaurl').val();
		if(url==''){
		    alert('亿起发推广链接还未填写');
		}
		else{
		    var a= url.match(/&c=(\d+)&/);
		    $('#yiqifaid').val(a[1]);
		}
		return false;
	});
	
	$('#get_59miao_click_url').click(function(){
		var wujiumiaoid=$('#wujiumiaoid').val();
		if(wujiumiaoid==''){
			alert('59秒广告主id不能为空！');
		}
		else{
			$(this).attr('disabled','disabled');
			var button=$(this);
			$.ajax({
                url: '../<?=u('ajax','get_59miao_mall')?>',
				data:{sid:wujiumiaoid},
                type: 'POST',
                dataType: 'json',
                error: function(XMLHttpRequest,textStatus, errorThrown){
                    alert('链接不通');
					//alert(XMLHttpRequest.status);
                 //alert(XMLHttpRequest.readyState);
				 //alert(textStatus);
					return false;
                },
                success: function(data){
					button.attr('disabled',false);
					if (typeof  data.host=='undefined' || data==null){
					    alert('无此商城信息');
					    return false;
					}
					else{
					    $('#wujiumiaourl').val(data.click_url);
					}
                }
            });
		}
	});
});

function tSubmit(form){
	var lm = $('#lm').val();
	if(form.name.value==''){
		alert('请填写商城名！');
		form.name.focus();
		return false;
	}
	if(form.fan.value==''){
		alert('请填写最高返现额度！');
		form.fan.focus();
		return false;
	}
	if(form.logo.value==''){
		alert('请上传商城logo！');
		form.logo.focus();
		return false;
	}
	if(form.url.value==''){
		alert('请填写商城官网！');
		form.url.focus();
		return false;
	}
	if(lm=='alimama'){
	    if(form.tbnick.value==''){
		    alert('请填写淘宝账号！');
		    form.tbnick.focus();
		    return false;
	    }
	}
	if(lm=='linktech'){
	    if(form.merchant.value==''){
		    alert('请填写广告主账号！');
		    form.merchant.focus();
		    return false;
	    }
	}
	if(lm=='weiyi'){
	    if(form.weiyiid.value==''){
		    alert('请填写广告主账号！');
		    form.weiyiid.focus();
		    return false;
	    }
	}
	else if(lm=='yiqifa'){
	    if(form.yilink.value==''){
		    alert('请填写推广链接！');
		    form.yilink.focus();
		    return false;
	    }
        var a= form.yilink.value.match(pattern);
        if(a[1]>0){
		    form.yiqifaid.value=a[1];
		}
		if(form.yiqifaid.value=='' || form.yiqifaid.value==0){
		    alert('请填写亿起发广告id！');
		    form.yiqifaid.focus();
		    return false;
	    }
	}
	else if(lm=='duomai'){
	    if(form.duomaiid.value=='' || form.duomaiid.value==0){
		    alert('请填写多麦广告id！');
		    form.duomaiid.focus();
		    return false;
	    }
	}else if(lm=='yqh'){
	    if(form.yqhid.value=='' || form.yqhid.value==0){
		    alert('请填写一起惠活动id！');
		    form.yqhid.focus();
		    return false;
	    }
	}
	else if(lm=='chanet'){
	    if(form.chanetid.value=='' || form.chanetid.value==0){
		    alert('请填写成果广告id！');
		    form.chanetid.focus();
		    return false;
	    }
		if(form.chanet_draftid.value=='' || form.chanet_draftid.value==0){
		    alert('请填写成果原稿id！');
		    form.chanet_draftid.focus();
		    return false;
	    }
	}
	return true;
}

function getDomain($t){
	var url=$t.val();
	if(url==''){
		alert('网址不能为空');
	}
	else{
		$.get('../<?=u('ajax','get_domain')?>',{'url':url},function(data){
			$('#domain').val(data);
		});
	}
}

pattern = /(\w+)=(\w+)/ig;
</script>

<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115px" align="right">联盟：</td>
    <td>&nbsp;<?=select($lm,$row['lm'],'lm')?></td>
  </tr>
  <tbody id="qtlm">
  <tr class="zhlm_tr_url">
    <td  align="right">商城：</td>
    <td>&nbsp;<select id="mall_url" name="mall_url">
    <option value="">请选择商城网址</option>
	<?php foreach($mall_list as $mall){?><option value="<?=$mall['url']?>"><?=$mall['url']?></option><?php }?></select> 
              <input name="mall_url_s" type="text" id="mall_url_s" style="width:200px" value="<?=$row['mall_url_s']?>" /> <span class="zhushi"><input type="button" value="搜索" id="zhlm_getmallinfo_button" style="cursor:pointer" /></span>
   </td>
  </tr>
  <tr>
    <td  align="right" id="mall_url_title">官网：</td>
    <td>&nbsp;<input name="url" url="y" type="text" id="url" class="required"  style="width:300px" value="<?=$row['url']?>" /> <span style="display:none" class="zhushi" id="getmallinfo"><input type="button" value="获取信息" id="getmallinfo_button" style="cursor:pointer" />(填写后点击可直接获取商城信息)</span>  <span class="zhushi" id="mall_url_zhushi">输入淘宝/天猫店铺地址，或各商城的官方主页 <a id="helpurl" target="_blank" href="http://bbs.duoduo123.com/read-1-1-197250.html">添加商城教程</a></span> </td>
  </tr>
  <tr class="alimama_tr">
    <td align="right">淘宝帐号：</td>
    <td>&nbsp;<input name="tbnick" type="text" value="<?=$row['tbnick']?>" id="tbnick" /> <span class="zhushi">即掌柜旺旺，如选择淘宝联盟，此项必填</span></td>
  </tr>
  <tr class="alimama_tr">
    <td align="right">是否被搜索：</td>
    <td>&nbsp;<label><input type="radio" name="is_search" value="0" <?php if($row['is_search']==='0'|| $row['is_search']==''){?> checked="checked" <?php }?> />是</label> <label><input type="radio" name="is_search" value="1" <?php if($row['is_search']==='1'){?> checked="checked" <?php }?> />否</label> <span class="zhushi">如果选择否，前台搜索将不显示！</span></td>
  </tr>
  <tr>
    <td  align="right" id="mall_title">商城名称：</td>
    <td>&nbsp;<input name="title" type="text" onblur="getPinyin()" id="title" value="<?=$row['title']?>"/> 拼音：<input name="pinyin" type="text" id="pinyin" value="<?=$row['pinyin']?>"/>&nbsp;<input  class="sub" type="button" value="获取拼音" onclick="getPinyin()" /> <span class="zhushi">如京东商城</span></td>
  </tr>
  <tr>
    <td align="right">所属分类：</td>
    <td>&nbsp;<select id="cid" name="cid"><?php getCategorySelect($row['cid']?$row['cid']:$_GET['cid']);?></select> <?php if($need_zhlm==1){?><span class="zhushi"><a href="index.php?mod=mall_type&act=list">新增</a></span><?php }?></td>
  </tr>
  <tr>
    <td align="right">最高返：</td>
    <td>&nbsp;<input name="fan" type="text" id="fan" value="<?=$row['fan']?>" /> <span class="zhushi">仅前台显示，不做实际返利计算依据，具体返利以实际为准</span></td>
  </tr>
    <tr>
    <td align="right">logo：</td>
    <td>&nbsp;<input name="img" type="text" id="img" value="<?=$row['img']?>" style="width:300px" /> <input class="sub" type="button" value="上传图片" onclick="javascript:openpic('<?=u('fun','upload',array('uploadtext'=>'img','sid'=>session_id()))?>','upload','450','350')" /> <span class="zhushi">可直接添加网络地址，建议大小：105*55像素</span></td>
  </tr>
  <tr>
    <td align="right">Banner：</td>
    <td>&nbsp;<input name="banner" type="text" id="banner" value="<?=$row['banner']?>" style="width:300px" /> <input class="sub" type="button" value="上传图片" onclick="javascript:openpic('<?=u('fun','upload',array('uploadtext'=>'banner','sid'=>session_id()))?>','upload','450','350')" /> <span class="zhushi">可直接添加网络地址，没有可留空，建议大小：2000*200像素</span></td>
  </tr>
  <tr>
    <td align="right">简介：</td>
    <td>&nbsp;<textarea name="des" cols="40" rows="3" id="des" class="btn3" style="width:400px"><?=$row['des']?></textarea></td>
  </tr>
  <tr>
    <td align="right">到期时间：</td>
    <td>&nbsp;<input name="edate" type="text" id="edate" style="width:100px" value="<?=$row['edate']?$row['edate']:date("Y-m-d",strtotime("+1 year"))?>" /> </td>
  </tr>
  
  <tr>
    <td align="right">网站认证：</td>
    <td>&nbsp;<label><input type="radio" name="renzheng" value="1" <?php if($row['renzheng']==='1' || $row['renzheng']==''){?> checked="checked" <?php }?> />是</label> <label><input type="radio" name="renzheng" value="0" <?php if($row['renzheng']==='0'){?> checked="checked" <?php }?> />否</label></td>
  </tr>
  <tr id="fanlixingshi" style="display:none">
    <td align="right">返利形式：</td>
    <td>&nbsp;<?=html_radio(array(1=>'金额',2=>'积分'),$row['type']==''?1:$row['type'],'type')?> </td>
  </tr>
  <tr>
    <td align="right">排序：</td>
    <td>&nbsp;<input name="sort" type="text" id="sort" value="<?=$row['sort']?>" /> <span class="zhushi">数字越小越靠前,1为最小值</span></td>
  </tr>
   
  <?php if($need_zhlm==1){?>
  <tr class="duomai_tr">
    <td align="right">多麦广告主id：</td>
    <td>&nbsp;<input name="duomaiid" type="text" value="<?=$row['duomaiid']?>" id="duomaiid" /> <span class="zhushi">如选择多麦网，此项必填</span></td>
  </tr>
  <tr class="yqh_tr">
    <td align="right">一起惠活动id：</td>
    <td>&nbsp;<input name="yqhid" type="text" value="<?=$row['yqhid']?$row['yqhid']:0?>" id="yqhid" /> <span class="zhushi"> 如选择一起惠联盟，此项必填</span></td>
  </tr>
  <tr class="wujiumiao_tr">
    <td align="right">59秒广告主id：</td>
    <td>&nbsp;<input name="wujiumiaoid" type="text" value="<?=$row['wujiumiaoid']?$row['wujiumiaoid']:0?>" id="wujiumiaoid" /> <input type="button" value="获取推广网址" id="get_59miao_click_url" style="cursor:pointer" /> <span class="zhushi">如选择59秒，此项必填</span></td>
  </tr>
  <tr class="wujiumiao_tr">
    <td align="right">59秒推广url：</td>
    <td>&nbsp;<input name="wujiumiaourl" type="text" value="<?=$row['wujiumiaourl']?>" id="wujiumiaourl" style="width:300px" /> <span class="zhushi">如选择59秒，此项必填</span></td>
  </tr>
  
  <tr class="yiqifa_tr">
    <td align="right">亿起发推广网址：</td>
    <td>&nbsp;<input onblur="if(this.value==''){return false;}var a= this.value.match(pattern);if(a[1]>0){form.yiqifaid.value=a[1];}" name="yiqifaurl" type="text" style="width:300px" id="yiqifaurl" value="<?=$row['yiqifaurl']?>" /> <span class="zhushi">如选择亿起发网，此项必填</span></td>
  </tr>
  <tr class="yiqifa_tr">
    <td align="right">亿起发广告主id：</td>
    <td>&nbsp;<input name="yiqifaid" type="text" value="<?=$row['yiqifaid']?>" id="yiqifaid" /> <span class="zhushi">如选择亿起发，此项必填</span></td>
  </tr>
  <tr class="yiqifa_tr">
    <td align="right">亿起发商家分类id：</td>
    <td>&nbsp;<input name="merchantId" type="text" value="<?=$row['merchantId']?>" id="merchantId" /> <span class="zhushi">亿起发api使用</span></td>
  </tr>
  
  <tr class="linktech_tr">
    <td align="right">领客特广告主账号：</td>
    <td>&nbsp;<input name="merchant" type="text" value="<?=$row['merchant']?>" id="merchant" /> <span class="zhushi">如选择领克特，此项必填</span></td>
  </tr>
  
  <tr class="chanet_tr">
    <td align="right">成果原稿id：</td>
    <td>&nbsp;<input name="chanet_draftid" type="text" value="<?=$row['chanet_draftid']?>" id="chanet_draftid" /> <span class="zhushi">如选择成果网，此项必填</span> <?php if(DLADMIN!=1){?><span class="zhushi" id='showmall'><a href="http://demo.duoduo123.com/getchanet.php?act=all" target="_blank">查看全部</a></span><?php }?></td>
  </tr>
  <tr class="chanet_tr">
    <td align="right">成果广告主id：</td>
    <td>&nbsp;<input name="chanetid" type="text" value="<?=$row['chanetid']?>"  id="chanetid" /> <span class="zhushi">如选择成果网，此项必填</span></td>
  </tr>
  <tr class="chanet_tr">
    <td align="right">成果广告主链接：</td>
    <td>&nbsp;<input name="chaneturl" type="text" value="<?=$row['chaneturl']?>" id="chanetid" /> <span class="zhushi">选填，如果此商城为团购网站并且采集团购商品，此项必填</span></td>
  </tr>
  <tr class="weiyi_tr">
    <td align="right">唯一广告主账号：</td>
    <td>&nbsp;<input name="weiyiid" type="text" value="<?=$row['weiyiid']?>" id="weiyiid" /> <span class="zhushi">如选择唯一联盟，此项必填(推广网址里m=joyo中的joyo)</span></td>
  </tr>
  <?php }?>
  <tr>
    <td align="right">介绍：</td>
    <td>&nbsp;<textarea id="content" name="content"><?=$row['content']?></textarea></td>
  </tr>
  <tr id="username" <?php if($row['lm']!=9){?> style="display:none"<?php }?>>
    <td align="right">商城管理员：</td>
    <td>&nbsp;<input name="username" type="text" value="<?=$row['username']?>"  id="m_uer" /> <span class="zhushi">即商家/商城的提交人，填前台会员账号，没有请留空</span></td>
  </tr>
  <tr>
    <td align="right">锁定：</td>
    <td>&nbsp;<?=html_radio(array(0=>'否',1=>'是'),$row['suoding'],'suoding')?><span class="zhushi">锁定后批量更新商城将不更新此商城数据</span> </td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="id" value="<?=$row['id']?>" /><input type="submit" class="sub" name="sub" value=" 保 存 " /></td>
  </tr>
  </tbody>
  <tbody class="zhlm_tr" style=" display:none">
  <tr>
    <td align="right">添加方式：&nbsp;</td>
    <td>&nbsp;<label><input type="radio" name="add_type" value="0" checked="checked"  />一键更新</label> <label><input type="radio" name="add_type" value="1"   />单个添加</label> </td>
  </tr>
  <tr>
    <td align="right">更新机制：&nbsp;</td>
    <td>&nbsp;<label><input type="radio" name="update_jizhi" value="0" checked="checked"  />全部覆盖更新</label> <label><input type="radio" name="update_jizhi" value="1"   />选择性更新</label> </td>
  </tr>
  <tr id="mall_field" style="display:none">
    <td align="right">更新内容：&nbsp;</td>
    <td>&nbsp;<label><input name="mall_field" checked type="checkbox" value="edate" /> 到期时间 </label> <label><input name="mall_field" checked type="checkbox" value="url" /> 网址 </label> <label><input checked name="mall_field" type="checkbox" value="title" /> 商城名称 </label> <label><input name="mall_field" checked type="checkbox" value="img" /> logo </label> <label><input checked name="mall_field" type="checkbox" value="fan" /> 最高返 </label> <label><input checked name="mall_field" type="checkbox" value="banner" /> Banner </label><label><input name="mall_field" type="checkbox" checked value="des" /> 简介 </label> <label><input checked name="mall_field" type="checkbox" value="content" /> 介绍 </label></td>
  </tr>
   <tr>
    <td align="right">提示：&nbsp;</td>
    <td>&nbsp;<input type="button" value="立即更新" id="update_field_btn"/><span class="zhushi">无需自己添加，在线更新即可。</span></td>
  </tr>
  </tbody>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>