<?php
/**
 * ============================================================================
 * 版权所有 多多科技，保留所有权利。
 * 网站地址: http://soft.duoduo123.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/

if(!defined('INDEX')){
	exit('Access Denied');
}
include(TPLPATH.'/inc/header.tpl.php');
?>
<script src="<?=TPLURL?>/inc/js/offer/jquery.KinSlideshow-1.2.1.min.js" type="text/javascript"></script>
<script src="<?=TPLURL?>/inc/js/offer/index.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?=TPLURL?>/inc/css/offer/offer_css.css" />
<div class="mainbody">
	<div class="mainauto">
    	<?php foreach($task_type_arr as $k=>$v){?>
        	<?php if($webset[$k]['status']==1){?>
            <div class="offer_l">
                <a href="<?=u('task',$k)?>">
                    <img src="<?=TPLURL?>/inc/images/ad_<?=$k?>.jpg" width="461" height="204" />
                </a>
                <a href="<?=u('task',$k)?>"><div class="tiyan_btn"></div></a>
            </div>
            <?php }?>
        <?php }?>
         <?php if($n==1){?>
        <div class="offer_l">
        	<span>敬请期待！</span>
            <a href="<?=u('task','index')?>"></a>
        </div>
        <?php }?>
        <div class="step"></div>
        <div class="jiaocheng">
        	<div class="jc_title">教程区</div>
            <div class="jc_tp">
            	<img src="<?=TPLURL?>/inc/images/jctp.jpg" />
            </div>
        </div>
    </div>
</div>

<?php include(TPLPATH.'/inc/footer.tpl.php');?>