<?php
$parameter=user_tuiguang();
extract($parameter);
$css[]=TPLURL.'/inc/css/usercss.css';
include(TPLPATH.'/inc/header.tpl.php');
?>

<div class="mainbody">
	<div class="mainbody1000">
    <?php include(TPLPATH."/user/top.tpl.php");?>
    	<div class="adminmain">
        	<div class="adminleft">
                <?php include(TPLPATH."/user/left.tpl.php");?>
            </div>
        	<div class="adminright">
                <?php include(TPLPATH."/user/notice.tpl.php");?>
                <div class="admin_xfl">
                    <ul>
                    <li class="admin_xfl_xz"><a>我的推广</a> </li>
                    </ul>
              	</div>
                

                <div class="admin_table">
                    <table width="770" border="0" cellpadding="0" cellspacing="1">
                      <tr>
                        <th width="100" height="26">好友</th>
                        <th width="450">商品</th>
                        <th width="60">状态</th>
                        <th width="60">奖励</th>
                        <th width="100">时间</th>
                      </tr>
                      <?php foreach($tuiguang as $arr){?>
                      <tr>
                        <td height="33"><?=$arr['username']?></td>
                        <td><a class="ddnowrap" style="width:440px" href="<?=$arr['url']?>" target="_blank" title="<?=$arr['title']?>">【<?=$arr['type']?>】<?=$arr['title']?></a></td>
                        <td><?=$arr['status']==1?'已确认':'未确认'?></td>
                        <td><?=$arr['money']==0?'——':$arr['money'].'元'?></td>
                        <td><?=$arr['date']?></td>
                      </tr>
                      <?php }?>
                    </table>
              </div>
               <div class="megas512" style="clear:both"><?=pageft($total,$pagesize,u(MOD,ACT,array('do'=>$do)))?></div>
              
            
    	</div>
  </div>
</div>
</div>
<?php
include(TPLPATH.'/inc/footer.tpl.php');
?>