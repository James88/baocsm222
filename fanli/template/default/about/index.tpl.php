<?php //关于我们
$parameter=act_about_index();
extract($parameter);
$css[]=TPLURL."/inc/css/about.css";
include(TPLPATH.'/inc/header.tpl.php'); 
?>
<div class="biaozhun5" style="width:1000px; background:#FFF; margin:auto; margin-top:10px; padding-bottom:10px">
<div class="c_border" style="border-top-style:solid; border-top-width:2px;">
<div class="main">
	<div class="piece about">
		<div class="white_top"><div class="white_top_left"></div><div class="white_top_middle"></div><div class="white_top_right"></div></div>
		<div class="white_bg">
			<div class="about_menu"><ul>
            <?php foreach($articles as $row){?>
			<li <?php if($id==$row['id']){?>class="cur"<?php }?>><a href="<?=$row['url']?>"><?=$row['title']?></a></li>
			<?php }?>
			</ul></div>
			<div class="about_contain">
				<div class="about_tit"><em></em><?=$article['title']?></div>
				<div class="about_line"></div>
				<div class="about_content">
				    <?=$article['content']?>
				</div>
			</div>
		</div>
		<div class="white_bottom"><div class="white_bottom_left"></div><div class="white_bottom_middle"></div><div class="white_bottom_right"></div></div>
	</div>
</div>
</div>
</div>
<?php include(TPLPATH.'/inc/footer.tpl.php');?>