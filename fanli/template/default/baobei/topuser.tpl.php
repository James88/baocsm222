<div class="space" style="margin:0 auto;">
    <div class="space-left" style="float:left;">
      <div style="float:left; padding:15px;">
      <a href="<?=u('baobei','user',array('uid'=>$user['id']))?>" style="font-size:30px">
      <img src="<?=a($user['id'],'middle')?>" alt="<?=$user['ddusername']?>" /></a>
      </div>
    </div>
    <div class="space-center">
      <div class="username">
          <table border="0">
  <tr>
    <td><a href="<?=u('baobei','user',array('uid'=>$user['id']))?>" style="font-size:30px"><?=utf_substr($user['ddusername'],2).'***'?></a></td>
    <td width="25" align="center"><div style="width:1px; height:30px; border-left:1px #C5C5C5 dotted">&nbsp;</div></td>
    <td style="font-size:18px"><b style="font-family:'宋体'; color:#666666">宝贝</b><b style="color:#FF6699; margin-left:10px"><?=$total?></b></td>
  </tr>
</table>
      </div>
      <div class="goods-top">
      <ul>
        <li <?php if($xs==1){?> class="cur"<?php }?>><a href="<?=u('baobei','user',array('uid'=>$user['id'],'xs'=>1))?>">Ta的宝贝</a></li>
        <li <?php if($xs==2){?> class="cur"<?php }?>><a href="<?=u('baobei','user',array('uid'=>$user['id'],'xs'=>2))?>">Ta的喜欢</a></li>
      </ul>
    </div>
    </div>
    <div class="space-right">
      <div style="border:#FF0099 1px solid; width:110px; height:28px; color:#FF6699;">
        <div style="margin-top:7px; margin-left:22px">
          <div style="float:left; height:19px; line-height:19px; font-size:16px">收到的</div>
          <div style=" width:16px" class="icon2"></div>
        </div>
      </div>
      <div id="user_hart" style="border:#8C8C8C 1px dashed; border-top:0px; width:110px; height:44px; color:#FF3261; text-align:center; font-size:24px; font-weight:bold; line-height:44px">
	  <?=$user['hart']?$user['hart']:0?></div>
    </div>
    
  </div>