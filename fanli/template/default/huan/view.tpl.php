<?php
$parameter=act_huan_view();
extract($parameter);
$css[]=TPLURL.'/inc/css/duihuan.css';
include(TPLPATH.'/inc/header.tpl.php');
?>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<div class="biaozhun5" style="width:1000px; background:#FFF; margin:auto; margin-top:10px; padding-bottom:10px">
<div class="c_border" style="border-top-style:solid; border-top-width:2px;">
<div id="main">
<?=AD(10)?>
  <div id="apDiv6">
    <?php include(TPLPATH."/huan/left.tpl.php");?>
  </div>
  <div id="apDiv7"><div id="apDiv8">
  <?php include(TPLPATH."/huan/top.tpl.php");?>
  </div>
  <div id="apDiv14">
  <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" style=" margin:auto">
    <tr>
      <td height="60" colspan="2" nowrap="nowrap"><font color="#888888" size="5"><?=$good['title']?></font></td>
  </tr>
  <tr>
    <td width="30%">
    <div style="width:160px;height:160px;background-color:#FFFFFF;border:1px solid #CCCCCC;padding:15px;">
	<?php 
	if($good['num']<1){
		$fs="<div class=swts>&nbsp;</div>";
	}
	elseif($good['num']>0){
		if($good["sdate"]>TIME){
	    	$fs="<div class=wks></div>";
		}
		elseif($good["edate"]<TIME && $good["edate"]>0){
			$fs="<div class=sgq></div>";
		}else{
			$fs="<div class=syts></div>";
		}
	}
	echo $fs;
	?><img  src="<?=$good['img']?>" width="160" height="160" alt="<?=$good['title']?>" /></div></td>
  <td width="57%" valign="top">
    
    <div style="line-height:35px;margin-top:0px;font-size: 14px;color: #999999;">
    <?php if($good['jifenbao']>0){?>
    <?=TBMONEY?>兑换 ：<b style=" color:#FF6600; font-size:16px"><?=$good['_jifenbao']?></b>&nbsp;
    <?php }else{?>
    <?=TBMONEY?>兑换 ：不参与
    <?php }?>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <?php if($good['jifen']>0){?>
    积分兑换 ：<b style=" color:#FF6600; font-size:16px"><?php echo $good['jifen'];?></b>&nbsp;点
    <?php }else{?>
    积分兑换 ：不参与
    <?php }?>
    </div>
    <div style="line-height:35px;margin-top:3px;font-size: 14px;color: #999999;">剩余库存 ：<b style=" color:#FF6600; font-size:16px"><?=$good['num']?></b>&nbsp;件</div>
    <?php if($good['sdate']>0){?>
    <div style="line-height:35px;margin-top:3px;font-size: 14px;color: #999999;">开始时间 ：<b style=" color:#FF6600; font-size:16px"><?=$good['_sdate']?></b></div>
    <?php }?>
    <?php if($good['edate']>0){?>
    <div style="line-height:35px;margin-top:3px;font-size: 14px;color: #999999;">结束时间 ：<b style=" color:#FF6600; font-size:16px"><?=$good['_edate']?></b></div>
    <?php }?>

