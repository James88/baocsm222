<?php
if (!defined('INDEX')) {
	exit ('Access Denied');
}
$webtitle=$dd_tpl_data['title'].'-帮助中心';
include(TPLPATH.'/inc/header.tpl.php');
?>
<div class="new-ct">
    <div class="new-category">
		<ul class="new-category-lst">
			<li class="new-category-li">
    			<a href="javascript:void(0)" id="1315" class="new-category-a"><span class="icon"></span>帮助中心</a>
    			<ul class="new-category2-lst" id="category1315">
    			    <li class="new-category2-li">
    				   <div class="text"><?=$dd_tpl_data['help']?></div>
    				</li>
                </ul>
			</li>
            
            
		</ul>
    </div>
</div>
</div>
<?php include(TPLPATH.'/inc/footer.tpl.php');?>