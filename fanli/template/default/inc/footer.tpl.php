<?php
if(!isset($article_class)){
	include_once(DDROOT.'/comm/article.class.php');
	$article_class=new article($duoduo);
}
$about_us_article=$article_class->select_all('cid="28" order by sort asc limit 4',0,'id,title');

$web_help_title=array(4=>'常见问题',5=>'频道说明',3=>'新手教程');
foreach($web_help_title as $k=>$v){
	$web_help_article[$k]=$article_class->select_all('cid="'.$k.'" order by sort asc limit 4',0,'id,title');
}
?>
<script>
$(function(){
	$('#tbox .rightnfixda6').hover(function(){
		$(this).find('i.rightnfixdspan2').show();
	},function(){
		$(this).find('i.rightnfixdspan2').hide();
	})
})
</script>
<div class="rightnfixd">
	<span id="tbox">
    	<a class="reightkf rfixedico rightnfixda1" id="gotop" href="javascript:void(0);"></a>
        <?php if($app_status==1){?>
        <a class="reightkf rfixedico rightnfixda2" href="<?=u('app','index')?>" target="_blank">
        	<i class="rfixedico rightnfixdspan1"><img src="<?=$webset['app']['erweima']?>" /></i>
        </a>
        <?php }?>
        <a class="reightkf rfixedico rightnfixda3" href="javascript:;" onClick="AddFavorite('<?=SITEURL?>','<?=WEBNAME?>')"></a>
        <?php
			$kefu=dd_get_cache('kefu');
			if(!empty($kefu)){		
		?>
        <div class="reightkf rfixedico rightnfixda6">
        	<i class="rightnfixdspan2">
            	<div class="right_jt"></div>
            	<p align="center">
                    联系客服<br />
                     <?php foreach($kefu as $row){?>
                     <?php if($row['type']==1){?>
                  	 <?=qq($row['code'])?>
                     <?php }else{?>
                     <?=wangwang($row['code'])?>
                  	<?php }}?>
                </p>
            </i>
        </div>
        <?php }?>
        <a class="reightkf rfixedico rightnfixda4" href="<?=u('user','favorite')?>"></a>
        <a class="reightkf rfixedico rightnfixda5" href="<?=u('user','mypath')?>"></a>
    </span>
</div>
<div style="clear:both; height:10px">&nbsp;</div>
<div class="bottom01 c_border">
<div class="xiangguan">
<ul>
<?php foreach($web_help_article as $k=>$row){?>
<li><a target="_blank" href="<?=u('article','list',array('cid'=>$k))?>"><h3><?=$web_help_title[$k]?> <span style="font-weight:normal; font-size:11px; font-family:宋体">more>></span></h3></a>
<?php foreach($row as $arr){?>
<p><a target="_blank" href="<?=u('article','view',array('id'=>$arr['id']))?>"><?=$arr['title']?></a></p>
<?php }?>
</li>
<?php }?>
<li><a target="_blank" href="<?=u('about','index')?>"><h3>关于我们 <span style="font-weight:normal; font-size:11px; font-family:宋体">more>></span></h3></a>
<?php foreach($about_us_article as $arr){?>
<p><a target="_blank" href="<?=u('about','index',array('id'=>$arr['id']))?>"><?=$arr['title']?></a></p>
<?php }?>
</li>
</ul>


</div>
<div id="line01">&nbsp;</div>
<div class="xhqu"><?=$webset['banquan']?></div>
</div>
</div>

</body>
</html>