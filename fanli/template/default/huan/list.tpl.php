<?php
$parameter=act_huan_list();
extract($parameter);
$css[]=TPLURL.'/inc/css/duihuan.css';
include(TPLPATH.'/inc/header.tpl.php');
?>
<div class="biaozhun5" style="width:1000px; background:#FFF; margin:auto; margin-top:10px; padding-bottom:10px">
<div class="c_border" style="border-top-style:solid; border-top-width:2px;">
<div id="main">
<?=AD(10)?>
  <div id="apDiv6">
    <?php include(TPLPATH."/huan/left.tpl.php");?>
  </div>
  <div id="apDiv7">
  <div id="apDiv8">
    <?php include(TPLPATH."/huan/top.tpl.php");?>
  </div>
  <div id="apDiv1124">
  <?php if($jifenbao_huan_goods==1){?>
  <div class="tbdplist4" style="_margin-left:5px">
      <div class="apDiv4">
      <div class=syts></div>
        <a href="<?=$tixian_jifenbao?>"><img src="images/jfblogo.gif" width="130" height="130" alt="兑换集分宝" /></a>
      </div>
    <div id="apDiv15"><a style="font-size:14px; color:#F00" href="<?=$info_jifenbao?>" title="集分宝说明" target="_blank">兑换集分宝</a></div>
    <div id="apDiv16"><a href="<?=$info_jifenbao?>" title="什么是集分宝" target="_blank" style="color:#F00; text-decoration:underline">什么是集分宝？</a></div>
    </div>
  <?php }?>
  
  <?php foreach($huan as $row){$n++;?>
    <div class="tbdplist4" <?php if($n==1 && $jifenbao_huan_goods==0){?> style="_margin-left:5px" <?php } ?>>
      <div class="apDiv4">
      <?php 
		if($row["edate"]<TIME && $row["edate"]>0){
			$fs="<div class=sgq></div>";
		}
		elseif($row["sdate"]>TIME){
		    $fs="<div class=wks></div>";
		}
		else{
			$fs="<div class=syts></div>";
		}
		echo $fs;
	?>
        <a href="<?=$row["url"]?>"><img src="<?php echo $row["img"];?>" width="130" height="130" alt="<?=$row["title"]?>" /></a>
      </div>
    <div id="apDiv15"><?=$row["title"]?></div>
    <?php
	if($row["jifen"]>0){
		$dh_need_jifen='<b style="color:#F00">'.$row["jifen"].'</b>&nbsp;积分&nbsp;&nbsp;';
	}
	else{
		$dh_need_jifen='';
	}
	if($row["jifenbao"]>0){
		$dh_need_jifenbao='<b style="color:#F00">'.jfb_data_type($row["jifenbao"]).'</b>&nbsp;'.TBMONEY;
	}
	else{
		$dh_need_jifenbao='';
	}
	?>
    <div id="apDiv16"><?=$dh_need_jifen?><?=$dh_need_jifenbao?></div>
    </div><?php }$n=0;?>
    <div style="clear:both"></div>
    <div class="megas512" style="clear:both;"><?=$pageurl?></div>
    </div>
    <div style="clear:both"></div>
</div>
<div style="clear:both"></div>
</div>
</div>
<div style="clear:both"></div>
</div>
<?php include(TPLPATH.'/inc/footer.tpl.php');?>