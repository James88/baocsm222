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
}

function tao_item_cat($cid,$ddTaoapi){
	$TaobaokeData=$ddTaoapi->taobao_itemcat_msg($cid);
	$parent_cid=$TaobaokeData['parent_cid'];
	global $shai_cat_id_temp;
	$shai_cat_id_temp=in_tao_cat($parent_cid);
	if($shai_cat_id!=999){
		return false;
	}
	else{
	    tao_item_cat($parent_cid,$ddTaoapi);
	}
}

switch($act){
    case 'check_user':
	    echo $duoduo->check_user($_POST['username'],$_POST['type']);
	break;
	
	case 'check_oldpass':
	    echo $duoduo->check_oldpass($_POST['oldpass'],$_POST['dduserid']);
	break;
	
	case 'check_my_email':
	    $id=$duoduo->check_my_email($_POST['email'],$_POST['dduserid']);
		if($id>0){echo 'false';}
		else{echo 'true';}
	break;
	
	case 'check_my_alipay':
	    $id=$duoduo->check_my_field('alipay',$_POST['alipay'],$_POST['dduserid']);
		if($id>0){echo 'false';}
		else{echo 'true';}
	break;
	
	case 'check_my_tenpay':
	    $id=$duoduo->check_my_field('tenpay',$_POST['tenpay'],$_POST['dduserid']);
		if($id>0){echo 'false';}
		else{echo 'true';}
	break;
	
	case 'check_my_bank_code':
	    $id=$duoduo->check_my_field('bank_code',$_POST['bank_code'],$_POST['bank_code']);
		if($id>0){echo 'false';}
		else{echo 'true';}
	break;
	
	case 'check_email':
	    echo $duoduo->check_email($_POST['email']);
	break;
	
	case 'check_alipay':
	    echo $duoduo->check_alipay($_POST['alipay']);
	break;
	
	case 'check_captcha':
	    dd_session_start();
	    if(strtolower($_POST['captcha'])==strtolower($_SESSION["captcha"])){
	        echo 'true';
	    }
	    else{
	        echo 'false';
	    }
	break;
	
	case 'check_tbnick':
		$tbnick=$_POST['tbnick']?$_POST['tbnick']:$_GET['tbnick'];
		if(strrpos($dduser['tbnick'],$tbnick)){
			echo 'true';
		}else{
			$a=get_4_tradeid($tbnick);
			if($a[0]==0){
				echo 'false';
			}
			else{
				echo 'true';
			}
		}
	break;
	
	case 'get_msg':
	    $id = (int)$_GET['id'];
	    if($dduser['id']>0){
			$info=$duoduo->select('msg','uid,senduser,see','id="'.$id.'"');
			if($dduser['id']==$info['uid'] || $dduser['id']==$info['senduser']){
			    if($info['uid']==$dduser['id'] && $info['see']==0){
			        $data=array('see'=>1);
			        $duoduo->update('msg',$data,'id="'.$id.'"');
			    }
	            echo $msg='<p style=" line-height:20px;">'.$duoduo->select('msg','content','id="'.$id.'"',2).'</p>';
			}
			else{
			    $re=dd_json_encode(array('s'=>0,'id'=>10));
		        echo $re;
			}
	    }
		else{
		    $re=dd_json_encode(array('s'=>0,'id'=>10));
		    echo $re;
		}
	break;
	
	case 'userinfo':
	    if($dduser['id']>0){
			if($msgnum==0){ 
	            $msgsrc="<img src=\"template/".MOBAN."/inc/images/msg1.gif\" border=\"0\" alt=\"短消息\" />";
            }else{
	            $msgsrc="<img src=\"template/".MOBAN."/inc/images/msg0.gif\" border=\"0\" alt=\"您有新的短消息\" /> (".$msgnum.")";
            }
			$userinfo=array('name'=>$dduser['name'],'id'=>$dduser['id'],'money'=>$dduser['money'],'jifenbao'=>$dduser['jifenbao'],'jifen'=>$dduser['jifen'],'level'=>$dduser['level'],'msgsrc'=>$msgsrc,'avatar'=>a($dduser['id']));
			$re=array('s'=>1,'user'=>$userinfo);
		    echo dd_json_encode($re);
		}
		else{
		    $re=array('s'=>0);
		    echo dd_json_encode($re);
		}
	break;
	
	case 'mall_comment':
	    if($dduser['id']==''){
			$re=dd_json_encode(array('s'=>0,'id'=>10));
		    echo $re;continue;
		}
		$comment=reg_content($_GET['comment']);
		$mall_id=(int)$_GET['mall_id'];
		$fen=(int)$_GET['fen']?$_GET['fen']:5;
		if($comment==''){
			$re=dd_json_encode(array('s'=>0,'id'=>27));
		    echo $re;continue;
		}
		if($mall_id==0){
		    $re=dd_json_encode(array('s'=>0,'id'=>11));
		    echo $re;continue;
	    }
		$comment_num=$duoduo->count('mall_comment',"uid=".$dduser['id']." and mall_id='".$mall_id."'"); //评论次数
	    if($comment_num>=3){
	        $re=dd_json_encode(array('s'=>0,'id'=>73));
		    echo $re;continue;
	    }
		$fen=$fen==0?5:$fen;
		$field_arr=array('mall_id'=>$mall_id,'uid'=>$dduser['id'],'fen'=>$fen,'content'=>$comment,'addtime'=>TIME);
		$duoduo->insert('mall_comment',$field_arr);
		$ddusername=$duoduo->select('user','ddusername','id="'.$dduser['id'].'"');
		$re=dd_json_encode(array('s'=>1,'r'=>array('avatar'=>a($dduser['id']),'ddusername'=>utf_substr($ddusername,2).'***','content'=>$comment,'addtime'=>SJ)));
		echo $re;
	break;
	
	case 'getTaoItem':
	    $url=$_GET['url'];
		$admin=$_GET['admin'];
		$is_mobile=$_GET['is_mobile'];
		if(preg_match('/(taobao\.com|tmall\.com)/',$url)!=1){
		    $re=array('s'=>0,'id'=>49);
			echo dd_json_encode($re);continue;
		}
		$tao_id_arr = include (DDROOT.'/data/tao_ids.php');
		$iid=get_tao_id($url,$tao_id_arr); //获取商品id
		if($iid==''){
		    $re=array('s'=>0,'id'=>22);
			echo dd_json_encode($re);continue;
		}
		if($admin==1){ //后台获取商品信息
		    dd_session_start();
			if($_SESSION['ddadmin']['name']==''){
			    echo dd_json_encode($re);continue;
			}
			$dduser['level']=9999; 
		}
		elseif($dduser['id']<=0){  //验证是否登录
		    $re=array('s'=>0,'id'=>10);
			echo dd_json_encode($re);continue;
		}
		if($webset['share_limit_level']>$dduser['level']){ //验证分享所需等级
		    $re=array('s'=>0,'id'=>21);
			echo dd_json_encode($re);continue;
		}
		
		$a=$ddTaoapi->taobao_tbk_tdj_get($iid,1,1);
		$goods['discount_price']=$a['ds_discount_price'];
		$goods['rate']=$a['ds_discount_rate'];
		$goods['pic_url']=$a['ds_img']['src'];
		$goods['iid']=$a['ds_nid'];
		$goods['diqu']=$a['ds_provcity'];
		$goods['price']=$a['ds_reserve_price'];
		$goods['sell']=$a['ds_sell'];
		$goods['title']=$a['ds_title'];
		$goods['user_id']=$a['ds_user_id'];
		$goods['taoke']=$a['ds_taoke'];
		$goods['click_url']=$a['ds_item_click'];
		$goods['baoyou']=$a['ds_postfee']>0?0:1;
		
		$a=$ddTaoapi->taobao_tbk_tdj_get($goods['user_id'],2,1);
		$goods['logo']=$a['ds_img']['src'];
		$goods['shop_title']=$a['ds_shopname'];
		$goods['keywords']=$a['ds_vidname'];
		$goods['dsr_mas']=$a['ds_dsr_mas'];
		$goods['dsr_sas']=$a['ds_dsr_sas'];
		$goods['dsr_cas']=$a['ds_dsr_cas'];
		$goods['nick']=$a['ds_nick'];
		if($a['ds_istmall']==1){
			$a['ds_rank']=21;
		}
		$goods['level']=$a['ds_rank'];
		$goods['tao_id']=$iid;
		
		if($goods['title']=='' || $goods['taoke']==0){
		    $re=array('s'=>0,'id'=>18);
			echo dd_json_encode($re);continue;
		}
		else{
			$allow_fanli=$ddTaoapi->taobao_taobaoke_rebate_authorize_get($iid);
			if($allow_fanli==0){
				$re=array('s'=>0,'id'=>18);
				echo dd_json_encode($re);continue;
			}
		}

		/*$goods=$ddTaoapi->taobao_tbk_items_detail_get($iid);
		if($goods['title']==''){
		    $re=array('s'=>0,'id'=>18);
			echo dd_json_encode($re);continue;
		}
		$nick=$goods['nick'];
		$shop=$ddTaoapi->taobao_tbk_shops_detail_get($nick);
		$goods['user_id']=$shop['user_id'];
		$goods['shop_title']=$shop['shop_title'];
		$goods['logo']=$shop['pic_url'];
		$goods['tao_id']=$iid;*/
		$re=array('s'=>1,'re'=>$goods);
		echo dd_json_encode($re);
	break;
	
	case 'save_share':
	    if($dduser['id']<=0){  //验证是否登录
		    $re=array('s'=>0,'id'=>10);
			echo dd_json_encode($re);continue;
		}
		
		$url=$_GET['url'];
		if(preg_match('/(taobao\.com|tmall\.com)/',$url)!=1){
		    $re=array('s'=>0,'id'=>49);
			echo dd_json_encode($re);continue;
		}
		
		$tao_id_arr = include (DDROOT.'/data/tao_ids.php');
		$iid=get_tao_id($url,$tao_id_arr); //获取商品id
		if($iid==''){
		    $re=array('s'=>0,'id'=>22);
			echo dd_json_encode($re);continue;
		}
		
		if($dduser['id']<=0){  //验证是否登录
		    $re=array('s'=>0,'id'=>10);
			echo dd_json_encode($re);continue;
		}
		
		$a=$ddTaoapi->taobao_tbk_tdj_get($iid,1,1);
		$goods['discount_price']=$a['ds_discount_price'];
		$goods['rate']=$a['ds_discount_rate'];
		$goods['pic_url']=$a['ds_img']['src'];
		$goods['iid']=$a['ds_nid'];
		$goods['diqu']=$a['ds_provcity'];
		$goods['price']=$a['ds_reserve_price'];
		$goods['sell']=$a['ds_sell'];
		$goods['title']=$a['ds_title'];
		$goods['user_id']=$a['ds_user_id'];
		$goods['taoke']=$a['ds_taoke'];
		$goods['click_url']=$a['ds_item_click'];
		$goods['baoyou']=$a['ds_postfee']>0?0:1;
		
		$a=$ddTaoapi->taobao_tbk_tdj_get($goods['user_id'],2,1);
		$goods['logo']=$a['ds_img']['src'];
		$goods['shop_title']=$a['ds_shopname'];
		$goods['keywords']=$a['ds_vidname'];
		$goods['dsr_mas']=$a['ds_dsr_mas'];
		$goods['dsr_sas']=$a['ds_dsr_sas'];
		$goods['dsr_cas']=$a['ds_dsr_cas'];
		$goods['nick']=$a['ds_nick'];
		if($a['ds_istmall']==1){
			$a['ds_rank']=21;
		}
		$goods['level']=$a['ds_rank'];
		$goods['tao_id']=$iid;
		
		if($goods['title']=='' || $goods['taoke']==0){
		    $re=array('s'=>0,'id'=>18);
			echo dd_json_encode($re);continue;
		}
		$userimg=$_GET['userimg'];
		if($userimg!=''){
			$b=explode(".",$userimg);
			$c=array_pop($b);
			if($c!='jpg'){
				$re=array('s'=>0,'id'=>202);
				echo dd_json_encode($re);
				exit();
			}
		}else{
			$userimg=$goods['pic_url'];
		}
		$title=$goods['title'];
		$tao_id=$goods['tao_id'];
		$image=$goods['pic_url'];
		$comment=$_GET['comment'];
		$trade_id=(float)$_GET['trade_id'];
		$cid=(int)$_GET['cid'];
		$nick=$goods['sell'];
		$shop_title=$goods['shop_title'];
		$user_id=$goods['user_id'];
		$logo=$goods['logo'];
		$price=$goods['discount_price'];

		if($trade_id==0){ //订单id为0表示分享
		    if($dduser['level']<$webset['baobei']['share_level']){
			    $re=array('s'=>0,'id'=>21);
			    echo dd_json_encode($re);continue;
		    }
			
			if($webset['baobei']['share_status']==0){
				$re=array('s'=>0,'id'=>72);
				echo dd_json_encode($re);continue;
			}
		}
		else{ //表示晒单，验证订单是否是自己的
		    $tao_trade=$duoduo->select('tradelist','id,fxje,num_iid,uid,commission','uid="'.$dduser['id'].'" and num_iid="'.$tao_id.'"');
			$tao_id=$tao_trade['num_iid'];
			$commission=$tao_trade['commission'];
			if($dduser['id']!=$tao_trade['uid']){
			    $re=array('s'=>0,'id'=>42);
			    echo dd_json_encode($re);continue;
			}
		}
		
		if($webset['baobei']['share_shenhe']==0 || $trade_id>0){
			$fabu_time=SJ;
		}
		else{
			$fabu_time=date("Y-m-d H:i:s",strtotime("+".$webset['baobei']['share_shenhe']." min"));
		}
		
		if($keywords!=''){
		    $keywords_arr = preg_split('/[\n\r\t\s]+/i', trim($keywords));
		    if(count($keywords_arr)>5){
	            $re=array('s'=>0,'id'=>28);
			    echo dd_json_encode($re);continue;
	        }
		}
		if(utf8_count($comment)>$webset['baobei']['word_num']){
		    $re=array('s'=>0,'id'=>26);
			echo dd_json_encode($re);continue;
		}
		
		$baobei=$duoduo->select('baobei','id,status','uid="'.$dduser['id'].'" and tao_id="'.$tao_id.'"');
		$baobei_id=$baobei['id'];
		if($baobei['id']>0 && $baobei['status']!='1'){
		    $re=array('s'=>0,'id'=>31);
			echo dd_json_encode($re);continue;
		}
		
		if($trade_id==0){ //分享积分
		    $jifen=(int)$webset['baobei']['share_jifen'];
			$jifenbao=(float)$webset['baobei']['share_jifenbao'];
			$shijian=5;
		}
		elseif($trade_id>0){  //晒单积分
		    $jifen=(int)$webset['baobei']['shai_jifen'];
			$jifenbao=(float)$webset['baobei']['shai_jifenbao'];
			$shijian=7;
		}

		$comment=reg_content($comment);
		if($comment==''){
		    $re=dd_json_encode(array('s'=>0,'id'=>2));
		    echo $re;continue;
		}
		$status=0;
		if($webset['baobei']['user_show']==1){
			$status=2;
		}
		$field_arr=array('uid'=>$dduser['id'],'tao_id'=>$tao_id,'trade_id'=>$trade_id,'commission'=>$commission,'userimg'=>$userimg,'status'=>$status,'img'=>$image,'title'=>$title,'nick'=>$nick,'price'=>$price,'shop_title'=>$shop_title,'user_id'=>$user_id,'logo'=>$logo,'jifen'=>$jifen,'jifenbao'=>$jifenbao,'cid'=>$cid,'keywords'=>$keywords,'content'=>$comment,'fabu_time'=>$fabu_time,'addtime'=>TIME);

		if($baobei_id>0){
			$id=$baobei_id;
			$duoduo->update('baobei',$field_arr,'id="'.$id.'"');
			
		}else{
			$id=$duoduo->insert('baobei',$field_arr);
		}
		
		if(($jifen>0 || $jifenbao>0) && $id>0 && $baobei_id==0 && $webset['baobei']['user_show']==0){
			$m_id=$duoduo->select('mingxi','id','source="'.$id.'" and shijian="7"');
			if(empty($m_id)){
				$user_update=array(array('f'=>'jifen','e'=>'+','v'=>$jifen),array('f'=>'jifenbao','e'=>'+','v'=>$jifenbao));
				$duoduo->update_user_mingxi($user_update,$dduser['id'],$shijian,$id);
			}
		}
		
		$re=array('s'=>1,'r'=>$id);
		echo dd_json_encode($re);
	break;
	
	case 'like':
	    if($dduser['id']<=0){  //验证是否登录
		    $re=array('s'=>0,'id'=>10);
			echo dd_json_encode($re);continue;
		}
		$baobei_id=intval($_GET['id']);
		$uid=$dduser['id'];
		$baobei_hart_id=$duoduo->select('baobei_hart','id','uid="'.$uid.'" and baobei_id="'.$baobei_id.'"');
		if($baobei_hart_id>0){
		    $re=array('s'=>0,'id'=>30);
			echo dd_json_encode($re);continue;
		}
		$duoduo->update('baobei',array('f'=>'hart','e'=>'+','v'=>1),'id='.$baobei_id);
		$duoduo->insert('baobei_hart',array('baobei_id'=>$baobei_id,'uid'=>$uid,'addtime'=>TIME));
		$baobei_user_id=$duoduo->select('baobei','uid','id="'.$baobei_id.'"');
		
		$user_update=array(array('f'=>'jifen','e'=>'+','v'=>(int)$webset['baobei']['hart_jifen']),array('f'=>'jifenbao','e'=>'+','v'=>(int)$webset['baobei']['hart_jifenbao']),array('f'=>'hart','e'=>'+','v'=>1));
		$duoduo->update_user_mingxi($user_update,$baobei_user_id,16,$baobei_id);
		
		$re=array('s'=>1);
		echo dd_json_encode($re);
	break;
	
	case 'save_share_comment':
	    $comment=$_GET['comment']?htmlspecialchars($_GET['comment']):'';
		$id=$_GET['id']?intval($_GET['id']):0;
	    if($dduser['id']<=0){  //验证是否登录
		    $re=array('s'=>0,'id'=>10);
			echo dd_json_encode($re);continue;
		}
		if($dduser['level']<$webset['baobei']['comment_level']){
			$re=array('s'=>0,'id'=>21);
			echo dd_json_encode($re);continue;
		}
		if($comment==''){
		    $re=array('s'=>0,'id'=>27);
			echo dd_json_encode($re);continue;
		}
		if($id==0){
		    $re=array('s'=>0,'id'=>32);
			echo dd_json_encode($re);continue;
		}
		if(str_utf8_mix_word_count($comment)>$webset['baobei']['comment_word_num']){
		    $re=array('s'=>0,'id'=>26);
			echo dd_json_encode($re);continue;
		}
		$comment_num=$duoduo->count('baobei_comment','uid="'.$dduser['id'].'" and baobei_id="'.$id.'"'); //评论次数
		if($comment_num>=3){
		    $re=array('s'=>0,'id'=>73);
			echo dd_json_encode($re);continue;
		}
		$comment=reg_content($comment);
		if($comment==''){
		    $re=dd_json_encode(array('s'=>0,'id'=>2));
		    echo $re;continue;
		}
		$data=array('baobei_id'=>$id,'uid'=>$dduser['id'],'comment'=>$comment,'addtime'=>TIME);
		$duoduo->insert('baobei_comment',$data);
		$re=array('s'=>1);
		echo dd_json_encode($re);
	break;
	
	case 'huan':
	    $s=1;
		$id=(int)$_GET['id'];
		$realname=htmlspecialchars($_GET['realname']);
		$address=htmlspecialchars($_GET['address']);
		$mode=(int)$_GET['mode'];
		$num=(int)$_GET['num'];
		if($dduser['alipay']!=''){
			$alipay=$dduser['alipay'];
		}else{
			$alipay=$_GET['alipay'];
		}
		if($dduser['mobile']!=''){
			$mobile=$dduser['mobile'];
		}else{
			$mobile=(float)$_GET['mobile'];
		}
		if($dduser['realname']!=''){
			$realname=$dduser['realname'];
		}else{
			$realname=htmlspecialchars($_GET['realname']);
		}
		if($dduser['email']!=''){
			$email=$dduser['email'];
		}else{
			$email=$_GET['email'];
		}
		if($dduser['qq']!=''){
			$qq=$dduser['qq'];
		}else{
			$qq=$_GET['qq'];
		}
		$content=htmlspecialchars($_GET['content']);
		
		if($mobile!=0 && reg_mobile($mobile)==0){
		    $re=dd_json_encode(array('s'=>0,'id'=>36));
		    echo $re;continue;
		}
		
		if($email!='' && reg_email($email)==0){
		    $re=dd_json_encode(array('s'=>0,'id'=>7));
		    echo $re;continue;
		}
		
		if($aliapy!='' && reg_aliapy($aliapy)==0){
		    $re=dd_json_encode(array('s'=>0,'id'=>35));
		    echo $re;continue;
		}
		
		if($qq!='' && reg_qq($qq)==0){
		    $re=dd_json_encode(array('s'=>0,'id'=>9));
		    echo $re;continue;
		}
		
		$user_data=array('alipay'=>$alipay,'mobile'=>$mobile,'realname'=>$realname,'qq'=>$qq);
		$duoduo->update('user',$user_data,'id='.$dduser['id']);
		
	    if($dduser['name']==''){  //未登录
		    $re=dd_json_encode(array('s'=>0,'id'=>10));
		    echo $re;continue;
		}
		if($id==0 || $mode==0){ //缺少必要参数
		    $re=dd_json_encode(array('s'=>0,'id'=>11));
		    echo $re;continue;
	    }
		if($dduser['dhstate']==1){  //正在处于兑换状态
		    $re=dd_json_encode(array('s'=>0,'id'=>16));
		    echo $re;continue;
		}
		$huan=$duoduo->select('huan_goods','id,title,num,jifenbao,jifen,auto,array,edate,`limit`','id="'.$id.'" and hide="0"');
		if($huan['num']<$num || $num<=0){ //数量不够
		    $re=dd_json_encode(array('s'=>0,'id'=>66));
		    echo $re;continue;
		}
		elseif($huan['title']==''){ //商品不存在
		    $re=dd_json_encode(array('s'=>0,'id'=>17));
		    echo $re;continue;
		}
		elseif($huan['num']<=0){  //商品已下架
		    $re=dd_json_encode(array('s'=>0,'id'=>18));
		    echo $re;continue;
		}
		elseif($huan['edate']<TIME && $huan['edate']>0){  //商品已到期
		    $re=dd_json_encode(array('s'=>0,'id'=>51));
		    echo $re;continue;
		}
		elseif($huan['sdate']>TIME){  //兑换未开始
		    $re=dd_json_encode(array('s'=>0,'id'=>51));
		    echo $re;continue;
		}
		$code_arr=unserialize($huan['array']);
		if($huan['auto']==1 && (empty($code_arr) || count($code_arr)<$num)){
			$re=dd_json_encode(array('s'=>0,'id'=>66));//数量不够
			echo $re;continue;
		}
			
		if($huan['limit']>0){
			if($huan['limit']<$num){  //兑换受限制
		    	$re=dd_json_encode(array('s'=>0,'id'=>52));
		    	echo $re;continue;
			}

			$sdatetime=strtotime(date('Y-m-d').' 00:00:00');
			$edatetime=strtotime(date('Y-m-d').' 23:59:59');
			$duihuan_num=$duoduo->count('duihuan','uid="'.$dduser['id'].'" and huan_goods_id="'.$id.'" and addtime>="'.$sdatetime.'" and addtime<="'.$edatetime.'"');
			if($duihuan_num>=$huan['limit']){
		    	$re=dd_json_encode(array('s'=>0,'id'=>52));  //兑换受限
		    	echo $re;continue;
			}
		}
		
		if($mode==1){  
		    if($huan['jifenbao']==0){
			    $re=dd_json_encode(array('s'=>0,'id'=>48));
		        echo $re;continue;
			}
		    if($dduser['live_jifenbao']<$huan['jifenbao']*$num){  //金额不足
			    $re=dd_json_encode(array('s'=>0,'id'=>19));
		        echo $re;continue;
			}
			else{
			    $data=array(array('f'=>'jifenbao','e'=>'-','v'=>$huan['jifenbao']*$num),array('f'=>'dhstate','e'=>'=','v'=>1));
				$spend=(float)($huan['jifenbao']*$num);
			}
		}
		elseif($mode==2){  
		    if($huan['jifen']==0){
			    $re=dd_json_encode(array('s'=>0,'id'=>48));
		        echo $re;continue;
			}
		    if($dduser['live_jifen']<$huan['jifen']*$num){  //积分不足
			    $re=dd_json_encode(array('s'=>0,'id'=>20));
		        echo $re;continue;
			}
			else{
			    $data=array(array('f'=>'jifen','e'=>'-','v'=>$huan['jifen']*$num),array('f'=>'dhstate','e'=>'=','v'=>1));
				$spend=(int)($huan['jifen']*$num);
			}
		}
		else{
		    continue;
		}

	    $info['uid']=$dduser['id'];
	    $info['ip']=get_client_ip();
	    $info['huan_goods_id']=$id;
		$info['spend']=$spend;
	    $info['realname']=$realname;
	    $info['address']=$address;
	    $info['email']=$email;
	    $info['mobile']=$mobile;
	    $info['qq']=$qq;
	    $info['content']=$content;
	    $info['addtime']=TIME;
		$info['num']=$num;
		$info['alipay']=$alipay;
		if($huan['auto']==1){
		    $info['shoptime']=TIME;
	        $info['status']=1;
			unset($data[1]);  //自动发货，不改变会员的兑换状态
		}
		else{
		    $info['shoptime']=0;
	        $info['status']=0;
		}
	    
	    $info['mode']=$mode;
	    $id=$duoduo->insert('duihuan', $info);
		
		if($id>0){
			
			$duoduo->update('user', $data, 'id="'.$dduser['id'].'"');
			
			$user=$duoduo->select('user','mobile,mobile_test','id="'.$dduser['id'].'"');
			$duihuan_data=array('goods_id'=>$huan['id'],'uid'=>$dduser['id'],'email'=>$info['email'],'mobile'=>$huan['mobile'],'jifenbao'=>$huan['jifenbao']*$num,'jifen'=>$huan['jifen']*num,'title'=>$huan['title'],'array'=>$huan['array'],'auto'=>$huan['auto'],'mode'=>$mode,'num'=>$num,'alipay'=>$alipay);
			
			$duihuan_data['mobile']=$mobile;
			$duihuan_data['dh_id']=$id;
			$s=$duoduo->duihuan($duihuan_data,0);
		}
		$re=dd_json_encode(array('s'=>$s,'id'=>0));
		echo $re;
	break;
	
	case 'sign':
		$re=$duoduo->sign();
		$re=dd_json_encode($re);
		echo $re;
	break;
	
	case 'get_size':
	    echo round((directory_size($_GET['dir']) / (1024*1024)), 2);
	break;
	
	case 'goods_comment':
	    if($webset['taoapi']['goods_comment']==0){return;}
	    $comment_url=$_GET['comment_url'];
		$s=dd_get($comment_url);
        $s=str_replace('TB.detailRate = ','',$s);
        $s=trim(iconv("gb2312","utf-8//IGNORE",$s));
        $arr=dd_json_decode($s,1);
		echo dd_json_encode($arr);
	break;
	
	case 'pinyin':
	    $title=$_POST['title'];
		if(!class_exists('pinyin')){include(DDROOT.'/comm/pinyin.class.php');}
		echo $pinyin=fs('pinyin')->re($title);
	break;
	
	case 'malls':
	    $num=(int)$_GET['num'];
		$paipai=0;
	    if(isset($_GET['cid'])){
		    $cid=(int)$_GET['cid'];
			if($cid>0){
				$where='cid="'.$cid.'"';
			}
			else{
				if($ajax==0 && $webset['paipai']['open']==1){
					$paipai=1;
					$num--;
					$paipai_arr=array(array('view'=>u('paipai','index'),'view_jump'=>u('paipai','index'),'title'=>'拍拍网','fan'=>'30%','img'=>'images/paipai.jpg','des'=>'京东旗下大型、安全网上交易平台，提供各类服饰、美容、家居、数码、母婴、珠宝'));
				}
				$where='1';
			}
		}
		elseif(isset($_GET['title'])){
			$title=$_GET['title'];
		    if(preg_match("/^[0-9a-zA-Z]*$/",$title)){
				$where='pinyin like "'.$title.'%"';
			}
			else{
				$where='title like "%'.$title.'%"';
			}
		}
		
		include(DDROOT.'/comm/mall.class.php');
		$mall_class=new mall($duoduo);
		$malls=$mall_class->select($where.' and del=0 and edate>"'.strtotime(date('Ymd')).'" order by sort=0 asc,sort asc,id desc limit '.$num);
		foreach($malls as $k=>$row){
			$malls[$k]['des']=utf_substr($row['des'],46);
		}
		if($paipai==1){
			$malls=array_merge($paipai_arr,$malls);
		}
		
		echo dd_json_encode($malls);
	break;
	
	case 'tao_cuxiao':
		if(isset($_GET['iid'])){
			$iid=(float)$_GET['iid'];
			echo $ddTaoapi->taobao_ump_promotion_get($iid,'json');
		}
	    elseif(isset($_GET['iids'])){
			$iids=$_GET['iids'];
			$iid_arr=explode(',',$iids);
			$data=array();
			foreach($iid_arr as $iid){
				$iid=(float)$iid;
				if($iid>0){
					$a=$ddTaoapi->taobao_ump_promotion_get($iid,'array');
					if($a['price']>0){
						$data[]=$a;
					}
				}
			}

			echo dd_json_encode($data);
		}
	break;
	
	case 'chanet':
	    dd_session_start();
		if($_SESSION['ddadmin']['name']==''){
			$re=array('err'=>1,'msg'=>'未登录');
			echo dd_json_encode($re);continue;
		}
		$do=$_GET['do'];
        if($do=='get_key'){
            $url=CHANET_GET_KEY_URL."?".$_SERVER['QUERY_STRING'];
	        echo dd_get($url);
		}
	    elseif($do=='get_info'){
		    $url=$_POST['url'];
	        $url=DUODUO_URL.'/getchanet.php?act=chanetid&url='.urlencode($url);
	        echo dd_get($url);
		}
	break;
	
	case 'weiyi':
	    dd_session_start();
		if($_SESSION['ddadmin']['name']==''){
			$re=array('err'=>1,'msg'=>'未登录');
			echo dd_json_encode($re);continue;
		}
		$do=$_GET['do'];
        if($do=='get_info'){
		    $url=$_POST['url'];
	        $url=DUODUO_URL.'/getweiyi.php?act=weiyi&url='.urlencode($url);
	        echo dd_get($url);
		}
	break;
	
	case 'send_mail':
		$email=trim($_GET['email']);
		$title=trim($_GET['title']);
		$content=trim($_GET['content']);
		$content=del_magic_quotes_gpc($content);
		echo mail_send($email, $title, $content);
	break;
	
	case 'get_59miao_mall':
		$sid=(int)$_POST['sid'];
		include(DDROOT.'/comm/59miao.config.php');
		$re=$dd59miao->shops_get(array('sids'=>$sid));
		echo dd_json_encode($re);
	break;
	
	case 'huanqian':
		$money=(float)$_GET['money'];
		$dduser['id']=(int)$dduser['id'];
		if($webset['taoapi']['m2j']==0){
			$re=array('s'=>0,'id'=>999);
		}
		else{
			if($dduser['id']==0){
				$re=array('s'=>0,'id'=>10);
			}
			if($money<=0 || $money>$dduser['live_money']){
				$re=array('s'=>0,'id'=>19);
			}
			else{
				$jifenbao=jfb_data_type($money*TBMONEYBL);
				$jifenbao=data_type($jifenbao/(1+JFB_FEE),TBMONEYTYPE);

				$data=array(array('f'=>'money','e'=>'-','v'=>$money),array('f'=>'jifenbao','e'=>'+','v'=>$jifenbao));
				$duoduo->update_user_mingxi($data,$dduser['id'],22);
				$re=array('s'=>1);
			}
		}
		echo dd_json_encode($re);
	break;
	
	case 'cron':
		$duoduo->cron();
	break;
	
	case 'callback_search':
		$q=$_GET['q'];
		$table_name=get_mall_table_name();
		$mid_arr = $duoduo->select_all($table_name,'title,fan,id,img','title like "%'.$q.'%" and is_search=0 and del=0 and edate>"'.strtotime(date('Ymd')).'"');
		if($q==''){
			$mid_arr = array();
		}
		echo dd_json_encode($mid_arr);
	break;
	
	case 'delseelog':
		$index=$_GET['index'];
		del_browsing_history($index);
	break;
	
	case 'get_domain':
		$url=$_GET['url'];
		echo get_domain($url);
	break;
	
	case 'buy_log':
		$iid=(float)$_GET['iid'];
		if($dduser['id']>0 && $webset['taoapi']['auto_fanli']==1 && $iid>0){
			$buy_log_data['iid']=$iid;
			$buy_log_data['uid']=$dduser['id'];
			$buy_log_data['day']=date('Y-m-d H:i:s');
			$buy_log_data['fxje']=0;
			
			//10分钟内重复的数据不让提交
			$buy_log_id=(int)$duoduo->select('buy_log','id','uid="'.$dduser['id'].'" and iid="'.$buy_log_data['iid'].'" and day>"'.date("Y-m-d H:i:s",strtotime("-10 min")).'"');
			
			if($buy_log_id==0){
				$duoduo->insert('buy_log',$buy_log_data);
			}
			$re=array('s'=>1);
		}
		else{
			$re=array('s'=>0);
		}
		echo dd_json_encode($re);
	break;
	case 'goods_type':
	$bankuai=$duoduo->select('bankuai','id,web_cid,code,fenlei,yugao,yugao_time,huodong_time',"code='".$_GET['code']."' and status=1");
	$yugao_time=date('Y-m-d '.$bankuai['yugao_time'].":00");
	if(strtotime($yugao_time)>TIME){
		$yugao_close=true;
	}
	if($bankuai['fenlei']==1){
		$web_cid=unserialize($bankuai['web_cid']);
		if($web_cid){
			$where="id in(".implode(',',$web_cid).")";
		}
		$goods_type=$duoduo->select_all("type","id,title",$where."  order by sort=0 asc,sort asc,id desc");
		$html='<div class="jy_nav" id="'.$bankuai['code'].'_nav">';
		if($goods_type){
			$html.='<div class="up_fenlei"><a class="cur c_border" href="'.u('goods','index',array('code'=>$bankuai['code'])).'">全部</a>';
			foreach($goods_type as $vo){
				$html.='<a target="_blank" href="'.u('goods','index',array('code'=>$bankuai['code'],'cid'=>$vo['id'])).'">'.$vo['title'].'</a>';
			}
			$html.="</div>";
		}
		if($bankuai['huodong_time']&&date('H')<$bankuai['huodong_time']){
			$html.='<div class="upnew"><i></i>每天<span>'.$bankuai['huodong_time'].'</span>点上新     距上新还有<span>'.($bankuai['huodong_time']-date('H')).'</span>小时</div>';
		}elseif($bankuai['huodong_time']){
			$bankuai['huodong_etime']=strtotime(date('Y-m-d '.$bankuai['huodong_time'].":00:00",TIME))+24*3600;
			$html.='<div class="upnew"><i></i><div style="float:left;">本场剩余</div><div class="count_down"><span class="count_down_h">0</span>时<span class="count_down_m">0</span>分<span class="count_down_s">0</span>秒<input type="hidden" class="stime" value="'.TIME.'"><input type="hidden" class="etime" value="'.$bankuai['huodong_etime'].'"></div></div>';
		}
		if($bankuai['yugao']==1){
			$html.='<div style="float:right; width:85px; margin-right:10px;"><a class="cur c_border" ';
			if($yugao_close){
          	  	$html.='onClick="alert(\'对不起，亲！'.$bankuai['yugao_time'].'后公布预告商品。\')"';
			}else{
				$html.='href="'.u('goods','index',array('code'=>$bankuai['code'],'do'=>'yugao')).'"';
			}
			$html.='>明日精选</a></div>';
		}
		echo $html."</div>";
	}else{
		echo $html.'<div id="'.$bankuai['code'].'_nav"><div>';
	}
	break;
	case 'get_comments':
		$id=$_GET['id']?intval($_GET['id']):0;
		$page=$_GET['page']?intval($_GET['page']):1;
		$page1 = ($page-1)*10;
		$comment_total=$duoduo->count('baobei_comment','baobei_id="'.$id.'"');
		$comment_arr=$duoduo->select_all('baobei_comment as a,user as b','a.*,b.ddusername','a.baobei_id="'.$id.'" and a.uid=b.id order by id desc limit '.$page1.', 10');
		foreach($comment_arr as $k=>$row){
			$comment_arr[$k]['url']=u('baobei','view',array('id'=>$row['id']));
			$comment_arr[$k]['user_url']=u('baobei','user',array('uid'=>$row['uid']));
			$comment_arr[$k]['user_img']=a($row['uid'],'small');
			$comment_arr[$k]['_addtime']=date('m月d日 H:i',$row['addtime']);
			$comment_arr[$k]['_comment']=str_replace($face,$face_img,$row['comment']);
			$comment_arr[$k]['ddusername']=utf_substr($row['ddusername'],2).'***';
		}
		if($comment_total/10>$page){
			echo dd_json_encode(array('s'=>1,'r'=>$comment_arr,'next'=>1));
		}else{
			echo dd_json_encode(array('s'=>1,'r'=>$comment_arr,'next'=>0));
		}
	break;
	case 'get_goods_comments':
		include(DDROOT.'/comm/goods.class.php');
		$goods_class=new goods($duoduo);
		$id=$_GET['id']?intval($_GET['id']):0;
		$page=$_GET['page']?intval($_GET['page']):1;
		$page1 = ($page-1)*10;
		$comment_arr=$goods_class->comment_list($id,'',$page);
		$comment_total = $duoduo->count('goods_comment','data_id='.$id);
		foreach($comment_arr as $k=>$row){
			$comment_arr[$k]['src']=a($row['uid'],'small');
			$comment_arr[$k]['ddusername']=utf_substr($row['ddusername'],2).'***';
		}
		if($comment_total/10>$page){
			echo dd_json_encode(array('s'=>1,'r'=>$comment_arr,'next'=>1));
		}else{
			echo dd_json_encode(array('s'=>1,'r'=>$comment_arr,'next'=>0));
		}
	break;
	case 'get_mall_comments':
		$id=$_GET['id']?intval($_GET['id']):0;
		$page=$_GET['page']?intval($_GET['page']):1;
		
		$page1 = ($page-1)*10+3;
		
		$comment_total=$duoduo->count('mall_comment',"`mall_id` = '$id'");
	    $comment_arr=$duoduo->select_all('mall_comment as a,user as b','a.*,b.ddusername,b.id as user_id',"a.`mall_id` = '$id' and a.uid=b.id order by a.id desc limit $page1,10");
		foreach($comment_arr as $k=>$row){
			$comment_arr[$k]['src']=a($row['user_id']);
			$comment_arr[$k]['ddusername']=utf_substr($row['ddusername'],2).'***';
			$comment_arr[$k]['addtime']=date('Y-m-d H:i:s',$row['addtime']);	
		}
		if(($comment_total-3)/10>$page){
			echo dd_json_encode(array('s'=>1,'r'=>$comment_arr,'next'=>1));
		}else{
			echo dd_json_encode(array('s'=>1,'r'=>$comment_arr,'next'=>0));
		}
	break;
	case 'shoucang':
		$id=$_GET['id']?$_GET['id']:0;
		if($dduser['id']==0){
			echo dd_json_encode(array('s'=>0,'r'=>'您还没有登录！'));
		}
		$cun = $duoduo->select('record_goods','*','uid="'.$dduser['id'].'" and (goods_id="'.$id.'" or data_id="'.$id.'") and type=2');
		if(empty($cun)){
			$goods = $duoduo->select('goods','*','id='.$id);
			if(empty($goods)){
				include(DDROOT.'/comm/goods.class.php');
				$goods_class=new goods($duoduo);
				$goods=$goods_class->good_api($id);
			}
			$copy_goods = array('type'=>2,'goods_id'=>$goods['id'],'data_id'=>$goods['data_id'],'uid'=>$dduser['id'],'laiyuan'=>$goods['laiyuan'],'laiyuan_type'=>$goods['laiyuan_type'],'cid'=>$goods['cid'],'code'=>$goods['code'],'title'=>$goods['title'],'img'=>$goods['img']
			,'discount_price'=>$goods['discount_price'],'price'=>$goods['price'],'shouji_price'=>$goods['shouji_price'],'starttime'=>$goods['starttime'],'endtime'=>$goods['endtime'],'fanli_bl'=>$goods['fanli_bl'],'fanli_ico'=>$goods['fanli_ico']
			,'price_man'=>$goods['price_man'],'price_jian'=>$goods['price_jian'],'goods_attribute'=>$goods['goods_attribute'],'sell'=>$goods['sell']);
			$duoduo->insert('record_goods',$copy_goods);
			echo dd_json_encode(array('s'=>1,'r'=>'收藏成功！'));
		}else{
			$duoduo->delete('record_goods','id='.$cun['id']);
			echo dd_json_encode(array('s'=>1,'r'=>'取消收藏成功！','quxiao'=>1));
		}
	break;
}
$duoduo->close();
unset($duoduo);
unset($ddTaoapi);
unset($webset);
exit;
?>