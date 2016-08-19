<?php
if (!defined('INDEX')) {
	exit ('Access Denied');
}

$parameter=act_wap_register();
extract($parameter);

include(TPLPATH.'/inc/header_2.tpl.php');
?>
<script>
<?php if(TAOTYPE==1 && $dduser['tbnick']==''){?>
var dayAlert=getCookie('dayAlert');
if(dayAlert!=1){
	ddAlert('请先设置淘宝订单。以便自动跟单！','<?=wap_l('user','tbnick')?>');
	setCookie('dayAlert',1,1 * 24 * 60 * 60 * 1000);
}
<?php }?>
<?php if($dduser['reg_from']!=''){?>
ddAlert('请先绑定邮箱','<?=wap_l('user','set_1',array('from'=>wap_l('user','index')))?>');
<?php }?>
</script>
<div class="listHeader">
  <p> <b>会员中心</b> <!--<a href="javascript:;" onclick="history.back()" class="left">返回</a>--> <a href='<?=wap_l()?>' class="right">首页</a>  </p>
</div>
<div class="scroller">
        <div class="profile-hd">
            <img src="<?=a($dduser['id'])?>" class="profile-uavatar" />
            <h3 class="profile-uname"><em><?=$dduser['name']?> &nbsp;</em></h3><!--class里v3代表普通会员，v1为黄金 有v0~3-->
            <div class="profile-uinfo">
                <span class="btn-uinfo" ><?=TBMONEY?><?=$dduser['jifenbao']?><?=TBMONEYUNIT?>&nbsp;&nbsp;金额<?=$dduser['money']?>元<?php if($webset['jifenbl']>0){?>,积分<?=$dduser['jifen']?>个<?php }?></span>
            </div>
        </div>

        <div class="profile-bd">
            <ul class="itable column-two">
                <li class="itable-item"><a class="itable-icon itable-login-tb" href="<?=wap_l('user','order',array('do'=>'taobao'))?>">淘宝订单</a></li>
                <li class="itable-item"><a class="itable-icon itable-fav" href="<?=wap_l('user','order',array('do'=>'mall'))?>">商城订单</a></li>
                <li class="itable-item"><a class="itable-icon itable-mytimeline" href="<?=wap_l('user','mingxi',array('do'=>'out'))?>">我的提现</a></li>
                <li class="itable-item"><a class="itable-icon itable-dialog" href="<?=wap_l('user','mingxi',array('do'=>'in'))?>">收入明细</a></li>
                <li class="itable-item"><a class="itable-icon itable-timeline" href="<?=wap_l('user','set')?>">账号设置</a></li>
                <li class="itable-item"><a class="itable-icon itable-notice" href="<?=wap_l('user','msg',array('do'=>'list'))?>">站内消息</a></li>
                <?php if(TAOTYPE==1){?>
                <li class="itable-item"><a class="itable-icon itable-order" href="<?=wap_l('user','tbnick')?>">跟单设置</a></li>
                <li class="itable-item"><a class="itable-icon itable-invite" href="<?=wap_l('user','invite',array('rec'=>$dduser['id']))?>">邀请好友</a></li>
                <?php }?>
          </ul>

             <ul class="itable">
                <?php if(TAOTYPE==2){?>
                <li class="itable-item"><a class="itable-icon itable-invite" href="<?=wap_l('user','invite',array('rec'=>$dduser['id']))?>">邀请好友</a></li>
                <?php }?>
                <li class="itable-item"><a class="itable-icon itable-out" href="<?=u('user','exit',array('from'=>wap_l()))?>">退出</a></li>
             </ul>
        </div>
            </div>
<?php include(TPLPATH.'/inc/footer.tpl.php');?>