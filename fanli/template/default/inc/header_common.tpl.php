<div class="top">
    <div class="top1000">
      <div class="topleft" style="display:none">
        <div class="topleftA">您好，欢迎来到<?=WEBNAME?>！  请<a href="<?=u('user','login')?>"><span class="c_fcolor">登录</span></a> <!--/ <a href="<?=u('user','register')?>"><span class="c_fcolor">免费注册</span></a>--> <?php if($app_show==1){?>或使用<?php }?></div>
        <?php if($app_show==1){?>
        <div class=loginWays onmouseover=showLogin() onmouseout=showLogin()>
          <SPAN id=weibo_login class=firstWay>
            <A style="CURSOR: pointer" href="<?=u('api',$apps[0]['code'],array('do'=>'go'))?>"><img style="width:16px; height:16px" alt="用<?=$apps[0]['code']?>登录" src="<?=TPLURL?>/inc/images/login/<?=$apps[0]['code']?>_1.gif"><?=$apps[0]['title']?>登陆</A><SPAN class=icon-down></SPAN>
          </SPAN>
        <div style="DISPLAY: none" id=menu_weibo_login class=pw_menu>
        <ul class=menuList>
          <?php foreach($apps as $k=>$row){?>
          <li><A href="<?=u('api','do',array('code'=>$row['code'],'do'=>'go'))?>"><img style="width:16px; height:16px" alt='使用<?=$row['title']?>登录' src="<?=TPLURL?>/inc/images/login/<?=$row['code']?>_1.gif" /><?=$row['title']?>帐户登录</A></li>
          <?php }?>
        </ul>
      </div>
    </div>
    <?php }?>
  </div>
<script>
function topHtml() {/*<div class="topleftA" style="padding-top:10px;">
	<a href="<?=u('user')?>"><span class="c_fcolor">{$name}</span></a> 
	<a href="<?=u('user','msg')?>">{$msgsrc}</a>&nbsp;&nbsp;|&nbsp;&nbsp;余额：<a href="<?=u('user','mingxi')?>"><span class="c_fcolor">￥{$money}</span></a>&nbsp;&nbsp;
	<?php if(FANLI==1){?>
	<?=TBMONEY?>：<a href="<?=u('user','mingxi')?>"><span class="c_fcolor">{$jifenbao}</sapn></a> <?=TBMONEYUNIT?>&nbsp;&nbsp;|&nbsp;&nbsp;
	<?php }?>
</div>
<div class=loginWays1 onmouseover=showHide('menu_usernav') onmouseout=showHide('menu_usernav')>
          <SPAN>
            我的账户<em></em>
          </SPAN>
          <div id=menu_usernav>
            <div class="wode c_fcolor">我的账户<em></em></div>
            <ul>
              <li><A href="<?=u('user','tradelist')?>">我的订单管理</A></li>
			  <?php if(FANLI==1){?>
              <li><A href="<?=u('user','mingxi')?>">我的账户明细</A></li>
			  <?php if($webset['user']['shoutu']==1){?>
              <li><A href="<?=u('user','yaoqing')?>">我的邀请好友</A></li>
			  <?php }?>
			  <?php }?>
              <li><A href="<?=u('user','info')?>">我的账户设置</A></li>
            </ul>
          </div>
        </div>
		<div class"fl" style=" margin-top:10px">|&nbsp;&nbsp;&nbsp;<a href="<?=u('user','exit',array('t'=>TIME))?>">退出</a></div>*/;}

$.ajax({
	url: '<?=l('ajax','userinfo')?>',
	dataType:'jsonp',
	jsonp:"callback",
	success: function(data){
		if(data.s==1){
			DDUID=data.user.id;
			topHtml=getTplObj(topHtml,data.user);
			$('.container .topleft').html(topHtml).show();
		}
		else{
			$('.container .topleft').show();
		}
	}
});
</script>
  <div class="topright"> 
    <ul>
      <li> <a href="javascript:;" onClick="AddFavorite('<?=SITEURL?>','<?=WEBNAME?>')">收藏本站</a> </li>  
      <li> <a href="comm/shortcut.php" target="_blank">快捷桌面 </a></li>  
      <?php if($app_status==1){?>
      <li> <a href="<?=u('app','index')?>" target="_blank" style="*line-height:15px;">手机APP </a></li>
      <?php }?>
      <?php if($webset['shangjia']['status']==1){?>
      <li> <a style="color:#F00" target="_blank" href="<?=u('hezuo','index')?>">商家中心</a>   </li>
      <?php }?>
      <li id="fonta"> <a class="c_fcolor" href="<?=u('help','index')?>" target="_blank">网站帮助</a>   </li>
    </ul>
  </div>
</div>
</div>

<div class="search">
<div class="search1000">

