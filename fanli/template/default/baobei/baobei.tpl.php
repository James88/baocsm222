<?php 
$pagesize=20;
$where=" 1 ";
$cat_arr=$webset['baobei']['cat'];
$face_img=include(DDROOT.'/data/face_img.php');
$face=include(DDROOT.'/data/face.php');
foreach($cat_arr as $k=>$v){
	$cat_arrs[$k]['url']=u('baobei','list',array('cid'=>$k));
	$cat_arrs[$k]['title']=$v;
}
$url_arr=array();
$q=trim($_GET['q']);
if($q){
	$where.=" and a.`title` like '%".$q."%'";
	$url_arr['q']=$q;
}
$cid=intval($_GET['cid']);
$sort=$_GET['sort'];
if($sort!='id' && $sort!='hart' && $sort!='price'){
	$sort_sql=" ORDER BY a.sort=0 asc,a.sort asc,a.id desc ";
}else{
	$sort_sql=" order by a.`".$sort."` desc";
}

if($cid>0){
	$where_cid="and cid='".$cid."'";
	$where_cid2="and a.cid='".$cid."'";
	$where_cid3="and b.cid='".$cid."'";
	$url_arr['cid']=$cid;
}
elseif($cid==0){
	$where_cid="";
	$where_cid2="";
	$url_arr['cid']=0;
}

$page = !($_GET['page'])?'1':intval($_GET['page']);
$frmnum=($page-1)*$pagesize;
$xs=$xs?$xs:$_GET['xs'];
$uid=$uid?$uid:(int)$_GET['uid'];
$cid=$cid?$cid:(int)$_GET['cid'];

if($xs==1){//他的宝贝
	$total=$duoduo->count('baobei',"uid='".$uid."' ".$where_cid);
	$baobei=$duoduo->select_all('baobei as a,user as b','a.*,a.addtime,b.ddusername',"a.uid='".$uid."' and a.uid=b.id ".$where_cid." ORDER BY a.sort=0 asc,a.sort asc,a.id desc limit $frmnum,$pagesize");
}
elseif($xs==2){//他喜欢的宝贝
	$total=$duoduo->count('baobei_hart as a,baobei as b','a.uid="'.$uid.'" and a.baobei_id=b.id '.$where_cid3);
	$baobei=$duoduo->select_all('baobei_hart as a,baobei as b,user as c','b.id,b.title,b.img,b.hart,b.hits,b.content,b.commission,b.uid,b.price,c.ddusername','a.uid="'.$uid.'" and c.id=b.uid and a.baobei_id=b.id '.$where_cid.' ORDER BY a.sort=0 asc,a.sort asc,a.id desc limit '.$frmnum.','.$pagesize);
}else{
	$where.=" and a.uid=b.id $where_cid and a.del=0 and a.fabu_time<='".SJ."' and a.status=0 ";
	$total=$duoduo->count('baobei as a,user as b',$where);
	$baobei=$duoduo->select_all('baobei as a,user as b','a.`id`,a.`userimg`,a.`img`,a.`title`,a.`img`,a.`price`,a.`commission`,a.`hart`,a.`hits`,a.`content`,a.`uid`,a.addtime,b.ddusername',$where.$where_cid2." ".$sort_sql." limit $frmnum,$pagesize");
}

$cur_baobei_num=count($baobei);
for($i=0;$i<$cur_baobei_num;$i++){
	$baobei[$i]['_content']=str_replace($face,$face_img,$baobei[$i]['content']);
	$baobei[$i]['url']=u('baobei','view',array('id'=>$baobei[$i]['id']));
	$baobei[$i]['fxje']=jfb_data_type(fenduan($baobei[$i]['commission'],$webset['fxbl'],$dduser['type'],TBMONEYBL));
	if($baobei[$i]['userimg']!=''){
		$baobei[$i]['img']=$baobei[$i]['userimg'];
	}
}

if(defined('VIEW_PAGE')){
?>
<div class="item_list infinite_scroll">
  <?php }foreach($baobei as $v){?>
  <div class="item masonry_brick">
    <div class="item_t">
      <div class="img tb_img"> <a href="<?=$v['url']?>" target="_blank">
        <?=dd_html_img($v['img'],$v['title'],240)?>
        </a> <span class="price">￥
        <?=$v['price']?>
        <?php if($v['fxje']>0 && FANLI==1){?><span style="margin-left:15px;" title="返了<?=$v['fxje'].TBMONEY?>">返了<?=$v['fxje']?></span><?php }?></span> </div>
      <div class="title"> <a href="<?=u('baobei','user',array('uid'=>$v['uid']))?>" target="_blank" class="aimg"> <img src="<?=a($v['uid'],'small')?>" width="32" height="32" /> </a>
        <div class="jy_title"><a target="_blank" href="<?=u('baobei','user',array('uid'=>$v['uid']))?>"><span>
          <?=utf_substr($v['ddusername'],2).'***'?>
          </span></a><span>分享</span><a href="<?=$v['url']?>" target="_blank">
          <?=$v['title']?>
          </a></div>
        <div style="clear:both;"></div>
      </div>
    </div>
    <div class="item_b" style="border-bottom:1px solid #eaeaea; max-height:59px; overflow:hidden;">
      <?=$v['_content']?>
    </div>
    <div class="item_b clearfix">
      <div class="items_likes fl"> <a class="like_btn" onclick="like(<?=$v['id']?>,'x_<?=$v['id']?>')" ></a> <em class="bold" id="x_<?=$v['id']?>">
        <?=$v['hart']?>
        </em> </div>
    </div>
  </div>
  <?php }?>
  
<?php if(defined('VIEW_PAGE')||$_GET['page']<=1){?>
</div>
<?php }?>
