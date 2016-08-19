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

if(!defined('INDEX')){
	exit('Access Denied');
}$iid=iid_decode($_GET['iid']);

$mobile_tip=0;

$act=$_GET['act'];
$code=$_GET['code'];

if($act==''){
	jump('index');
}
if(isset($_GET['url'])){
    $url=$_GET['url'];
	if(!preg_match('#^http://#',$url)){
		$url=base64_decode($url);
	}
}
elseif($_COOKIE['tao_click_url']!=''){
	$url=$_COOKIE['tao_click_url'];
}
else{
	$url='';
}

set_cookie('tao_click_url','',0);

if(isset($_GET['pic'])){
    $pic=$_GET['pic'];
	if(!preg_match('#^http://#',$pic)){
		$pic=base64_decode($pic);
	}
}
else{
	$pic='';
}

$canshu=array($url,$pic);
StopAttack($canshu);
$url=$canshu[0];
$pic=$canshu[1];

if($dduser['id']>0){
	$uid=$dduser['id'];
}
elseif(isset($_GET['dduserid'])&& $_GET['dduserid']>0){
	$uid=$dduser['id']=$_GET['dduserid'];
}
else{
	$uid=0;
}

$fanli=1;

if($uid==0){
    $api=$duoduo->select_all('api','title,code','open=1 order by sort desc');
}

if($act=='goods' || $act=='shop'){
	if(preg_match('#^http://g.click.taobao.com#',$url)){
		if(strpos($url,'&ct=url%3D')!==false){
			preg_match('/&ct=url%3D(.*)&/',$url,$a);
			$url=urldecode(urldecode($a[1]));
		}
	}

	if(preg_match('#^http://redirect#',$url)){
		if(strpos($url,'&f=')!==false){
			preg_match('/&f=(.*)&k/',$url,$b);
			$s_url=$b[1].'%26unid%3D'.urlencode($uid);
			$url=str_replace($b[1],$s_url,$url);
		}
	}
}