<div class="logo">

  <a href="<?=SITEURL?>"><img src="<?=$dd_tpl_data['logo']?>" alt="<?=WEBNAME?>" style="height:70px; max-width:230px"/></a></div>


<div class="searchR"><div class='searchbox' id="searchbox">
<div style="TEXT-AliGN: left;">
<FORM style="FLOAT: left" class='frombox' method='get' name='formname' action='index.php' target="_blank" autocomplete="off" onsubmit="return checkSubFrom('#s-txt');">
<input type="hidden" id="mod" name="mod" value="inc" class="mod" /><input type="hidden" id="act" name="act" value="check" class="act" />
<SPAN class="box-middle c_border">
<INPUT id=s-txt class=s-txt name='q' x-webkit-speech value='请输入商城名，关键词查询' moren="<?=$webset['search_key']['head']?>"/>

<INPUT class="sbutton c_bgcolor" type=submit value="购物搜索">
</SPAN> 
<SPAN class=box-right></SPAN>
</FORM>
<p></p>
</div>
</div></div>
<div class="header-fa">
<?php 
if($app_status==1){
	$phone_url='href="'.u('app','index').'" target="_blank"';
}
else{
	$phone_url='href="javascript:alert(\'开发中，敬请期待\');"';
}
?>
<a class="fa-link" <?=$phone_url?> ><img src="<?=TPLURL?>/inc/images/right_sj_1.png" /></a>
</div>
</div>
</div>

<div class="c_bgcolor daohang" id="navdaohang">
  <div class="daohang1000">
    <ul class="ulnav">
    <?php 
	$nav_c=count($nav);
	$nav_num=10; //导航个数
	$nav_c=$nav_c>=$nav_num?$nav_num:$nav_c;
	
	$nav_cur_ok=0;
	if($_GET['code']!=''){
		for($i=0;$i<$nav_c;$i++){
			$dom_id = "";
			if ($nav[$i]['code'] == $_GET['code'] && $nav_cur_ok==0) {
				$nav[$i]['dom_id'] = "id='fontc'";
				$nav_cur_ok=1;
			}
			else{
				$nav[$i]['dom_id'] = "";
			}
		}
	}
	
	for($i=0;$i<$nav_c;$i++){
		$have_child_class='';
		if($nav_cur_ok==0){
			$dom_id = "";
			if ($nav[$i]['tag'] == PAGETAG && $nav_cur_ok==0) {
				$dom_id = "id='fontc'";
				$nav_cur_ok=1;
			}
		}
		else{
			$dom_id=$nav[$i]['dom_id'];
		}
	    
		if(!empty($nav[$i]['child'])){
			$have_child_class=' have_child';
			$em='<em></em>';
		}
		else{
			$have_child_id='';
			$em='';
		}
		if($i==$nav_c-1){
			$lastclass=' last';
		}
		else{
			$lastclass=' ';
		}
	?>
      <li class="c_bgcolor linav<?=$have_child_class?><?=$lastclass?>" <?=$dom_id?>> <a <?=$nav[$i]['target']?> class="anav c_fcolor" href="<?=$nav[$i]['link']?>"><?=$nav[$i]['title']?><?=$nav[$i]['type_img']?><?=$em?></a>
      <?php if($em!=''){?>
      <ul class="n-h-list c_hborder" style="background:#fff; border-style:solid; border-width:0px 1px;">
        <?php foreach($nav[$i]['child'] as $row){?>
        <li><a class="c_border" <?=$row['target']?> href="<?=$row['link']?>"><?=$row['title']?> <?=$row['alt']?></a> </li>
        <?php }?>
	  </ul>
      <?php }?>
      </li>
    <?php }?>
      
    </ul></div>
</div>

<script>
var sousuoxiala=new Array();
sousuoxiala[0]=new Array("tao","view","淘宝相关宝贝"); 
<?php if(BIJIA>1){?>
sousuoxiala[1]=new Array("mall","goods","全网比价");
<?php }?>

//sousuoxiala[3]=new Array("zhannei","index","站内精选宝贝"); 
/*sousuoxiala[4]=new Array("zhidemai","index","值得买精选宝贝"); */

$searchInput=$("#s-txt");

$(".have_child").hover(function() {
	thisId=$(this).attr('id');
	$(this).attr('id','navc');
    $(this).find("a").eq(0).addClass("sub_on").removeClass("sub");
    $(this).find("ul").show();
},function() {
	if(typeof(thisId) == "undefined"){
		thisId='';	
	}
	$(this).attr('id',thisId);
    $(this).find("a").eq(0).addClass("sub").removeClass("sub_on");
    $(this).find("ul").hide()
});
$searchInput.focusClear();
</script>
<div id="header-bottom" style="height:0px; overflow:hidden"></div>