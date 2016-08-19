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
if($_GET['kuaijie_sub']!=''){
	$name = trim($_GET['name']);
	$url = trim($_GET['url']);
	if(!preg_match('/^http/',$url)){
		jump(u(MOD,ACT),'这不是一个有效的地址');
	}
	$id = $duoduo->select('kuaijie','id','title="'.$name.'" or url="'.$url.'"');
	if($id>0){
		jump(u(MOD,ACT),'快捷菜单已存在');
	}
	$duoduo->insert('kuaijie',array('title'=>$name,'url'=>$url));
	jump(u(MOD,ACT),'添加成功');
}

$nopid=0;
$domain=$duoduo->select('domain','*' ,'`mod`="goods" and close=0');
$taopid_arr=dd_get_cache('taopid');
foreach($domain as $row){
	if(!isset($taopid_arr[$row['url']])){
		$nopid=1;
		break;
	}
}

$duoduo->query('ALTER TABLE `'.BIAOTOU.'goods` CHANGE `tg_url` `tg_url` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;');
$sql="ALTER TABLE  `".BIAOTOU."goods` CHANGE  `nick`  `nick` VARCHAR( 20 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL";
$duoduo->query($sql);
$sql="ALTER TABLE `".BIAOTOU."mall` ADD `is_search` tinyint(1) DEFAULT '0'";
$duoduo->query($sql);

if(file_exists(DDROOT.'/update.php')){?>
<table width="700" border="0" align="center" style="border:#999999 1px solid;color:#FF0000; font-size:12px; padding-left:10px;">
<tr>
<td width="75" height="14"><img src="images/ipsecurity.gif" /></td>
<td width="613" height="26">您好，你的网站还没有升级完整，请点击 &quot;继续升级&quot; 以完成最后一步。<a href="../update.php" style="text-decoration:none; font-weight:bold; "> 继续升级</a><br>如果点击后还无法进入后台，请登录FTP删除根目录内的update.php文件即可！</td>
</tr>
</table>
<?php exit;}?>

<?php

if(file_exists(DDROOT."/kindeditor")){
	if(iswriteable(DDROOT."/".ADMIN_NAME)==0){
		exit('后台目录没有可写权限，请先设置为可写权限，成功进入后台中心后，可再将后台目录修改权限');
	}
	rename(DDROOT."/kindeditor",DDROOT.'/'.ADMIN_NAME.'/kindeditor');
}

if(file_exists(DDROOT."/data/upload_json.php") && iswriteable(DDROOT."/".ADMIN_NAME)==1){
	unlink(DDROOT.'/'.ADMIN_NAME.'/kindeditor/php/upload_json.php');
	rename(DDROOT."/data/upload_json.php",DDROOT.'/'.ADMIN_NAME.'/kindeditor/php/upload_json.php');
}

$alias=dd_get_cache('alias');
$_alias=dd_get_cache('_alias');
foreach($_alias as $k=>$row){
	if(!isset($alias[$k])){
		$alias[$k]=$row;
	}
}
dd_set_cache('alias',$alias);

$wjt=dd_get_cache('wjt');
$_wjt=dd_get_cache('_wjt');
foreach($_wjt as $k=>$row){
	foreach($row as $i=>$v){
		if(!isset($wjt[$k][$i])){
			$wjt[$k][$i]=$v;
		}
	}
}
dd_set_cache('wjt',$wjt);

if(isset($_GET['zsy'])){
	$_GET['time']=TIME;
	unset($_GET['mod']);
	unset($_GET['act']);
	unset($_GET['go_mod']);
	unset($_GET['go_act']);
	$data['val']=serialize($_GET);
	$duoduo->update('webset',$data,'var="admintempdata"');
	dd_exit(date('Y-m-d H:i:s',TIME));
}

$admin_name=ADMIN_NAME;
$install=0;
$install=file_exists('../install');
$banben=include(DDROOT.'/data/banben.php');

$admin_log=$duoduo->select_all('adminlog','*','1=1 order by id desc limit 5');

//待审核订单
$checked_trade_num=$duoduo->count('tradelist','checked=1');
//待回复站内信
$wait_see_msg_num=$duoduo->count('msg','see=0 and uid=0');
//待处理兑换
$wait_do_duihuan_num=$duoduo->count('duihuan','status=0');
//待处理体现
$wait_do_tixian_num=$duoduo->count('tixian','status=0');
//待卖家报名
$hezuo_num=$duoduo->count('hezuo','status=0');
//待审核shaidan
$baobei_num=$duoduo->count('baobei','status=2');

