<?php
$parameter=act_user_fenxiang();
extract($parameter);
$css[]=TPLURL."/inc/css/usercss.css";
$css[]='css/qqFace.css';
include(TPLPATH.'/inc/header.tpl.php');
?>
<div class="mainbody">
	<div class="mainbody1000">
    <?php include(TPLPATH."/user/top.tpl.php");?>
    	<div class="adminmain">
        	<div class="adminleft">
                <?php include(TPLPATH."/user/left.tpl.php");?>
            </div>
        	<div class="adminright" style="padding-top:10px">
                <?php include(TPLPATH."/user/notice.tpl.php");?>
                <div class="admin_xfl">
                    <ul>
                    <li id="share"><a href="<?=u(MOD,ACT,array('do'=>'share'))?>">我的分享</a> </li>
                    <li id="shai"><a href="<?=u(MOD,ACT,array('do'=>'shai'))?>">我的晒单</a> </li>
                    <li id="baoliao"><a href="<?=u(MOD,ACT,array('do'=>'baoliao'))?>">我的爆料</a> </li>
                    <?php if($webset['zhidemai']['jiangli_bili']>0 || $webset['baobei']['jiangli_bili']>0){?>
                    <li id="ddtuiguang"><a href="<?=u(MOD,ACT,array('do'=>'ddtuiguang'))?>">成交奖励</a> </li>
                    <?php }?>
                    <script>
                    $(function(){
					    $('.admin_xfl li#<?=$do?>').addClass('admin_xfl_xz');
					})
                    </script>
                    </ul>
              	</div>
                <div class="admin_table">
                <?php if($do=='share' || $do=='shai'){?>
                <?php foreach($baobei as $row){?>
                   <table width="770" border="0" cellspacing="0" cellpadding="0" class="admin_table_fx">
                      <tr>
                        <td width="105" height="90" align="center"><a target="_blank" href="<?=$row["url"]?>"><?=html_img($row['img'],3,$row['title'])?></a></td>
                        <td width="665">
                        <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td height="27" colspan="4"><strong>商品名：</strong><a target="_blank" href="<?=$row["url"]?>"><?=$row["title"]?></a></td>
                            <td width="12%" height="27"><span>红心：<?=$row["hart"]?></span></td>
                          </tr>
                          <tr>
                            <td width="16%" height="34">原价：<?=$row["price"]?></td>
                            <td width="12%">点击：<?=$row["hits"]?></td>
                            <td width="15%">类别：<?=$row["cat_name"]?></td>
                            <td colspan="2">标签：<?=$row["keywords"]?></td>
                          </tr>
                        </table></td>
                      </tr>
                </table>
                <?php }?>
                <?php }elseif($do=='baoliao'){?>
                <?php foreach($baobei as $row){?>
                   <table width="770" border="0" cellspacing="0" cellpadding="0" class="admin_table_fx">
                      <tr>
                        <td width="105" height="90" align="center"><a target="_blank" href="<?=$row["url"]?>"><img src="<?=$row['img']?>" alt="<?=$row["title"]?>" /></a></td>
                        <td width="665">
                        <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td height="27"><a target="_blank" href="<?=$row["url"]?>"><?=$row["title"]?></a></td>
                          </tr>
                          <tr>
                            <td height="27"><?=$row["subtitle"]?></td>
                          </tr>
                        </table></td>
                      </tr>
                </table>
                <?php }?>
                <?php }elseif($do=='ddtuiguang'){?>
                <?php foreach($baobei as $row){?>
                   <table width="770" border="0" cellspacing="0" cellpadding="0" class="admin_table_fx">
                      <tr>
                        <td width="105" height="90" align="center"><a target="_blank" href="<?=$row['url']?>"><img src="<?=$row['img']?>" alt="<?=$row["title"]?>" /></a></td>
                        <td width="665">
                        <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td height="34"><?=$row['type']?>：<a target="_blank" href="<?=$row['url']?>"><?=$row["title"]?></a></td>
                          </tr>
                          <tr>
                            <td height="34">下单时间：<?=date('Y-m-d',strtotime($row["date"]))?> &nbsp;&nbsp;&nbsp; 状态：<?=$row["status"]==0?'未确认':'已确认'?> &nbsp;&nbsp;&nbsp; 奖励：<?=$row["money"]?$row["money"]:'——'?> &nbsp;&nbsp;&nbsp; 确认时间：<?=$row["status"]?$row["pay_time"]:'——'?></td>
                          </tr>
                        </table></td>
                      </tr>
                </table>
                <?php }?>
                <?php }?>
                <?php if($total==0){?>
                    <div style="margin-top:25px; text-align:center">暂无数据</div>
                    <?php }?>
                <div class="megas512" style="clear:both"><?=pageft($total,$pagesize,u(MOD,ACT,array('do'=>$do)));?></div>
                </div>
                <div class="admin_botton">
                <div class="admin_botton_back" id="startShare">我要分享</div>
                <a href="<?=u('user','tradelist')?>"><div class="admin_botton_back">我要晒单</div></a>
                <a href="<?=u('zhidemai','baoliao')?>"><div class="admin_botton_back">我要爆料</div></a>
                </div>
            </div>
    	</div>
  </div>
</div>

<?php
include(TPLPATH."/baobei/share.tpl.php");
include(TPLPATH.'/inc/footer.tpl.php');
?>