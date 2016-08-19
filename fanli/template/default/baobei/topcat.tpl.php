<div id="ddlanmu">
<div class="jy_tl">
    <div class="jy_auto">
            <div class="jy_nav">
            	<a href="<?=$cat_url?>" <?php if(!isset($_GET['cid'])){?>class="cur c_border"<?php }?>>全部</a>
            	<?php foreach($cat_arrs as $k=>$v){?>
                <a href="<?=$v['url']?>" <?php if($v['cid']==$_GET['cid']){?>class="cur c_border"<?php }?>><?=$v['title']?></a>
                <?php }?>
                <a href="<?=$shaidan_url?>" class="shaidanbtn"></a>
                <div style="clear:both"></div>
            </div>
        </div>
    </div>
</div>