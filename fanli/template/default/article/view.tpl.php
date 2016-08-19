<?php
$parameter=act_article_view();
extract($parameter);
$css[]=TPLURL.'/inc/css/article.css';
include(TPLPATH.'/inc/header.tpl.php');
?>
<div class="mainbody">
<div class="mainbody1000">
<div class="fuleft">
	<div class="c_border" style="border-top-style:solid; border-top-width:2px;">
	<div class="news_txt1 biaozhun5">
   	    <div class="news_top"><a href="<?=$article['url']?>"><?=$type[$article['cid']]?></a> >> <?=$article['title']?></div><br />
    	<div class="news_txt_bt1"><h1><?=$article['title']?></h1><div style="margin-top:5px; padding-bottom:5px"><span>发布时间：<?=$article['add_time']?>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;来源：<?=$article['source']?$article['source']:WEBNAME?>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;点击：<?=$article['hits']?></span></div></div>
        <div class="news_txt_txt1"><?=$article['content']?></div>
        <div class="news_txt_links">
        <ul>
        <li><span>上一篇：</span><a href="<?=$last_url?>"><?=$last_article?></a></li>
        <li><span>下一篇：</span><a href="<?=$next_url?>"><?=$next_article?></a></li>
        </ul>
        </div>
    </div>
    </div>
    
</div>
<div class="furight c_border">
<?php include TPLPATH."/article/right.tpl.php";?>
</div>

</div>
</div>
<?php 
include(TPLPATH."/inc/footer.tpl.php");
?>