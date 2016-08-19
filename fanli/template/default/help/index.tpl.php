<?php
$parameter=act_help_index();
extract($parameter);
$css[]=TPLURL."/inc/css/help.css";
include(TPLPATH.'/inc/header.tpl.php');
?>
<script>
function addBorder(id){
	$('.helpright_help_qa_q').css('border','0px').next('div').css('background','none');
 	$('#'+id).next('div').css('border','#30F 1px solid').next('div').css('background','#FFC');
}
$(function(){
	url=document.location.href;
    $('.helpright_wenti ul li a').click(function(){
		var url=$(this).attr('href');
	    addBorder(url)
	});
});

var DOM = (document.getElementById) ? 1 : 0; 
var NS4 = (document.layers) ? 1 : 0; 
var IE4 = 0; 
if (document.all) { 
	IE4 = 1; 
	DOM = 0; 
} 
var win = window; 
var n = 0; 

function findInPage(str) { 
	var txt, i, found; 
	if (str == "") 
	return false; 
	if (DOM){ 
		win.find(str, false, true); 
		return true; 
	} 
	if (NS4) { 
		if (!win.find(str)) 
			while(win.find(str, false, true)) 
			n++; 
		else 
			n++; 
		if (n == 0) 
		alert("未找到指定内容."); 
	} 
	if (IE4) { 
		txt = win.document.body.createTextRange(); 
		for (i = 0; i <= n && (found = txt.findText(str)) != false; i++) { 
			txt.moveStart("character", 1); 
			txt.moveEnd("textedit"); 
		} 
		if (found) { 
			txt.moveStart("character", -1); 
			txt.findText(str); 
			txt.select(); 
			txt.scrollIntoView(); 
			n++; 
		} 
		else { 
			if (n > 0) { 
			n = 0; 
			findInPage(str); 
		} 
		else 
			alert("未找到指定内容."); 
		} 
	} 
	return false; 
} 
</script>
<div class="mainbody">
	<div class="mainbody1000">
    	<div class="helpmain">
        	<div class="helpleft">
                <div class="helpleft1">
                        <div class="helpmenu c_border">
                        <div class="helpmenu_bt c_border">
                            <div class="helpmenu_bt_font"><div class="shutiao c_bgcolor"></div>帮助中心</div>
                            
                        </div>
                        <ul>
                        	<?php foreach($help_types as $k=>$v){?>
                            <li><div class="adminmenu_a"><a href="<?=$v['url']?>"><?=$v['title']?></a></div></li>
                            <?php }?>
                        </ul>
                        </div>
                </div> 	
                <div class="helpleft2">
                		<div class="helpmenu c_border">
                        <div class="helpmenu_bt">
                            <div class="helpmenu_bt_font"><div class="shutiao c_bgcolor"></div>在线客服</div>
                        </div>
                        <a target="_blank" style="cursor:pointer;" href="<?=$about_url?>"><div class="help_kf"></div></a>
                        <div class="help_txt">通过在线解答的方式为您提供咨询服务。</div>
                        </div>
                </div>
           </div>

        	<div class="helpright">
            <div class="c_border" style="border-top-style:solid; border-top-width:2px;">
              <div class="helpright_search">
                <h3>找帮助</h3><input type="text" id="helpsearchkang" class="helpsearchkang" value="" />  
<input class="helpsearchbt" name="" onclick="javascript:findInPage($('#helpsearchkang').val());" type="button" /> <span>简化搜索词语，便于查询结果</span>                </div>
                <div class="helpright_wenti">
                <h3>
                <?=$help_type_title?>
                </h3>
                <ul>
                <?php foreach($article as $row){?>
                <li><a href="javascript:scroller('a<?=$row['id']?>',500,15);addBorder('a<?=$row['id']?>')"><?=$row['title']?></a></li>
                <?php }?>
                </ul>
                </div>
            
            
        	  <div class="helpright_help">
                	<div class="helpright_help_qa">
                    <?php foreach($article as $row){?>
                    <a name="a<?=$row['id']?>" id="a<?=$row['id']?>"></a>
                        <div class="helpright_help_qa_q"><div class="tubiao_ask"></div><p><?=$row['title']?></p><div class="tree_on"></div></div>
                        <div style="width:778px;"><div class="tubiao_answer"></div><div class="helpright_help_qa_a"><p><?=$row['content']?></p></div><div style="clear:both"></div></div>
                     <?php }?> 
                    </div>
             </div>

            </div>
        	</div>
        </div>
  </div>
<?php include(TPLPATH.'/inc/footer.tpl.php');?>