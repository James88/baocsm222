<?php
if (!defined('INDEX')) {
	exit ('Access Denied');
}

$parameter=act_wap_bankuai();
extract($parameter);
?>
<?php include(TPLPATH.'/inc/header.tpl.php');?>
<div class="body">
	<p class="menu">
    <?php foreach($bankuai_wap as $row){?>
        <a href="<?=$row['url']?>"><span style="background:url(<?=$row['img']?>) 0px 0px; background-size:60px 60px" class="span1"></span><span class="span2"><?=$row['title']?></span></a>
        <?php }?>
    </p>
	
    
	<p class="nvyong_m">
        <a href="<?=wap_l('tao','list',array('q'=>'数码'))?>"><font style="background:#ff6600;color:#fff">数码</font></a>
        <a href="<?=wap_l('tao','list',array('q'=>'热卖'))?>">热卖</a>
        <a href="<?=wap_l('tao','list',array('q'=>'男装'))?>"><font style="background:#3366ff;color:#fff">男装</font></a>
        <a href="<?=wap_l('tao','list',array('q'=>'女装'))?>"><font color="#FF6600">女装</font></a>
        <a href="<?=wap_l('tao','list',array('q'=>'卫衣'))?>"><font color="#ff3366">卫衣</font></a>
        <a href="<?=wap_l('tao','list',array('q'=>'打底衫'))?>"><font style="background:#009933;color:#fff">打底衫</font></a>
        <a href="<?=wap_l('tao','list',array('q'=>'美妆'))?>"><font color="#ff6600">美妆</font></a>
        <a href="<?=wap_l('tao','list',array('q'=>'户外'))?>"><font style="background:#cc0033;color:#fff;font-weight:bold;">户外</font></a>
        </p>     
</div>
<?php include(TPLPATH.'/inc/footer.tpl.php');?>