//数据统计
$stime=date("Y-m-d 00:00:00");
$dtime=date("Y-m-d 23:59:59");
$day=(int)$_GET['day'];
if($day==1){
	$stime=date("Y-m-d 00:00:00",strtotime("-6 day"));
	$dtime=date("Y-m-d 23:59:59");
	$tao_where='pay_time >= "'.$stime.'" and pay_time < "'.$dtime.'"';
}
if($day==2){
	$stime=date("Y-m-d 00:00:00",strtotime("-1 months"));
	$dtime=date("Y-m-d 23:59:59");
	$tao_where='pay_time >= "'.$stime.'" and pay_time < "'.$dtime.'"';
}
$tao_where=' and pay_time >= "'.$stime.'" and pay_time < "'.$dtime.'"';
$pai_where='chargeTime >= "'.strtotime($stime).'" and chargeTime < "'.strtotime($dtime).'"';
$mall_where=' and order_time >= "'.strtotime($stime).'" and order_time < "'.strtotime($dtime).'"';
$user_where=' and regtime >= "'.$stime.'" and regtime < "'.$dtime.'"';
$tixian_where=' and dotime >= "'.strtotime($stime).'" and dotime < "'.strtotime($dtime).'"';
$huan_where=' and addtime >= "'.strtotime($stime).'" and addtime < "'.strtotime($dtime).'"';
$task_where=' and addtime >= "'.$stime.'" and addtime < "'.$dtime.'"';
$game_where=' and addtime >= "'.$stime.'" and addtime < "'.$dtime.'"';
if($day==3){
	$tao_where='';
	$pai_where='';
	$mall_where='';
	$user_where='';
	$tixian_where='';
	$huan_where='';
	$task_where='';
}
//提现总额
$tixian_sum=round($duoduo->sum('tixian','money','type=1 and status=1'.$tixian_where)/TBMONEYBL,2)+$duoduo->sum('tixian','money','type=2 and status=1'.$tixian_where);

//兑换总额
$huan_sum=round($duoduo->sum('duihuan','spend','mode=1 and status=1'.$huan_where)/TBMONEYBL,2);

//总支出
$zhizhu_sum=$tixian_sum+$huan_sum;

//会员数量
$user_sum=$duoduo->count('user','1'.$user_where);

//淘宝联盟
$tao_goods_sum=$duoduo->sum('tradelist','real_pay_fee','1'.$tao_where);
$taobao_zsy=$duoduo->sum('tradelist','commission','1'.$tao_where);
$taobao_tradenum=$duoduo->count('tradelist','1'.$tao_where);
$tradenum_ok=$duoduo->count('tradelist','checked=2'.$tao_where);


//拍拍联盟
if($webset['paipai']['open']==1){
	$pai_goods_sum=$duoduo->sum('paipai_order','careAmount',$pai_where);
	$paipai_zsy=$duoduo->sum('paipai_order','commission',$pai_where);
	$paipai_tradenum=$duoduo->count('paipai_order',$pai_where);
	$paipai_tradenum_ok=$duoduo->count('paipai_order',$pai_where?'checked=2 and '.$pai_where:'checked=2');
}

//商城联盟
$mall_goods_sum=$duoduo->sum('mall_order','sales','status=1'.$mall_where);
$mall_zsy=$duoduo->sum('mall_order','commission','status=1'.$mall_where);
$mall_tradenum=$duoduo->count('mall_order','1'.$mall_where);
$mall_order_ok=$duoduo->count('mall_order','status=1'.$mall_where);
$mall_order_no=$duoduo->count('mall_order','status=0'.$mall_where);
$mall_no_user=$duoduo->count('mall_order','uid=0'.$mall_where);

//任务返利
$gametask=$webset['gametask'];
$douwantask=$webset['douwan'];
$offertask=$webset['offer'];
$task_status=0;
if($offertask['status']==1 || $gametask['status']==1 || $douwantask['status']==1){
	$task_status=1;
	$taskyj=$duoduo->sum('task','point,commission','(immediate="1" or immediate="2")'.$task_where);
	$tasknum=$duoduo->count('task','1'.$task_where);
	$tasknum_1=$duoduo->count('task','(immediate="1" or immediate="2")'.$task_where);
	$tasksy=$taskyj['commission']-$taskyj['point'];
}

$web_zsy=$taobao_zsy+$mall_zsy+$paipai_zsy+$gamesy;

$kuaijie = $duoduo->select_all('kuaijie','*','1 order by id asc');
?>