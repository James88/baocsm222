<?php //商城比价
$parameter=act_paipai_list($dd_tpl_data['paipai']['keyWord'],$dd_tpl_data['paipai']['sort'],$dd_tpl_data['paipai']['pagesize']);
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
         
        <div class="goodsleft c_border">
        
        	<div class="goodslist" style="border:1px solid #CCCCCC;">
            <?php if(FANLI==1){?><div style="margin:10px 0 0 10px;width:700px;border:solid 1px #F30; height:24px; line-height:26px; padding-left:20px; font-weight:bold; background:#FFC"><img src="images/cuo.gif" alt="提醒" style="margin-bottom:-2px" />&nbsp;&nbsp;温馨提示：拍拍虚拟商品无返利！</div><?php }?>
<form action="<?=SITEURL?>/index.php">
            <table border="0" style="margin:10px 0 0 10px;width:720px;border:solid 1px #E1E1E1; height:33px;">
  <tr>
    <td style="padding-left:3px">关键字：<input type="text" name="q" onfocus="this.value=''" value="<?=$q?>" style=" width:60px;" class="input-text" /></td>
    <td>价格：<input name="begPrice" type="text" class="input-text" value="<?=$begPrice==0?'':$begPrice?>" style="width:40px" /> 至 <input value="<?=$endPrice==0?'':$endPrice?>" name="endPrice" type="text" class="input-text" style="width:40px" /></td>
    <td>选项：<?=select($property_arr,$property,'property')?></td>
    <td>排序：<?=select($sort_arr,$sort,'sort')?></td>
    <td><input type="hidden" name="mod" value="<?=MOD?>" /><input type="hidden" name="act" value="<?=ACT?>" /><input class="searchbutton" type="submit" value="" /></td>
    <td align="right" width="100" style="padding-right:3px"><a href="<?=$showpic_list1?>" class="noline"><img src="<?=TPLURL?>/inc/images/list1<?=$list?>.gif" alt="小图片模式"  /></a>&nbsp;<a href="<?=$showpic_list2?>" class="noline"><img src="<?=TPLURL?>/inc/images/list2<?=$list?>.gif" alt="大图片模式"  /></a></td>
  </tr>
</table>
</form>
                <?php include(TPLPATH."/paipai/list".$list.".tpl.php");?> 
                <div class="megas512" ><?=pageft($total,$pagesize,$show_page_url,WJT)?></div>
            </div>
            
        </div> 
        <div class="goodsright">
        	<div class="shopmessage gonggao biaozhun1 bz_first">
            <?php include(TPLPATH."/paipai/category_right.tpl.php");?>
        
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