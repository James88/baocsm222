<?php 
/**
 * ============================================================================
 * 版权所有 多多科技，保留所有权利。
 * 网站地址: http://soft.duoduo123.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/

if(!defined('ADMIN')){
	exit('Access Denied');
}

if($_GET['tpl']!=''){
	$duoduo->set_webset('WAP_MOBAN',$_GET['tpl']);
	jump(-1,'设置完成');
}

function get_tpl_info(){
	$f=DDROOT.'/m/template/*';
	$c=array();
	$a=glob($f);
	foreach($a as $v){
		if(file_exists($v.'/tpl_info')){
			check_bom($v.'/tpl_info/info.txt',1);
			$b=file_get_contents($v.'/tpl_info/info.txt');
			$b=dd_json_decode($b,1);
			$b['tpl']=str_replace(DDROOT.'/m/template/','',$v);
			$b['img']='../m/template/'.$b['tpl'].'/tpl_info/index.jpg';
			if(file_exists($v.'/tpl_info/jieshao.html')){
				$b['jieshao']=1;
			}
			else{
				$b['jieshao']=0;
			}
			if(WAP_MOBAN==$b['tpl']){
				$b['status']='abled';
				$b['status_msg']='使用中';
			}
			else{
				$b['status']='enabled';
				$b['status_msg']='未使用';
			}
			$c[]=$b;
		}
	}
	return $c;
}

$tpls=get_tpl_info();
$url=DD_YUN_URL.'/?m=api&a=tuijian&type=4&siteurl='.urlencode(get_domain(URL)).'&banben='.$banben;
$tuijian_arr=dd_json_decode(dd_get($url),1);

include(ADMINTPL.'/header.tpl.php');
?>
<style>
.tpls{ padding-bottom:10px;}
.tpls .tpl{ float:left; width:172px; height:230px; margin-bottom:10px; margin-top:10px; margin-left:10px; position:relative;}
.tpls .tpl img{ display:block; width:170px; height:185px; border:1px solid #CCC; cursor:pointer}
.tpls .tpl .p{ text-align:center; margin-top:10px}
span.abled{ color:#090; font-weight:bold}
span.enabled{ color:#F00; font-weight:bold}
div.abled{ position:absolute;background:#000;filter:alpha(opacity=40);-moz-opacity:0.4;-khtml-opacity: 0.4;opacity: 0.4; text-align:center; color:#FFFFFF; font-family:宋体; font-size:32px; font-weight:bold; line-height:172px; width:172px; height:187px}
</style>
<script>
function setTpl(tpl){
	window.location.href='<?=u(MOD,ACT)?>&tpl='+tpl;
}
</script>
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
      <tr>
        <td width="80px" align="right">管理模版：</td>
        <td class="tpls">
        <?php foreach($tpls as $row){?>
        <div class="tpl" title="选择模板"><?php if($row['status']=='abled'){?><div class="abled">使用中</div><?php }?><img onclick="setTpl('<?=$row['tpl']?>')" src="<?=$row['img']?>" /><div class="p"><?=$row['title']?></div><div class="p"><span class="<?=$row['status']?>"><?=$row['status_msg']?></span>&nbsp;&nbsp;<a href="<?=u('template','admin_set',array('title'=>$row['title'],'tpl'=>$row['tpl'],'tpl_type'=>'wap'))?>">管理</a><?php if($row['jieshao']==1){?>&nbsp;&nbsp;<a href="../m/template/<?=$row['tpl']?>/tpl_info/jieshao.html">详细介绍</a><?php }?></div></div>
        <?php }?>
        </td>
      </tr>
      <tr>
        <td align="right">推荐模版：</td>
        <td class="tpls">
        <?php foreach($tuijian_arr as $k=>$row){?>
        <div class="tpl">
        <a href="<?=DD_YUN_URL?>/index.php?m=bbx&a=view&code=<?=$row['code']?>"><img src="<?=strpos($row['img'],'http')===false?DD_YUN_URL.$row['img']:$row['img']?>"/></a>
        <div class="p"><?=utf_substr($row['name'],24)?></div>
        <div class="p"><?php if($row['shouquan']==1){?><span class="abled">已购买</span><?php }else{?><a href="<?=DD_YUN_URL?>/index.php?m=bbx&a=view&code=<?=$row['code']?>"><span class="enabled">未购买</b></span><?php }?>&nbsp;<a href="<?=DD_YUN_URL?>/index.php?m=bbx&a=view&code=<?=$row['code']?>">说明</a></div>
        </div>
        <?php }?>
        <div class="tpl">
        <a href="<?=DD_YUN_URL?>/index.php?m=bbx&a=index&type=4"><img src="../images/gengduo.png"/></a>
        <div class="p"><a href="<?=DD_YUN_URL?>/index.php?m=bbx&a=index&type=4">更多模版 去看看</a></div>
        </div>
        </td>
      </tr>
    </table>
<?php include(ADMINTPL.'/footer.tpl.php');?>