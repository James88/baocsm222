<?php
if(!defined('INDEX')){
	exit('Access Denied');
}
$parameter=act_user_tixian();
extract($parameter);
$css[]=TPLURL."/inc/css/usercss.css";
include(TPLPATH.'/inc/header.tpl.php');

$txTool=include(DDROOT.'/data/tx_tool.php');

$alipay_tr='<tr class="tool_tr"><td width="" height="35" align="right">支付宝账号：</td><td align="left"><input name="alipay" '.$alipay_dis.' type="text" class="ddinput" value="'.$dduser['alipay'].'" id="alipay" style="width:120px;" /></td><td width="" align="left"><label class="field_notice">您的支付宝账号</label></td></tr>';
$tenpay_tr='<tr class="tool_tr"><td width="" height="35" align="right">财付通账号：</td><td align="left"><input name="tenpay" '.$tenpay_dis.' type="text" class="ddinput" value="'.$dduser['tenpay'].'" id="tenpay" style="width:120px;" /></td><td width="" align="left"><label class="field_notice">您的财付通账号</label></td></tr>';
$bank_tr='<tr class="tool_tr"><td width="" height="35" align="right">提取银行：</td><td align="left">'.str_replace("'","\'",select($bank_arr,$bank_id,'bank_id',$bank_code_dis,1)).'</td><td width="" align="left"><label class="field_notice"></label></td></tr><tr class="tool_tr"><td width="" height="35" align="right">银行账号：</td><td align="left"><input name="bank_code" '.$bank_code_dis.' type="text" class="ddinput" value="'.$dduser['bank_code'].'" id="bank_code" style="width:160px;" /></td><td width="" align="left"><label class="field_notice">您的银行账号</label></td></tr>';

if($webset['tixian']['need_alipay']==1){
	$tx_tr_arr[1]=$alipay_tr;
	$tx_tool[1]=$txTool[1];
}
if($webset['tixian']['need_tenpay']==1){
	$tx_tr_arr[2]=$tenpay_tr;
	$tx_tool[2]=$txTool[2];
}
if($webset['tixian']['need_bank']==1){
	$tx_tr_arr[3]=$bank_tr;
	$tx_tool[3]=$txTool[3];
}