switch($act){
    case 'goods':
	    $mallname="淘宝";
		$iid=iid_decode($_GET['iid']);
		jump(u('tao','view',array('iid'=>iid_encode($iid))));
        /*$price=(float)$_GET['price'];
        $name=$_GET['name'];
		$iframe_url='http://item.taobao.com/item.htm?id='.$iid;

		$a=$ddTaoapi->taobao_tbk_tdj_get($iid,1,1);
		$title=$a['ds_title'];
		$web_price=$a['ds_discount_price'];
		$mobile_price=get_tao_mobile_price($iid);
		if($mobile_price>0 && $web_price-$mobile_price>1){  //网站价格大于手机价格1元，为有手机专享价
			$mobile_tip=1;
		}
		$url=$a['ds_item_click'];
		if($url==''){
			error_html('淘点金未设置或未生效');
		}
		$click_url=$url=set_tao_click_uid($url,$uid);*/
		
	break;
	
	case 'paipaigoods':
	    $mallname="拍拍";
		$id=(int)$_GET['id'];
        $fan=(float)$_GET['fan'];
        $price=(float)$_GET['price'];
        $name=$_GET['name'];
		if($url==''){
			$commId=$_GET['commId'];
			include(DDROOT.'/comm/paipai.class.php');
			$paipai_set['userId']=$webset['paipai']['userId'];
			$paipai_set['qq']=$webset['paipai']['qq'];
			$paipai_set['appOAuthID']=$webset['paipai']['appOAuthID'];
			$paipai_set['secretOAuthKey']=$webset['paipai']['secretOAuthKey'];
			$paipai_set['accessToken']=$webset['paipai']['accessToken'];
			$paipai_set['fxbl']=$webset['paipaifxbl'];
			$paipai_set['cache_time']=$webset['paipai']['cache_time'];
			$paipai_set['errorlog']=$webset['paipai']['errorlog'];
			$paipai=new paipai($dduser,$paipai_set);
			$thegoods=$paipai->cpsCommQueryAction(array('commId'=>$commId));
			if($thegoods==102){
				$url='http://auction1.paipai.com/'.$commId;
			}
			else{
				$url=$thegoods['tagUrl'];
				$pic=$thegoods['middleImg'];
				$fan=$thegoods['fxje'];
			}
		}
		if($fan<=0) $fanli=0;
		$fan.='元';
		$iframe_url=$url;
	break;
	
	case 's8':
	    $mallname="去拿返利";
		$name=$_GET['name'];
		if($name!=''){$mallname=$name;}
		$iframe_url=$url;
		if($iid!=''){
			$_url=$duoduo->select('goods','tg_url','data_id="'.$iid.'"');
			if($_url!=''){
				$url=$_url;
			}
		}
		if($url==''){
			$url=$ddTaoapi->taobao_taobaoke_listurl_get($name,$uid);
		}
	break;
	case 'shop':
	    $mallname="淘宝";
		$user_id=(float)$_GET['user_id'];
		$name=$nick=$_GET['nick'];
		
		if($user_id==0){
			$shop=$ddTaoapi->taobao_tbk_shops_detail_get($nick);
			if(is_array($shop)){
				$user_id=$shop['user_id'];
			}
		}
		if($user_id>0){
			$a= $ddTaoapi->taobao_tbk_tdj_get($user_id,2,1);
			$url=$a['ds_shop_click'];
		}
		
		if($url==''){
			$url='http://store.taobao.com/shop/view_shop.htm?user_number_id='.$user_id;
		}

		$click_url=$url=set_tao_click_uid($url,$uid);
		
	break;
	case 'mall':
		$mall_table_name=get_mall_table_name();
		$mid=(int)$_GET['mid'];
		$url=$_GET['url'];
		if($mid==0){
			$mall=$duoduo->select($mall_table_name,'*','domain="'.get_domain($url).'"');
		}
		else{
			$mall=$duoduo->select($mall_table_name,'*','id="'.$mid.'"');
		}
		if($url!=''){
			$mall['url']=$url;
		}
		if($mall['lm']==2){
			if(strpos($mall['pinyin'],'yamaxun')!==false){
				if($url==''){
					$url='http://www.amazon.cn/?a=1';
				}
				if(strpos($url,'?')!==false){
					$url.='&';
				}
				else{
					$url.='?';
				}
				$url.='tag=lktrb-23&ascsubtag='.$webset['linktech']['wzbh'].$dduser['id'];
			}
			else{
				$url="http://click.linktech.cn/?m=".$mall['merchant']."&a=".$webset['linktech']['wzbh']."&l=99999&l_cd1=0&l_cd2=1&tu=".urlencode($mall['url'])."&u_id=0";
			}
		}
		elseif($mall['lm']==3){
			if(strpos($mall['pinyin'],'yamaxun')!==false){
				if($webset['yiqifa']['shbh']==''){
					PutInfo('您的亿起发商户编号为空，不能推广亚马逊，请咨询亿起发客服索取');
				}
				if($url==''){
					$url='http://www.amazon.cn';
				}
				$url='http://o.yiqifa.com/servlet/getAmazonLink?storeid='.$webset['yiqifa']['shbh'].'&userno='.$dduser['id'].'&url='.urlencode($url);
				$url=urldecode(dd_get($url));
			}
			else{
				if($url!=''){
					$qu=strstr($mall['yiqifaurl'],'&t=');
					$url=str_replace($qu,'&t='.$mall['url'],$mall['yiqifaurl']);
				}
				else{
					$url=$mall['yiqifaurl'];
				}
			}
		}
		elseif($mall['lm']==4){
			if(strpos($mall['pinyin'],'yamaxun')!==false){
				if($url==''){
					$url='http://www.amazon.cn/?a=1';
				}
				
				if(strpos($url,'?')!==false){
					$url.='&';
				}
				else{
					$url.='?';
				}
				$url.='tag=duomairb-23&linkCode=ur2&camp=536&creative=3200&ascsubtag='.$webset['duomai']['wzid'].'_310_0_'.$dduser['id'].'_1';
			}
			else{
				$url="http://c.duomai.com/track.php?sid=".$webset['duomai']['uid'].$webset['duomai']['wzbh']."&aid=".$mall['duomaiid']."&euid=0&t=".urlencode($mall['url']);
			}
		}
		elseif($mall['lm']==1){
			$url="http://count.chanet.com.cn/click.cgi?a=".$webset['chanet']['wzid']."&d=".$mall['chanet_draftid']."&u=0&e=&url=".urlencode($mall['url']);
		}
		elseif($mall['lm']==5){
			$url="http://track.weiyi.com/sr.aspx?m=".$mall['weiyiid']."&w=".$webset['weiyi']['wzbh']."&d=0000&u=0&t=".urlencode($mall['url']);
		}
		elseif($mall['lm']==6){
			$url=$mall['wujiumiaourl'].'&to='.urlencode($mall['url']);
		}elseif($mall['lm'] == 7){
			$url="http://www.yqhlm.com/jump.php?wid=".$webset['yqh']['wzid']."&mid=".$mall['yqhid']."&euid=0&t=".urlencode($mall['url']);
		}elseif($mall['lm'] == 8){
			$url=DD_U_URL.'/index.php?g=mall&m=mall&a=jump&site_id='.$webset['siteid'].'&siteurl='.urlencode(SITEURL).'&mid='.$uid.'&mall_url='.urlencode($mall['url']).'&chanpin=7';
		}
		elseif($mall['lm'] == 9){
			$nick=$mall['tbnick'];	
			$url=u('jump','shop',array('nick'=>$nick));
		}
		else{
			error_html('miss lm',5);
		}

	    $pic=http_pic($mall['img']);
	    $fan=$mall['fan'];
	    $mallname=$mall['title'];
	    $iframe_url=$mall['url'];
	break;
	case 'huodong':
		$mall_table_name=get_mall_table_name();
	    $hid=$_GET['hid'];
		
		$huodong=$duoduo->select('huodong','*','id="'.$hid.'"');
		$domain=get_domain($huodong['url']);
		if(strpos($huodong['url'],'redbaby.suning.com')!==false){//先搜红孩子
			$mall_id=(int)$duoduo->select($mall_table_name,'id','url like "%redbaby.suning.com%"');
		}elseif(strpos($huodong['url'],'suning.com')!==false){//其余有苏宁的
			$mall_id=(int)$duoduo->select($mall_table_name,'id','url like "%www.suning.com%"');
		}else{
			$mall_id=(int)$duoduo->select($mall_table_name,'id','domain="'.$domain.'"');
		}
		if($mall_id>0){
			$huodong['mall_id']=$mall_id;
		}

		jump(u(MOD,'mall',array('mid'=>$huodong['mall_id'],'url'=>$huodong['url'])));
	break;
	
	case 'mall_goods':
        $fan=$_GET['fan'];
        $price=(float)$_GET['price'];
        $name=$_GET['name'];
		$mallname='商城';
	break;
}

