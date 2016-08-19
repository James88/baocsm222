<?php
$parameter=act_user_mingxi();
extract($parameter);
$css[]=TPLURL."/inc/css/usercss.css";
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
            <div class="c_border" style="border-top-style:solid; border-top-width:2px;padding-top:10px;">
                <?php include(TPLPATH."/user/notice.tpl.php");?>
                <div class="admin_xfl">
                    <ul>
                    <li id="in"><a href="<?=u('user','mingxi',array('do'=>'in'))?>">我的收入明细</a> </li>
                    <li id="out" ><a href="<?=u('user','mingxi',array('do'=>'out'))?>">我的提取明细</a> </li>
                    <li id="tui" ><a href="<?=u('user','mingxi',array('do'=>'tui'))?>">我的退款明细</a> </li>
                    <li id="kou" ><a href="<?=u('user','mingxi',array('do'=>'kou'))?>">我的扣除明细</a> </li>
                    </ul>
                    <script>
                    $(function(){
					    $('.admin_xfl li#<?=$do?>').addClass('admin_xfl_xz');
					})
                    </script>
              	</div>
                <div class="admin_table">
                    <table width="770" border="0" cellpadding="0" cellspacing="1">
                    <?php if($do=='in'){?>
                      <tr>
                        <th width="120" height="26">收入事件</th>
                        <th>收入说明</th>
                        <th width="130">成交时间</th>
                      </tr>
                      <?php foreach($mingxi as $r){?>
                      <tr>
                        <td height="33"><?=$r["_title"]?></td>
                        <td style="text-align:left"><?=$webset['jifenbl']>0?$r["_content"]:preg_replace('/，积分[\\d]+/',' ',$r["_content"])?></td>
                        <td><?=$r["addtime"]?></td>
                      </tr>
                      <?php }?>
                     <?php }?>
                     <?php if($do=='kou'){?>
                      <tr>
                        <th width="120" height="26">扣除事件</th>
                        <th>扣除说明</th>
                        <th width="130">时间</th>
                      </tr>
                      <?php foreach($mingxi as $r){?>
                      <tr>
                        <td height="33"><?=$r["_title"]?></td>
                        <td style="text-align:left"><?=$r["_content"]?></td>
                        <td><?=$r["addtime"]?></td>
                      </tr>
                      <?php }?>
                     <?php }?>
                     
                     <?php if($do=='tui'){?>
                      <tr>
                        <th width="120" height="26">事件</th>
                        <th>说明</th>
                        <th width="130">时间</th>
                      </tr>
                      <?php foreach($mingxi as $r){?>
                      <tr>
                        <td height="33"><?=$r["_title"]?></td>
                        <td style="text-align:left"><?=$r["_content"]?></td>
                        <td><?=$r["addtime"]?></td>
                      </tr>
                      <?php }?>
                     <?php }?>
                     
                     <?php if($do=='out'){?>
                      <tr>
                        <th width="" height="26">收款工具</th>
                        <th width="10%">金额</th>
                        <th width="20%">状态</th>
                        <th width="15%">IP</th>
                        <th width="25%">时间</th>
                      </tr>
                      <?php foreach($mingxi as $r){?>
                      <tr>
                        <td height="33"><?=$r['_tx_tool']?></td>
                        <td><?=$r["_money"]?></td>
                        <td><?=$r["_status"]?></td>
                        <td><?=$r["ip"]?></td>
                        <td><?=$r["_addtime"]?></td>
                      </tr>
                      <?php }?>
                     <?php }?>
                    </table>
                    <?php if($total==0){?>
                    <div style="margin-top:25px; text-align:center">暂无数据</div>
                    <?php }?>
              </div>
              <div class="megas512" style="clear:both"><?=pageft($total,$pagesize,u(MOD,ACT,array('do'=>$do)));?></div>
            </div>
            </div>
    	</div>
  </div>
</div>
<?php
include(TPLPATH.'/inc/footer.tpl.php');
?>