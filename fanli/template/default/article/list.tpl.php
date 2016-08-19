<?php
$parameter=act_article_list();
extract($parameter);
$css[]=TPLURL.'/inc/css/article.css';
include(TPLPATH.'/inc/header.tpl.php');
?>
<div class="mainbody">
<div class="mainbody1000">
<div class="fuleft c_border" >
	<div class="c_border" style="border-top-style:solid; border-top-width:2px;">
	<div class="news_list biaozhun5" style="min-height:500px;">
    	 <div style=" margin-top:10px; margin-left:15px;float:left; font-family:宋体"><a href="<?=$index_url?>">文章首页</a> >> <?=$type_name?> </div><br />
    	<div class="news_list_bt"><?=$catname?></div>
        <ul>
        <?php foreach($list as $row){?>
        <li><a href="<?=$row['url']?>"><?=$row['title']?></a><span><?=$row['add_time']?></span></li>
        <?php }?>
        </ul>
        <div ><div class="megas512"><?=$pageurl?></div></div>
    </div>
    </div>
</div>
<div class="furight">
<?php include TPLPATH."/article/right.tpl.php";?>
</div>

</div>
</div>
<?php include(TPLPATH.'/inc/footer.tpl.php');?>
