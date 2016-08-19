<?php
if(!defined('INDEX')){
	exit('Access Denied');
}

$phone_app_status=$app_status;
?>
<div class="LightBox" id="LightBox"></div><div id="jumpbox" show="0" class="jumpbox"><div class="top_left"></div><div class="top_center"></div><div class="top_right"></div><div class="middle_left"></div><div class="middle_center"><div onclick="jumpboxClose();" class="close"><a></a></div><p class="title"></p><div class="contain">
<table border="0" style=" margin-top:30px">
  <tr>
    <td><div style=" border:#CCC 2px solid;"><img src="images/blank.png" class="erweima-pic" style=" width:140px; height:140px; padding:5px;background: no-repeat center url(<?=TPLURL?>/images/wait3.gif)" /></div></td>
    <td valign="top"><div style="padding-left:10px; line-height:30px; font-size:14px">使用手机二维码扫描<?php if($phone_app_status==1){?>或手机客户端购买<?php }?>，可优惠 <b style="font-family: Arial; color:#F60; font-size:16px" class="youhui"></b>&nbsp;元！<br/>
    <a href="" class="url" target="_blank" style="font-size:14px; text-decoration:underline;">不要优惠，电脑购买</a>
    <?php if($phone_app_status==1){?>
    <br/><a href="<?=u('app','index')?>" target="_blank" style="text-decoration:underline;font-size:14px;">下载手机APP</a>
    <?php }?>
    </div></td>
  </tr>
</table>
</div></div><div class="middle_right"></div><div class="end_left"></div><div class="end_center"></div><div class="end_right"></div></div>