?>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<script>
var txTrArr=new Array();
<?php foreach($tx_tr_arr as $k=>$v){?>
txTrArr[<?=$k?>]='<?=$v?>';
<?php }?>
$(function(){	
	$('#tool').change(function(){
		if($('.tool_tr').length==2){
			$('.tool_tr').eq(0).remove();
		}
		$('.tool_tr').replaceWith(txTrArr[$(this).val()]);
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
            money : {
                required : true,
				<?php if($txxz>0){?>
				dd_multiple : <?=$txxz?>,
				<?php }?>
				range    : [<?=$tixian_limit?>,<?=$max_money?>]
            },
			mobile : {
				mobile   : true
            },
			ddpassword : {
                required : true,
                minlength: 6,
				remote   : {
                    url :'index.php?mod=ajax&act=check_oldpass',
                    type:'post',
                    data:{
                        oldpass : function(){ return $('#ddpassword').val();},dduserid:<?=$dduser['id']?>
                    },
                    beforeSend:function(){
                        var _checking = $('#checking_oldpass');
                        _checking.prev('.field_notice').hide();
                        _checking.next('label').hide();
                        $(_checking).show();
                    },
                    complete :function(){
                        $('#checking_oldpass').hide();
                    }
                }
            }
        },
        messages : {
            money : {
                required : '提取<?=$money_name?>必填',
				range    : '提取<?=$money_name?>应大于等于<?=$tixian_limit?>且小于等于<?=$max_money?>',
                dd_multiple : '提取<?=$money_name?>不是<?=$txxz?>的整数倍'
            },
			mobile : {
                mobile : '手机号码格式错误'
            },
			ddpassword : {
                required : '登陆密码必填',
				minlength: '密码位数错误',
				remote   : '密码错误'
            }
        },
		submitHandler: function(form) {
			var $subB=$(form).find('.ShiftClass',true)
			$subB.attr('disabled',true);
			//ajaxPostForm(form,'<?=u('user','index')?>','提取成功，等待审核');
			var query=$(form).serialize();
			var url=$(form).attr('action');
			var type='json';
			$.ajax({
	    		url: url,
				type: "POST",
				data:query,
				dataType:'json',
				success: function(data){//alert(data);
		   			if(data.s==0){
			    		alert(errorArr[data.id]);
						$subB.attr('disabled',false);
					}
					else if(data.s==1){
				    	alert('提取成功，等待审核');
						window.location='index.php?mod=user&act=index';
					}
				},
				error: function(XMLHttpRequest,textStatus, errorThrown){
					//alert(XMLHttpRequest.status);
            		//alert(XMLHttpRequest.readyState);
					//alert(textStatus);
        		}
			});
        } 
    });
});
</script>
<div class="mainbody">
	<div class="mainbody1000">
    <?php include(TPLPATH."/user/top.tpl.php");?>
    	<div class="adminmain">
        	<div class="adminleft">
                <?php include(TPLPATH."/user/left.tpl.php");?>
            </div>
        	<div class="adminright">
            <div class="c_border" style="border-top-style:solid; border-top-width:2px;padding-top:10px;">
            <div class="adminright_gg" id="user_notice">
			<ul>
			  <li><div class="gonggaotubiao"></div><b>提醒：</b> <?=$tipword?></li>
			</ul>
			</div>
            <form id="form1" name="form1" autocomplete="off" method="post" action="<?=u('user','tixian',array('type'=>$type))?>">
            <input type="hidden" name="sub" value="1" />
                        <table width="605" border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="116" height="35" align="right">现有：</td>
                            <td width="" height="35" align="left"><b class="bignum"><?=$live_money?></b>（<?=$unit?>）<?php if($_GET['from']=='huan'){?>= <?=$live_money*(100/TBMONEYBL)?>个集分宝<?php }?></td>
                            <td width="270" align="right"></td>
                          </tr>
						  <tr>
                            <td width="" height="35" align="right">申请提取：</td>
                            <td align="left"><input name="money" type="text" class="ddinput" value="<?=$max_money?>" id="money" style="width:120px;" /></td>
                            <td width="" align="left"><label class="field_notice"><?php if($txxz>0){?>请填写<b class="bignum"><?=$txxz?></b>的整数倍，<?php }?>小于<b class="bignum"><?=$max_money?></b></label></td>
                          </tr>
                          <?php if($type==2){?>
                          <tr>
                            <td width="" height="35" align="right">平台选择：</td>
                            <td align="left"><?=select($tx_tool,$dduser['txtool'],'tool')?></td>
                            <td width="" align="left"><label class="field_notice"><?php if(count($tx_tr_arr)>1){?><a href="<?=u('user','info',array('do'=>'caiwu'))?>" style="text-decoration:underline">修改默认提取平台</a><?php }?></label></td>
                          </tr>
                          <?=$tx_tr_arr[$dduser['txtool']]?>
                          <?php }elseif($type==1){?>
                          <tr>
                            <td width="" height="35" align="right">支付宝账号：</td>
                            <td align="left"><input name="alipay" <?=$alipay_dis?> type="text" class="ddinput" value="<?=$dduser['alipay']?>" id="alipay" style="width:120px;" /></td>
                            <td width="" align="left"><label class="field_notice">您的支付宝账号</label></td>
                          </tr>
                          <?php }?>
						  <tr>
                            <td width="" height="35" align="right">收款人姓名：</td>
                            <td align="left"><input name="realname" <?=$realname_dis?> type="text" class="ddinput" value="<?=$dduser['realname']?>" id="realname" style="width:120px;" /></td>
                            <td width="" align="left"><label class="field_notice">转账核对时用，填写后不可修改(与支付宝对应)</label></td>
                          </tr>
						  <tr>
                            <td width="" height="35" align="right">手机号：</td>
                            <td align="left"><input name="mobile" <?php if($dduser['mobile']!=''){?> disabled="disabled"<?php }?> type="text" class="ddinput" value="<?=$dduser['mobile']?>" id="mobile" style="width:120px;" /></td>
                            <td width="" align="left"><label class="field_notice"><?php if($webset['sms']['open']==1){?>填写后，提取成功，会免费短信通知您<?php }else{?>填写您的手机号码<?php }?></label></td>
                          </tr>
						  <tr>
                            <td width="" height="35" align="right">本站登陆密码：</td>
                            <td align="left"><input name="ddpassword" type="password" class="ddinput" value="" id="ddpassword" style="width:120px;" /></td>
                            <td width="" align="left"><label class="field_notice">
                            <?php if($default_pwd!=''){?>
          您的默认登录密码为：<b style="color:red"><?=$default_pwd?></b>，<a href="<?=u('user','info',array('do'=>'pwd'))?>">立刻修改</a>
          <?php }else{?>
          填写网站登录密码
          <?php }?>
                            </label> <label id="checking_oldpass" class="checking">检查中...</label></td>
                          </tr>
                          <tr>
                            <td width="" height="35" align="right">特别说明：</td>
                            <td align="left" colspan="2"><textarea name="remark" id="remark" class="ddinput" style="width:180px; height:50px; line-height:15px; padding-top:5px"></textarea><div style="float:left;color:#9C9C9C; line-height:50px; margin-left:5px">没有特别说明请留空</div></td>
                          </tr>
						  <tr>
                            <td width="" height="35" align="right"></td>
                            <td align="left" colspan="2"><div class="img-button "><p><input type="submit" value="提 交" class="ShiftClass" /></p></div></td>
                          </tr>
      </table>
      <?php
	  dd_session_start();
	  $token=rand(1000,9999);
	  $_SESSION['token']=$token;
	  ?>
      <input type="hidden" name="token" value="<?=$token?>" />
        </form>
            </div>
        </div>
        </div>
  </div>
</div>

<?php
include(TPLPATH.'/inc/footer.tpl.php');
?>