if($code!='' && preg_match('/goods\|/',$code)){
	$uid.=','.$code;
}
$url=check_jump_url($url,$uid);

function do_tdj_url($url,$iid='',$nick='',$name=''){
	if(defined('TDJ_URL') && TDJ_URL!='' && TDJ_URL!=SITEURL && strpos(CUR_URL,TDJ_URL)===false){
		if(ACT=='s8' ){
			$url=u('inc','click_jump',array('type'=>ACT,'q'=>$name,'url'=>$url));
		}
		elseif(ACT=='goods'){
			$url=u('inc','click_jump',array('type'=>ACT,'iid'=>iid_encode($iid)));
		}
		elseif(ACT=='goods'){
			$url=u('inc','click_jump',array('type'=>ACT,'nick'=>$nick));
		}
		$url=str_replace(SITEURL,TDJ_URL,$url);
	}
	return $url;
}

if ($webset['ucenter']['open'] == 1 && $dduser['id'] > 0 && $dduser['ucid']>0) {
	include DDROOT . '/comm/uc_define.php';
	include_once DDROOT . '/uc_client/client.php';
	$ucsynlogin = uc_user_synlogin($dduser['ucid']); //同步登陆代码
}
else{
	$ucsynlogin='';
}

if($_GET['go_tb']==1){
	echo $ucsynlogin;
	click_jump($url);
}

if($url!='' && ($dduser['id']>0 || $webset['user']['login_tip']==0)){
	if($dduser['id']>0){
		if(ACT=='goods' or ACT=='s8'){
			$duoduo->buy_log(array('iid'=>$iid,'uid'=>$dduser['id'],'keyword'=>trim($name),'is_cf'=>(int)$_GET['is_cf']));
		}
		if(isset($_GET['fuid']) && $_GET['fuid']>0){
			unset($data);
			$data['fuid']=$_GET['fuid'];
			$data['uid']=$dduser['id'];
			$data['mall']=$_GET['mall'];
			$data['code']=$_GET['code'];
			$data['shuju_id']=$_GET['shuju_id'];
			$data['goods_id']=$_GET['goods_id'];
			$duoduo->ddtuiguang_insert($data);
		}
		if(TAOTYPE==1 && empty($dduser['tbnick']) && $webset['taoapi']['auto_fanli_plan']['trade_uid']==1 && (ACT=='goods' or ACT=='shop' or ACT=='s8')){
			$need_tbnick=1;
			set_cookie('jump_url',$url,600);
		}
	}
	if(($need_tbnick!==1 && $mobile_tip==0) || $webset['user']['login_tip']==0){
		echo $ucsynlogin;
		click_jump($url);
	}
}
else{
	dd_session_start();
	$_SESSION['api_login_reffrer']=SITEURL.'/index.php?'.arr2param($_GET);
}

$url=CUR_URL.'&go_tb=1';
?>