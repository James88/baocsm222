<div class="adminmenu">
  <div class="adminmenu_bt c_border">
    <div class="adminmenu_bt_font"><div class="shutiao c_bgcolor"></div><a href="<?=u('user','index')?>">后台管理中心</a></div>
      <div class="tree_on"></div>
   </div>
   <ul>
	<li><div class="adminmenu_tixian"></div><div class="adminmenu_a"><a id="index" href="<?=u('user','index')?>">用户管理中心</a></div></li>
	<li><div class="adminmenu_dindan"></div><div class="adminmenu_a"><a id='tradelist' href="<?=u('user','tradelist')?>">我的订单管理</a></div></li><!--
	<li><div class="adminmenu_fenxiang"></div><div class="adminmenu_a"><a id='fenxiang' href="<?=u('user','fenxiang')?>">我的晒单管理</a></div></li>-->
    <li><div class="adminmenu_zhannei"></div><div class="adminmenu_a"><a id='msg' href="<?=u('user','msg')?>">我的站内消息</a></div></li>
	<li><div class="adminmenu_wenti"></div><div class="adminmenu_a"><a id='mingxi' href="<?=u('user','mingxi')?>">我的账户明细</a></div></li>
    <?php if($webset['user']['shoutu']==1 && FANLI==1){?>
	<li><div class="adminmenu_lianmen"></div><div class="adminmenu_a"><a id='yaoqing' href="<?=u('user','yaoqing')?>">我要邀请好友</a></div></li>
    <?php }?>
	<li><div class="adminmenu_jilu"></div><div class="adminmenu_a"><a id='huan' href="<?=u('user','huan')?>">我的兑换商品</a></div></li>
    <li><div class="adminmenu_bangdin"></div><div class="adminmenu_a"><a id='info' href="<?=u('user','info')?>">我的账户设置</a></div></li>
  </ul>
</div>
<script>
$('.adminmenu #<?=ACT?>').addClass('current');
</script>