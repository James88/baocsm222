<?php //商城比价
$parameter=act_mall_goods();
extract($parameter);
$css[]=TPLURL."/inc/css/goods.css";
$css[]=TPLURL."/inc/css/list.css";
include(TPLPATH.'/inc/header.tpl.php');
?>
<script type="text/javascript" src="js/jquery.lazyload.js"></script>
<script src="<?=TPLURL?>/inc/js/bigpic.js"></script>
<div class="mainbody">
	<div class="mainbody1000">
		
        <div class="small_big" id="layerPic">
			<div class="sell_bg"></div>
			<div class="photo"></div>
		 </div>
         
        <div class="goodsleft">
        
        	<div class="goodslist" style="border:1px solid #ccc; border-top:2px solid #f36519;">
<form action="<?=SITEURL?>/index.php">
            <table border="0" style="margin:10px 0 0 10px;width:720px;border:solid 1px #E1E1E1; height:33px;">
  <tr>
    <td style="padding-left:3px" width="120">关键字：<input type="text" name="q" onfocus="this.value=''" value="<?=$q?>" style=" width:60px;" class="input-text" /></td>
    <td width="150">价格：<input name="start_price" type="text" class="input-text" value="<?=$start_price?>" style="width:40px" /> 至 <input value="<?=$end_price?>" name="end_price" type="text" class="input-text" style="width:40px" /></td>
    <td width="70"><input type="hidden" name="mod" value="mall" /><input type="hidden" name="act" value="goods" /><input type="hidden" name="merchantId" value="<?=$merchantId?>" /><input class="searchbutton" type="submit" value="" /></td>
    <td align="right" width="" style="padding-right:3px"><a href="<?=$showpic_list1?>" class="noline"><img src="<?=TPLURL?>/inc/images/list1<?=$list?>.gif" alt="小图片模式"  /></a>&nbsp;<a href="<?=$showpic_list2?>" class="noline"><img src="<?=TPLURL?>/inc/images/list2<?=$list?>.gif" alt="大图片模式"  /></a></td>
  </tr>
</table>
</form>
                <?php include(TPLPATH."/mall/goods".$list.".tpl.php");?> 
                <div class="megas512" ><?=pageft($total,$pagesize,$show_page_url,WJT)?></div>
            </div>
            
        </div> 
        <div class="goodsright">
        	<div class="shopmessage gonggao biaozhun1 bz_first">
            <?php include(TPLPATH."/mall/category_right.tpl.php");?>
        
            </div>
           <?=AD(4)?>         
        </div>
	</div>
</div>	
<script language="javascript">
$(function() {    
    $("div.pic a img").lazyload({
        placeholder : "<?=TPLURL?>/inc/images/grey.gif",
        effect      : "fadeIn",
	    threshold : 200
    });
});
</script>
<?php include(TPLPATH.'/inc/footer.tpl.php');?>