<div class="dhbutton">
<?php if($dduser['name']!=''){?>
	<?php if($good['jifenbao']>0){?>
	<button class="money"  id="jifenbao" title="<?=$jifenbao_dh_msg?>" <?php if($jifenbao_dh_status==0){?> jinzhi="<?=$jifenbao_dh_msg?>"<?php }else{?>jinzhi="0"<?php }?>><?=TBMONEY?>兑换</button>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<?php }?>
	<?php if($good['jifen']>0){?>
	<button class="jifen"  id="jifen" title="<?=$jifen_dh_msg?>" <?php if($jifen_dh_status==0){?> jinzhi="<?=$jifen_dh_msg?>"<?php }else{?>jinzhi="0"<?php }?>>积分兑换</button>
	<?php }?>
<?php }else{?>
	<?php if($good['jifenbao']>0){?>
	<button class="money" onclick="alert('登陆后才可兑换商品！');window.location='<?=u('user','login')?>&url='+encodeURIComponent(window.location.href)" jinzhi="1"><?=TBMONEY?>兑换</button>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<?php }?>
	<?php if($good['jifen']>0){?>
	<button class="jifen" onclick="alert('登陆后才可兑换商品！');window.location='<?=u('user','login')?>&url='+encodeURIComponent(window.location.href)" jinzhi="1">积分兑换</button>
	<?php }?>
<?php }?>
</div></td></tr></table></div>
<div id="apDiv19"><div id="apDiv20">商品详情</div>
<div id="apDiv21"><?php echo $good['content'];?></div></div>
</div>
</div>
</div>
<div style="clear:both"></div>
</div>
<script>
$(function(){	
    $('.dhbutton button').jumpBox({  
	    title: '<?=$good['title']?>',
		LightBox:'show',
		height:400,
		width:450,
		defaultContain:1,
		jsCode:'var jinzhi=$(this).attr("jinzhi");if(jinzhi!="0"){ if(jinzhi!=1){alert(jinzhi);}var jumpBoxStop=1;};if($(this).attr("id")=="money"){$("#form1 #mode").val(1)}if($(this).attr("id")=="jifen"){$("#form1 #mode").val(2)}'
    });
	$('#form1').validate({
        errorPlacement: function(error, element){
            var error_td = element.parent('td').next('td');
            error_td.find('.field_notice').hide();
            error_td.append(error);
        },
        success       : function(label){
            label.addClass('validate_right').text('OK!');
        },
        onkeyup: false,
        rules : {
			num : {
                required : true,
                range:[1,<?php echo $good['limit'];?>]
            },
            realname : {
                required : true
            },
            mobile : {
                required : true,
                mobile   : true
            },
			<?php if(empty($dduser['alipay'])){?>
			alipay : {
                alipay    : true
            },
			<?php }?>
            email : {
                required : true,
                email    : true
            },
            qq : {
                required : true,
                range:[1000,999999999999]
            }
        },
        messages : {
			num : {
                required : '填写您兑换数量',
                range:'数量最多兑换<?=$good['limit']?>件'
            },
			realname : {
                required : '填写姓名'
            },
            mobile  : {
                required : '填写手机号码',
                mobile: '手机号码格式错误'
            },
			<?php if(empty($dduser['alipay'])){?>
			alipay : {
                alipay    : '支付宝错误'
            },
			<?php }?>
            email : {
                required : '填写电子邮箱',
                email    : '邮箱错误'
            },
			qq : {
                required : '填写您的QQ号码',
                range:'QQ号码位数错误'
            }
        },
		submitHandler: function(form) {
            $form=$('#form1');
			$form.find('.ShiftClass').attr('disabled','disabled');
            var query=$form.serialize();//document.write(query);
	        var url=$form.attr('action');
	        $.ajax({
		        url: url,
		        data:query,
		        dataType:'jsonp',
				jsonp:"callback",
		        success: function(data){
			        if(data.s==0){
			            alert(errorArr[data.id]);
						$form.find('.ShiftClass').attr('disabled',false);
						jumpboxClose();
			        }
			        else if(data.s==1){
			            alert('兑换成功,等待管理员审核');
						location.replace(location.href);
			        }
					else if(data.s==2){
			            alert('兑换成功,请查收站内信领取');
						window.location.href='<?=u('user','msg')?>';
			        }
		        }
	        });
        } 
    });
});
</script>
<div id="dhFormHtml">
<div class="LightBox" id="LightBox"></div><div id="jumpbox" show="0" class="jumpbox"><div class="top_left"></div><div class="top_center"></div><div class="top_right"></div><div class="middle_left"></div><div class="middle_center"><div class="close"><a></a></div><p class="title"></p><div class="contain">
<form id="form1" name="form1" method="post" action="<?=$form1_url?>">
                        <table width="350" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="70" height="35" align="right">数量：</td>
                            <td width="150" align="left"><input name="num" type="text" class="ddinput" value="1" id="num" style="width:60px;" /></td>
                            <td width="150" align="right"><label class="field_notice">最多兑换<?=$good['limit']?>件</label></td>
                          </tr>
                          <tr>
                            <td width="" height="35" align="right">姓名：</td>
                            <td width="150" align="left">
                            <?php if($dduser['realname']!=''){echo $dduser['realname'];}else{?>
                            <input name="realname" type="text" class="ddinput" value="<?=$dduser['realname']?>" id="realname" style="width:120px;" />
                            <?php }?>
                            </td>
                            <td width="150" align="right"><label class="field_notice">请填写收货人姓名</label></td>
                          </tr>
						  <tr>
                            <td width="" height="35" align="right">手机：</td>
                            <td align="left">
                            <?php if($tixian_sms_open==1 || $dduser['mobile']!=''){echo $dduser['mobile'];}else{?>
                            <input name="mobile" type="text" class="ddinput" value="<?=$dduser['mobile']?>" id="mobile" style="width:120px;" />
                            <?php }?>
                            </td>
                            <td width="" align="right"><label class="field_notice">请填写常用手机号码</label></td>
                          </tr>
						  <tr>
                            <td height="35" align="right">邮箱：</td>
                            <td align="left">
                            <?php if($dduser['email']!=''){?><div style="width:170px; overflow:hidden"><?=$dduser['email']?></div><?php }else{?>
                            <input name="email" type="text" class="ddinput" value="<?=$dduser['email']?>" id="email" style="width:120px;" />
                            <?php }?>
                            </td>
                            <td width="" align="right"><label class="field_notice">请填写您的邮箱</label></td>
                          </tr>
                          <tr>
                            <td width="" height="35" align="right">支付宝：</td>
                            <td align="left">
                            <?php if($dduser['alipay']!=''){echo $dduser['alipay'];}else{?>
                            <input name="alipay" type="text"  class="ddinput"  value="<?=$dduser['alipay']?>" id="alipay" style="width:120px;" />
                            <?php }?>
                            </td>
                            <td width="" align="right"><label class="field_notice">请填写您的支付宝</label></td>
                          </tr>
						  <tr>
                            <td width="" height="35" align="right">QQ：</td>
                            <td align="left">
                            <?php if($dduser['qq']!=''){echo $dduser['qq'];}else{?>
                            <input name="qq" type="text" class="ddinput" value="<?=$dduser['qq']?>" id="qq" style="width:120px;" />
                            <?php }?>
                            </td>
                            <td width="" align="right"><label class="field_notice">请填写您的QQ</label></td>
                          </tr>
                          <tr>
                            <td width="" height="35" align="right">地址：</td>
                            <td align="left"><input name="address" type="text" class="ddinput" value="" id="address" style="width:120px;" /></td>
                            <td width="" align="right"><label class="field_notice">请填写收货地址</label></td>
                          </tr>
						  <tr>
                            <td width="" height="35" align="right">备注：</td>
                            <td align="left"><textarea name="content" class="ddinput" id="content" style="width:140px;height:44px;line-height:22px;"></textarea></td>
                            <td width="" align="right"><label class="field_notice">请填写附加备注</label></td>
                          </tr>
						  <tr>
                            <td width="" height="35" align="right"></td>
                            <td align="left"><div class="img-button "><p><input type="hidden" id="mode" name="mode" value="1" /><input type="hidden" id="id" name="id" value="<?=$id?>" /><input type="submit" value="提 交" class="ShiftClass" /></p></div></td>
                            <td width="" align="left"><label class="field_notice"></label></td>
                          </tr>
      </table>
        </form>
</div></div><div class="middle_right"></div><div class="end_left"></div><div class="end_center"></div><div class="end_right"></div></div>
</div>
<?php include(TPLPATH.'/inc/footer.tpl.php');?>