<?php
$parameter=act_user_fenxiang();
extract($parameter);

if($webset['baobei']['share_status']==0 && $do=='share'){
	$do='shai';
}

$shenhe_arr=array(1=>'待审',2=>'通过',3=>'失败');

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
                    <li id="shai"><a href="<?=u(MOD,ACT,array('do'=>'shai'))?>">我的晒单</a> </li>
                    <script>
                    $(function(){
					    $('.admin_xfl li#<?=$do?>').addClass('admin_xfl_xz');
					})
                    </script>
                    </ul>
              	</div>
                <div class="admin_table">
                <?php if($do=='share' || $do=='shai'){?>
                
                   <table width="770" border="0" cellpadding="0" cellspacing="1">
                      <tr>
                        <th height="33">宝贝地址</th>
                        <th width="43">类别</th>
                        <th width="73">点击</th>
                        <th width="59">红心</th>
                        <th width="80">状态</th>
                        <th width="140">添加时间</th>
                        
                      </tr>
                      <?php foreach($baobei as $r){?>
                      <tr>
                        <td height="33"><a target="_blank" href="<?=$row["url"]?>">http://item.taobao.com/item.htm?id=<?=$r["tao_id"]?></a></td>
                        <td><?=$cat_arr[$r["cid"]]?></td>
                        <td><?=$r["hits"]?></td>
                        <td><?=$r["hart"]?></td>
                        <td><?=$r["fabu_time"]>SJ?'<span style=" color:red">待审核</span>':'<span style=" color:green">通过</span>'?></td>
                        <td><?=date('Y-m-d H:i:s',$r['addtime'])?></td>
                      </tr>
                      <?php }?>
                </table>
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
                        <td width="105" height="90" align="center"><a target="_blank" href="<?=$row['url']?>"><?=html_img($row['img'],1,$row['title'])?></a></td>
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
                <div style="text-align:center;">
                <div class="admin_botton" style=" padding-left:0px; height:80px; width:170px">
                	<a href="<?=u('user','tradelist')?>"><div class="admin_botton_back" style="margin-left:25px;">我要晒单</div></a><br />
                    <?php if($webset['baobei']['shai_jifen']>0 || $webset['baobei']['shai_jifenbao']>0){?><span style="float:left; padding:5px 0;"><i style="font-style:normal;">晒单奖励:</i><?php if($webset['baobei']['shai_jifen']>0){?><span style="color:#060;"><?=$webset['baobei']['shai_jifen']?>积分</span><?php }?>&nbsp;<?php if($webset['baobei']['shai_jifenbao']>0){?><span style="color:#f00;"><?=$webset['baobei']['shai_jifenbao'].TBMONEY?></span><?php }?></span><?php }?>
                </div>
                </div>
            </div>
    	</div>
  </div>
</div>

<?php
include(TPLPATH."/baobei/share.tpl.php");
include(TPLPATH.'/inc/footer.tpl.php');
?>