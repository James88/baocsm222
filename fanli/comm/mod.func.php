<?php
function get_tao_id($url, $tao_id_arr=array()) {
	if(preg_match('#^(http|https)://(item\.taobao\.com)|(detail\.tmall\.com)|(h5\.m\.taobao\.com)|(detail\.m\.tmall\.com)|(detail\.tmall\.hk)|(detail\.m\.tmall\.hk)#',$url)){
		if(empty($tao_id_arr)){
			$tao_id_arr=include (DDROOT.'/data/tao_ids.php');
		}
		$ids=implode('|',$tao_id_arr);
		preg_match('/[&|?]('.$ids.')=(\d+)/',$url,$b);
		if($b[2]==''){
			preg_match('#/i(\d+)\.htm#',$url,$b);
			return $b[1];
		}
		else{
			return $b[2];
		}
	}
}

function in_tao_cat($cid,$tao_cat=array()){
	if(empty($tao_cat)){
		$tao_cat=include(DDROOT.'/data/tao_cat.php');
	}
    foreach($tao_cat as $k=>$v){
	    if(in_array($cid,$v)){
		    return $k;
	    }
    }
	return 999;
}

function dd_set_cache($name,$arr,$type='json'){
	switch($type){
		case 'json':
			$data=PHP_EXIT.json_encode($arr);
			dd_file_put(DDROOT .'/data/json/' . $name . '.php', $data);
		break;
		case 'array':
			$data = "<?php\n return " . var_export($arr, true) . ";\n?>";
			dd_file_put(DDROOT .'/data/array/' . $name . '.php', $data);
		break;
	}
}

function dd_get_cache($name,$type='json'){
	switch($type){
		case 'json':
			$data=array();
			if(is_file(DDROOT .'/data/json/' . $name . '.php')){
				$data=file_get_contents(DDROOT .'/data/json/' . $name . '.php');
				$data=preg_replace('/^'.PHP_EXIT_PREG.'/','',$data);
				$data=json_decode($data,1);
				if(empty($data)){$data=array();}
			}
		break;
		case 'array':
			$data=array();
			if(is_file(DDROOT .'/data/array/' . $name . '.php')){
				$data = include(DDROOT .'/data/array/' . $name . '.php');
				if(empty($data)){$data=array();}
			}
		break;
	}
	return $data;
}

function def($tag,$data=array(),$parame=array()){
	$default_data=dd_get_cache('tao_goods','array');
	switch($tag){
		case 'dingdaning':
			$default_data=$default_data[$tag];
			if(!empty($default_data)){
				foreach($default_data as $row){
					$data[$row['wz']]['num_iid']=$row['num_iid'];
					$data[$row['wz']]['item_title']=$row['title'];
					$data[$row['wz']]['fxje']=$row['fxje']*TBMONEYBL;
					$data[$row['wz']]['img']=$row['pic_url'];
					$data[$row['wz']]['name']='******';
					$data[$row['wz']]['gourl']=u('tao','view',array('iid'=>$row['num_iid']));
				}
			}
		break;
		
		case 'tao_hot_goods':
			$default_data=$default_data[$tag];
			if(is_array($default_data) && !empty($default_data)){
				foreach($default_data as $row){
					$data[$row['wz']]['num_iid']=$row['num_iid'];
					$data[$row['wz']]['title']=$row['title'];
					$data[$row['wz']]['pic_url']=$row['pic_url'];
					$data[$row['wz']]['price']=$row['price'];
					$data[$row['wz']]['fxje']=fenduan($row['commission'],$parame['fxbl'],$parame['user_level'],TBMONEYBL);
					$data[$row['wz']]['gourl']=u('tao','view',array('iid'=>$row['num_iid']));
				}
			}
		break;
		
		case 'tao_zhe_goods':
			$default_data=$default_data[$tag];
			if(is_array($default_data) && !empty($default_data)){
				foreach($default_data as $row){
					$data[$row['wz']]['num_iid']=$row['num_iid'];
					$data[$row['wz']]['title']=$row['title'];
					$data[$row['wz']]['pic_url']=$row['pic_url'];
					$data[$row['wz']]['price']=$row['price'];
					$data[$row['wz']]['coupon_price']=$row['coupon_price'];
					$data[$row['wz']]['coupon_end_time']=$row['coupon_end_time'];
					$data[$row['wz']]['coupon_fxje']=fenduan($row['coupon_commission'],$parame['fxbl'],$parame['user_level']);
					$data[$row['wz']]['gourl']=u('tao','view',array('iid'=>$row['num_iid']));
				}
			}
		break;
	}
	return $data;
}

function jump($url = '',$word='') {
	if(defined('AJAX') && AJAX==1) {
		if($word!=''){
		    $arr=array('s'=>0,'r'=>$word,'id'=>$word);
		}
		else{
		    $arr=array('s'=>1);
		}
		echo dd_json_encode($arr);
		dd_exit();
    }
    else{
	    if($word!=''){
		    if(is_numeric($word)){
				global $errorData;
			    $alert="alert('" . $errorData[$word] . "');";
			}
			else{
			    $alert="alert('" . $word . "');";
			}
		}
	    else {
			$alert='';
		}		
        if($url==-1){
        	$url=$_SERVER["HTTP_REFERER"];
        }
		if($url==-2 && $_GET['from_url']!=''){
			$url=$_GET['from_url'];
		}
	    if (is_numeric($url) && $url!=-1) {
		    echo script($alert.'history.go('.$url.');');
	    } else {
            echo script($alert.'window.location.href="' . $url . '";');
			//echo '<meta http-equiv="Refresh" content="0; url='.$url.'" />';
	    }
	    dd_exit();
	}
}

function wap_jump($url,$word){
	echo '<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport"><div style="position: fixed;	top:0;	left:0;	width:100%;	height:100%;background:rgba(0, 0, 0, 0.7);z-index:20000;" id="mcover" onClick="document.getElementById(\'mcover\').style.display=\'\';"><div style="z-index:20001; margin:auto; text-align:center;" id="rongqi"><span style="background:#666; font-size:1em; padding:0.5em 1em; color:#FFF;border-radius:0.5em;">'.$word.'</span></div></div>';
	$fun_alert="window.alert = function() {var time=1500;var h=document.documentElement.clientHeight;document.getElementById('rongqi').style.marginTop=(h*0.4)+'px'; setTimeout(function(){window.location.href='".$url."';},time);};";

	if($url==-1){
        $url=$_SERVER["HTTP_REFERER"];
    }
	$alert=$fun_alert."alert('" . $word . "','".$url."');";
	echo script($alert);
}

function u($mod,$act='index',$arr=array()){
	if($mod=='wap'){
		return wap_l();
	}
	
	if($arr==''){$arr=array();}
	$wjt=0;
	if(isset($arr['rela'])){
		$rela=1;
		unset($arr['rela']);
	}
	else{
		$rela=0;
	}
	$_arr=$arr;

	if(defined('INDEX')==1){
		if($act=='index' && $mod=='index'){
			return SITEURL;
		}
		
	    global $wjt_mod_act_arr;  //伪静态数组
		if(!isset($wjt_mod_act_arr)){
			$wjt_mod_act_arr=dd_get_cache('wjt');
		}
	    if(WJT==1 && array_key_exists($mod,$wjt_mod_act_arr) && array_key_exists($act,$wjt_mod_act_arr[$mod]) && $wjt_mod_act_arr[$mod][$act]==1){
		    $wjt=1;
	    }
		unset($wjt_mod_act_arr);
		
		if($mod=='tao' && ($act=='list' || $act=='view') && URLENCRYPT!=''){
	        if(isset($arr['cid']) && $arr['cid']>0){
		        $arr['cid']=dd_encrypt($arr['cid'],URLENCRYPT);
		    }
		    elseif(isset($arr['iid']) && $arr['iid']>0){
		        $arr['iid']=dd_encrypt($arr['iid'],URLENCRYPT);
		    }
	    }
	}

	if($wjt==0){
		if($act==''){
	        $mod_act_url="index.php?mod=".$mod."&act=index";
	    }
	    elseif(empty($arr)){
	        $mod_act_url="index.php?mod=".$mod."&act=".$act;
	    }
	    else{
	        $mod_act_url="index.php?mod=".$mod."&act=".$act.arr2param($arr);
	    }
	}
	elseif($wjt==1){
		global $alias_mod_act_arr;  //链接别名数组
		if(!isset($alias_mod_act_arr)){
			$alias_mod_act_arr=dd_get_cache('alias');
		}
		$dir=$mod.'/'.$act;
		if(is_array($alias_mod_act_arr[$dir])){
		    $mod=$alias_mod_act_arr[$dir][0];
			$act=$alias_mod_act_arr[$dir][1];
		}
		unset($alias_mod_act_arr);
		if($act==''){
	        $mod_act_url=$mod."/index.html";
	    }
	    elseif(empty($arr)){
	        $mod_act_url=$mod.'/'.$act.'.html';
	    }
	    else{
			$mod_act_url='';
			$url='';
			foreach($arr as $k=>$v){
			    $url.=rawurlencode($v).'-';
			}
		    $mod_act_url=$mod.'/'.$act.'-'.$url;
		    $mod_act_url=str_del_last($mod_act_url).'.html';
	    }
	}
	
	if(defined('INDEX') && $mod=='index' && $act=='index'){
		$mod_act_url='';
	}
	
	global $define_domain_arr;  //伪静态数组
	if(!isset($define_domain_arr)){
		$define_domain_arr=dd_get_cache('domain');
	}
	
	if(defined('INDEX')){
		$url=SITEURL;
		$other_url=0;
		
		foreach($define_domain_arr as $key=>$row){
			if($row['close']==1){
				continue;
			}
			
			if($row['mod']==$mod && $row['code']!='' && $arr['code']!='' && $row['code']==$arr['code']){
				$url=HTTP.$key;
				$other_url=1;
			}
		}

		if($other_url==0){
			foreach($define_domain_arr as $key=>$row){
				if($row['close']==1){
					continue;
				}
				if($row['mod']==$mod && $row['code']=='' && $arr['code']==''){
					$url=HTTP.$key;
					$other_url=1;
				}
			}
		}
		
		if($other_url==1 && $wjt==0){
			if($act!='index'){
				$_arr=array('act'=>$act)+$_arr;
			}
			if($_arr['code']!=''){
				unset($_arr['code']);
			}
			$mod_act_url=arr2param($_arr);
			$mod_act_url=preg_replace('/^&/','',$mod_act_url);
			if(!empty($mod_act_url)){
				$mod_act_url='index.php?'.$mod_act_url;
			}
		}
	}

	if(defined('INDEX') && $rela==0){
		$mod_act_url=$url.'/'.$mod_act_url;
	}
	
	if($wjt==1 && preg_match('#/\w+/index\.html#',$mod_act_url) && strpos($mod_act_url,SITEURL)===false){
		$mod_act_url=preg_replace('#/\w+/index\.html#','',$mod_act_url);
	}
	
    return $mod_act_url;
}

function dd_session_start(){
	create_dir(DDROOT.'/data/temp/session/'.date('Ymd'));
	ini_set('session.save_handler', 'files');
    session_save_path(DDROOT.'/data/temp/session/'.date('Ymd')); 
	session_set_cookie_params(0, '/', '');
	session_start();
}

function sel_date($dir){
	if(!file_exists($dir)){
		return;
	}
    $dh = dir($dir);
    $j=0;
    while(($filename=$dh->read()) !== false){
	    if ($filename != "." && $filename != ".."){
			$dp=$dir.'/'.$filename;
			if(judge_empty_dir($dp)!=1){
			    $arr=explode('_',$filename);
	            $time=date('Y-m-d',strtotime($arr[1]));
	            $option_arr[$j]="<option value='$arr[1]'>$time</option>";
		        $j++;
			}
	    }
    }
    for($i=$j;$i>=0;$i--){
        $option.=$option_arr[$i];
    }
    $dh->close();
	return $option;
}

function mingxi_content($row,$mingxi_content){
	$mingxi_content=str_replace('{money}',$row['money'],$mingxi_content);
	$mingxi_content=str_replace('{jifenbao}',jfb_data_type($row['jifenbao']),$mingxi_content);
	$mingxi_content=str_replace('{jifen}',$row['jifen'],$mingxi_content);
    if(strpos($mingxi_content,'{source}')!==false){
	    $mingxi_content=str_replace('{source}',$row['source'],$mingxi_content);
	}
	return $mingxi_content;
}

function error_html($error_msg='缺少必要参数',$goto=0,$type=0){
	global $nav;
	global $duoduo;
	global $webset;
	global $dduser;
	global $no_words;
	global $mallapiopen;
	global $dd_tpl_data;
    include(TPLPATH.'/inc/error.tpl.php');
	dd_exit();
}

function spider_limit($spider) {
	foreach ($spider as $k=>$val) {
		if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), $k) !== false) {
			$rand_num = rand(1, 100);
			if ($rand_num <= $val) {
				dd_file_put(DDROOT . '/data/spider/' . $k . '.txt', date('Y-m-d H:i:s') . "\r\n", FILE_APPEND);
				error_html('hello spider!');
			}
		}
	}
}

function mod_name($mod,$act){
	if($mod=='index'){
	    $mod_name=$mod;
	}
	elseif($mod=='ajax' || $mod=='jump'){
	    $mod_name=$mod;
	}
    else{
	    $mod_name=$mod.'/'.$act;
	}
	return $mod_name;
}

function AD($tag){
	$arr=dd_get_cache('ad/'.$tag);
	$id=$arr['id'];
	$tag=$arr['tag'];
	$adtag=$tag!=''?$tag:$id;
	if(!empty($arr)){
		$style='style="';
		if($arr['edate']>TIME && ($arr['img']!='' || $arr['ad_content']!='')){
			if($arr['width']>0){
				$style.='width:'.$arr['width'].'px;';
			}
			if($arr['height']>0){
				$style.='height:'.$arr['height'].'px;';
			}
			if($arr['bgcolor']>0){
				$style.='bgcolor:'.$arr['bgcolor'].'px;';
			}
			$style.='"';
			if(isset($arr['ad_content']) && $arr['ad_content']!=''){
				$c=$arr['ad_content'];
			}
			else{
				$c="<script src='".SITEURL."/data/ad/".$adtag.".js'></script>";
			}
			return "<div ".$style." id='ad".$id."'>".$c."</div>";
		}
	}
	return;
}

function yzm($path=''){
	if($path==''){
		$path=CURURL.'/';
	}
    return '<img alt="验证码" src="'.$path.'comm/showpic.php" align="absmiddle" onClick="this.src=\''.$path.'comm/showpic.php?a=\'+Math.random()" title="点击更换" style="cursor:pointer;"/>';
}

function show_shop_cat($text){
	switch ($text){
		case "11": $str="电脑硬件/台式机/网络设备"; break;
		case "12": $str="MP3/MP4/iPod/录音笔"; break;
		case "13": $str="手机"; break;
		case "14": $str="女装/流行女装"; break;
		case "15": $str="彩妆/香水/护肤/美体"; break;
		case "16": $str="电玩/配件/游戏/攻略"; break;
		case "17": $str="数码相机/摄像机/图形冲印"; break;
		case "18": $str="运动/瑜伽/健身/球迷用品"; break;
		case "20": $str="古董/邮币/字画/收藏"; break;
		case "21": $str="办公设备/文具/耗材"; break;
		case "22": $str="汽车/配件/改装/摩托/自行车"; break;
		case "23": $str="珠宝/钻石/翡翠/黄金"; break;
		case "24": $str="居家日用/厨房餐饮/卫浴洗浴"; break;
		case "26": $str="装潢/灯具/五金/安防/卫浴"; break;
		case "27": $str="成人用品/避孕用品/情趣内衣"; break;
		case "29": $str="食品/茶叶/零食/特产"; break;
		case "30": $str="玩具/动漫/模型/卡通"; break;
		case "31": $str="箱包皮具/热销女包/男包"; break;
		case "32": $str="宠物/宠物食品及用品"; break;
		case "33": $str="音乐/影视/明星/乐器"; break;
		case "34": $str="书籍/杂志/报纸"; break;
		case "35": $str="网络游戏点卡"; break;
		case "36": $str="网络游戏装备/游戏币/帐号/代练"; break;
		case "37": $str="男装"; break;
		case "1020": $str="母婴用品/奶粉/孕妇装"; break;
		case "1040": $str="ZIPPO/瑞士军刀/饰品/眼镜"; break;
		case "1041": $str="移动联通充值中心/IP长途"; break;
		case "1042": $str="网店装修/物流快递/图片存储"; break;
		case "1043": $str="笔记本电脑"; break;
		case "1044": $str="品牌手表/流行手表"; break;
		case "1045": $str="户外/军品/旅游/机票"; break;
		case "1046": $str="家用电器/hifi音响/耳机"; break;
		case "1047": $str="鲜花速递/蛋糕配送/园艺花艺"; break;
		case "1048": $str="3C数码配件市场"; break;
		case "1049": $str="床上用品/靠垫/窗帘/布艺"; break;
		case "1050": $str="家具/家具定制/宜家代购"; break;
		case "1051": $str="保健品/滋补品"; break;
		case "1052": $str="网络服务/电脑软件"; break;
		case "1053": $str="演出/旅游/吃喝玩乐折扣券"; break;
		case "1054": $str="饰品/流行首饰/时尚饰品"; break;
		case "1055": $str="女士内衣/男士内衣/家居服"; break;
		case "1056": $str="女鞋"; break;
		case "1062": $str="童装/婴儿服/鞋帽"; break;
		case "1082": $str="流行男鞋/皮鞋"; break;
		case "1102": $str="腾讯QQ专区"; break;
		case "1103": $str="IP卡/网络电话/在线影音充值"; break;
		case "1104": $str="个人护理/保健/按摩器材"; break;
		case "1105": $str="闪存卡/U盘/移动存储"; break;
		case "1106": $str="运动鞋"; break;
		case "1122": $str="时尚家饰/工艺品/十字绣"; break;
		case "1153": $str="运动服"; break;
		case "1154": $str="服饰配件/皮带/帽子/围巾"; break;
		default: $str="全部店铺"; break; 
 	}
	return $str;
}

function reg_content($content,$type=0){ //type为1，替换；type为2，提示错误
	$pattern=DOMAIN_PREG;
	if($type==0){
		$type=REPLACE;
	}
    $shield_arr = dd_get_cache('no_words'); //屏蔽词语
	if($type==1){
		$content=strtr($content,$shield_arr);
		$content=preg_replace($pattern,'',$content);
	}
	else{
		foreach($shield_arr as $v){
			if(strpos($content,$v)!==false){
				return ''; //包含非法词汇
	    	}
		} 
		if(preg_match($pattern,$content)){
	    	return '';
		}
	}
	return htmlspecialchars($content);
}

function jfb_data_type($jifenbao){
	return data_type($jifenbao,TBMONEYTYPE);
}

function mobile_yzm($mobile,$yzm=''){
	$a=dd_crc32(DDKEY.$mobile);
	$a=substr($a,0,4);
	if($yzm==''){
		return $a;
	}
	else{
		if($yzm==$a){
			return 1;
		}
		else{
			return 0;
		}
	}
}

function show_mobile($mobile){
	return '<b style="font-size:18px; color:#000">'.substr($mobile,0,3).'*****'.substr($mobile,-3).'</b>';
}

function dd_xuliehua($obj) { 
   return base64_encode(gzcompress(json_encode($obj))); 
} 

//反序列化
function dd_unxuliehua($txt) {
	if($txt=='') return array();
   	return json_decode(gzuncompress(base64_decode($txt)),1); 
}

function add_menu($data){ //$data=array('parent_id'=>72,'node'=>'plug','mod'=>'plugin','act'=>'list','listorder'=>'0','sort'=>'0','title'=>'插件列表','hide'=>0,'sys'=>1);
	global $duoduo;
	
	if(!isset($data['parent_id'])){ //插件菜单快速添加
		$data['parent_id']=72;
		$data['node']='plug';
		$data['listorder']=0;
		$data['sort']=0;
		$data['hide']=1;
		$data['sys']=0;
	}
	
	if($data['act']=='' && $data['mod']==''){
		$data['listorder']=$data['listorder'] > 0?$data['listorder']:$data['sort']+10000;
		$menuid=$duoduo->select('menu','id','`node`="'.$data['node'].'" and `mod`="" and `act`=""');
		if($menuid>0){
			$_data=$data;
			$duoduo->update('menu',$_data,'id="'.$menuid.'"');
	   		return $menuid; //节点已存在;
		}
		$menuid=$duoduo->insert('menu',$data);
		$data=array('role_id'=>1,'menu_id'=>$menuid);
		$duoduo->insert('menu_access',$data);
		return $menuid;
	}
	else{
		$menuid=$duoduo->select('menu','id','`mod`="'.$data['mod'].'" and act="'.$data['act'].'"');
		if($menuid>0){
			$_data=$data;
			$duoduo->update('menu',$_data,'id="'.$menuid.'"');
			return $menuid;
		}
		$menuid=$duoduo->insert('menu',$data);
		$data=array('role_id'=>1,'menu_id'=>$menuid);
		$duoduo->insert('menu_access',$data);
	}
}

function del_menu($mod,$act){
	global $duoduo;
	$id=$duoduo->select('menu','id','`mod`="'.$mod.'" and `act`="'.$act.'"');  //删除导航
	$duoduo->delete('menu','id="'.$id.'" limit 1');
	$duoduo->delete('menu_access','menu_id="'.$id.'" limit 1');
}

function url_html_cache($name,$url,$trigger_time_arr=array()){
	$trigger_time_arr=array('09:30:00','12:30:00','15:30:00','18:30:00','21:30:00');
	$html_dir=DDROOT.'/data/html/'.$name.'/'.dd_crc32($url).'.html';
	$html_url=SITEURL.'/data/html/'.$name.'/'.dd_crc32($url).'.html';
	
	if(!file_exists($html_dir)){
		$html=dd_get($url);
		create_file($html_dir,$html);
	}
	else{
		$file_time=filemtime($html_dir);
		foreach($trigger_time_arr as $v){
			$trigger_time=strtotime(date('Ymd'.' '.$v));
			if(TIME>$trigger_time && $file_time<=$trigger_time){
				unlink($html_dir);
				$html=dd_get($url);
				create_file($html_dir,$html);
			}
		}
	}
	return $html_url;
}

function l($mod,$act,$arr=array()){
	$url=SITEURL.'/index.php?mod='.$mod.'&act='.$act;
	if(!empty($arr)){
		$url.=arr2param($arr);
	}
	return $url;
}

function wap_l($mod='index',$act='index',$arr=array()){
	$url=SITEURL.'/m/';
	$domain=dd_get_cache('domain');
	foreach($domain as $k=>$row){
		if($row['mod']=='wap' && $row['close']==0){
			$url='http://'.$k;
			break;
		}
	}
	if($mod=='index' && $act=='index'){
		$url=$url;
	}
	else{
		$url=$url.(substr($url,-1)=='/'?'':'/').'index.php?mod='.$mod.'&act='.$act;
	}
	
	if(!empty($arr)){
		$url.=arr2param($arr);
	}
	return $url;
}

function p($mod,$act,$arr=array()){
	$url='';
	if(WJT==1 && $act!='ajax'){
		
		global $alias_mod_act_arr;  //链接别名数组
		if(!isset($alias_mod_act_arr)){
			$alias_mod_act_arr=dd_get_cache('alias');
		}
		$dir=$mod.'/'.$act;
		if(is_array($alias_mod_act_arr[$dir])){
		    $mod=$alias_mod_act_arr[$dir][0];
			$act=$alias_mod_act_arr[$dir][1];
		}
		unset($alias_mod_act_arr);
		
		foreach($arr as $k=>$v){
			$url.=rawurlencode($v).'-';
		}
		$url='plugin/'.$mod.'-'.$act.'-'.$url;
		$url=SITEURL.'/'.str_del_last($url).'.html';
	}
	else{
		$url=SITEURL.'/plugin.php?mod='.$mod.'&act='.$act;
		if(!empty($arr)){
			$url.=arr2param($arr);
		}	
	}
	return $url;
}

function include_mod($mod,$duoduo,$new=1){ //new表示是否实例化
	include(DDROOT.'/mod/'.$mod.'/fun.class.php');
	$dd_mod_class_name='dd_'.$mod.'_class';
	$$dd_mod_class_name=new $dd_mod_class_name($duoduo);
	return $$dd_mod_class_name;
}

function radio_guanlian($radio_name,$s=0){
	$radio_name_guanlian=str_replace('[','',$radio_name);
	$radio_name_guanlian=str_replace(']','',$radio_name_guanlian);
	$radio_name_guanlian=$radio_name_guanlian.'_guanlian';
	if($s==1){echo '<script>';}
	?>
$('input[name="<?=$radio_name?>"]').click(function(){
	if($(this).val()==0){
    	$('.<?=$radio_name_guanlian?>').hide();

	}
	else{
		$('.<?=$radio_name_guanlian?>').show();
	}
});
if($('input[name="<?=$radio_name?>"]:checked').val()==0){
	$('.<?=$radio_name_guanlian?>').hide();
}
else{
	$('.<?=$radio_name_guanlian?>').show();
}
    <?php
	if($s==1){echo '</script>';}
}

function tdj_click($url,$data='',$type='goods'){
	if($type=='shop'){
		if($data!=''){
			$a='data-tmpl="140x190" data-style="1" data-type="1" biz-sellerid="'.$data.'"';
		}
		else{
			$a='';
		}
	}
	elseif($type=='goods'){
		$a='data-type="0" biz-itemid="'.$data.'" data-tmpl="350x100" data-tmplid="6" data-rd="1" data-style="1"';
	}
	if($url!=''){
		$a.=' a_jump_click="'.$url.'" onclick="return tao_perfect_click($(this));"';
	}
	return $a;
}

function tao_shop_url($sid){
	return 'http://shop'.$sid.'.taobao.com';
}

function tao_goods_url($iid){
	return 'http://item.taobao.com/item.htm?id='.$iid;
}

function click_jump($url){
	if($_GET['yun_jump']==1){
		$img_src=DD_U_URL.'/cpc/index.php?ddurl='.urlencode(SITEURL).'&num_iid='.$_GET['num_iid'].'&key='.deep_jm(DDYUNKEY,DDYUNKEY);
		?>
        <img style="width:1px; height:1px;filter:alpha(opacity=0);opacity:0" src="<?=$img_src?>" />
        <?php
	}
	?>
<a href="<?=$url?>" id="aaa">&nbsp;</a>
<script>
function doClick(id){
	var comment = document.getElementById(id);
	if (document.all) {
		comment.click();
	} else if (document.createEvent) {
		var ev = document.createEvent('MouseEvents');
		ev.initEvent('click', false, true);
		comment.dispatchEvent(ev);
	}
}
setTimeout(function(){doClick('aaa');},1000);
</script>
<?php dd_exit();}

function s_dd_json_encode($arr){
	$val=dd_json_encode($arr);
	$val=str_replace('"','”“',$val);
	return $val;
}

function s_dd_json_decode($val){
	$val=str_replace('”“','"',$val);
	$arr=dd_json_encode($val,1);
	return $arr;
}

function set_browsing_history($val){
	$str=$_COOKIE['seelog'];
	if($str==''){
		$arr=array();
	}
	else{
		$arr=dd_unxuliehua($str);
	}
	if($val['type']=='tao'){
		if(!empty($arr)){
			foreach($arr as $row){
				if($val['iid']==$row['iid'] || $val['pic']==''){
					return false;
				}
			}
		}
	}
	else{
		if(!empty($arr)){
			foreach($arr as $row){
				if($val['id'].$val['type']==$row['id'].$row['type'] || $val['pic']==''){
					return false;
				}
			}
		}
	}

	$a[]=$val;
	$arr=array_merge($a,$arr);
	$val=dd_xuliehua($arr);
	set_cookie('seelog',$val,86400,0);
}

function get_browsing_history(){
	$val=$_COOKIE['seelog'];
	$arr=dd_unxuliehua($val);
	if(empty($arr)) $arr=array();
	return $arr;
}

function del_browsing_history($index){
	if($index==-1){
		$arr=array();
		$val=dd_xuliehua($arr);
		set_cookie('seelog',$val,86400,0);
	}
	else{
		$val=$_COOKIE['seelog'];
		$arr=dd_unxuliehua($val);
		unset($arr[$index]);
		sort($arr);
		$val=dd_xuliehua($arr);
		set_cookie('seelog',$val,86400,0);
	}
}

function do_back_code($str){
	$code='';
	$fuid='';
	$shuju_id='';
	if(strpos($str,',')!==false){
		$a=explode(',',$str);
		$uid=(int)$a[0];
		$a=explode('|',$a[1]);
		list($code,$fuid,$shuju_id)=$a;
	}
	else{
		$uid=(int)$str;
	}
	return array($uid,$code,$fuid,$shuju_id); 
}

function tiqu_code_fuid($str){
	$code='';
	$fuid='';
	$len=strlen($str);
	for($i=0;$i<$len;$i++){
		if(!preg_match('/[a-zA-Z]/',$str[$i])){
			$fuid.=$str[$i];
		}
		else{
			$code.=$str[$i];
		}
	}
	return array($code,$fuid);
}

function get_mall_table_name(){
	if(DDMALL==1){
		$table_name='mall';
	}
	else{
		$table_name='mall';
	}
	return $table_name;
}

function mall_pinyin($duoduo){
	include(DDROOT.'/comm/mall.class.php');
	$mall_class=new mall($duoduo);
	return $malls=$mall_class->malls_pinyin();
}

function tiqu_mod_act($url,$type=0){
	$param=array();
	$arr=explode('?',$url);
	parse_str($arr[1],$param);
	if($type==0){
		return $param;
	}
	else{
		return $param['mod'].'_'.$param['act'];
	}
}

function reg_web_email($email){
	if(preg_match('/\w{20}@qq\.com/',$email)){
		return array('QQ','');
	}
	if(preg_match('/\d+@tb\.com/',$email)){
		return array('淘宝网','');
	}
	if(preg_match('/^\d{10}@sina\.com/',$email)){
		return array('新浪微博','');
	}
	if(preg_match('/.*@kaixin\.com/',$email)){
		return array('开心网','');
	}
	if(preg_match('/.*@qqweibo\.com/',$email)){
		return array('腾讯微博','');
	}
	return array('',$email);
}

function login_error($type,$ip=''){
	if($ip==''){
		$ip=$_SERVER['REMOTE_ADDR'];
	}
	$error_ip_dir=DDROOT.'/data/temp/session/'.date('Ymd').'/'.$ip.'.txt';
	if($type=='insert'){
		if(file_exists($error_ip_dir)){
			$error_login=(int)file_get_contents($error_ip_dir);
			$error_login++;
			
		}
		else{
			$error_login=1;
		}
		create_file($error_ip_dir,$error_login);
	}
	elseif($type=='delete'){
		unlink($error_ip_dir);
	}
	elseif($type=='check'){
		$error_login=(int)file_get_contents($error_ip_dir);
		if($error_login>=MAX_ERROR_LOGIN_NUM){
			return 1;
		}
		else{
			return 0;
		}
	}
}

function tb_img($img,$size){
	if(strpos($img,'alicdn.com')>0 || strpos($img,'tbcdn.cn')>0 || strpos($img,'taobaocdn.com')>0 ){
		if(is_numeric($size)){
			$size=$size.'x'.$size;
		}
		$img=preg_replace('#_((b)|(\d+x\d+))\.jpg#','',$img);
		return $img.'_'.$size.'.jpg';
	}
	return $img;
}

function iid_encode($iid){
	return ddStrCode($iid,DDKEY,'ENCODE');
}
function iid_decode($iid){
	if(is_numeric($iid)){
		return $iid;
	}
	return ddStrCode($iid,DDKEY,'DECODE');
}

function set_tao_click_uid($url,$uid){
	$param=array();
	$param2=array();
	$arr=explode('?',$url);
	parse_str($arr[1],$param);
	if(isset($param['f'])){
		$arr2=explode('?',$param['f']);
		parse_str($arr2[1],$param2);
		$param2['unid']=$uid;
		$url=$arr2[0].'?'.http_build_query($param2);
		$param['f']=$url;
		$url=$arr[0].'?'.http_build_query($param);
	}
	else{
		$param['unid']=$uid;
		$url=$arr[0].'?'.http_build_query($param);
	}
	return $url;
}

function check_jump_url($url, $uid = 0) {
	$param=array();
	$p='';
	$lm='';
	if(strpos($url,'s8.taobao.com')!==false){
	    $u='unid';
		$lm='alimama';
	}
	elseif(strpos($url,'click.taobao.com')!==false){
		$u='unid';
		$lm='alimama';
	}
	elseif(strpos($url,'temai.taobao.com')!==false){
		$u='unid';
		$lm='alimama';
	}
	elseif(strpos($url,'chanet.com')!==false){
	    $u='u';
		$lm='chanet';
	}
	elseif(strpos($url,'yiqifa.com')!==false){
	    $u='e';
		$lm='yiqifa';
		
		if(strpos($url,'&e=')===false){
			$url=str_replace('&t=','&e=1&t=',$url);
		}
	}
	elseif(strpos($url,'linktech.cn')!==false){
	    $u='u_id';
		$lm='linktech';
	}
    elseif(strpos($url,'weiyi.com')!==false){
	    $u='u';
		$lm='weiyi';
	}
	elseif(strpos($url,'duomai.com')!==false){
	    $u='euid';
		$lm='duomai';
	}
	elseif(strpos($url,'59miao.com')!==false){
	    $u='a';
		$lm='wujiumiao';
	}
	elseif(strpos($url,'paipai.com')!==false || strpos($url,'etg.qq.com')!==false){
	    $u='outinfo';
		$lm='paipai';
	}
	elseif(strpos($url,'taobao.com')!==false){
	    $u='u';
		$lm='alimama';
	}
	elseif(strpos($url,'yqhlm.com')!==false){
	    $u='euid';
		$lm='yqh';
	}
    if($lm!='' && strpos($url,'?')!==false){
    	$arr=explode('?',$url);
    	parse_str($arr[1],$param);
    	$param[$u]=$uid;
    	foreach($param as $k=>$v){
			if($k!=''){
            	if($lm=='yiqifa'){
               		$p.=$k.'='.urldecode($v).'&';
                }
                else{
               		$p.=$k.'='.urlencode($v).'&';
                }
			}
    	}
    	$url=str_del_last($arr[0].'?'.$p);
		if($lm=='yiqifa' && isset($arr[2])){
    		$url.='?'.$arr[2];
    	}
		
    }
    elseif($lm!=''){
    	$url=$url.'?'.$u.'='.$uid;
    }
	
	if(strpos($url,'duoduo123.com')!==false || strpos($url,'fanlicheng.cn')!==false){
	    $u='mid';
		$lm='duoduo';
		
		$arr=explode('?',$url);
    	parse_str($arr[1],$param);
		$param[$u]=urldecode($param[$u]);
		if(strpos($param[$u],'|')!==false){
			$s=explode('|',$param[$u]);
			$param[$u]=$s[0].'|'.$uid;
		}
		else{
			$param[$u]=$uid;
		}
		$p='';
		foreach($param as $k=>$v){
			if($k!=''){
               	$p.=$k.'='.rawurlencode($v).'&';
			}
    	}
		$url=str_del_last($arr[0].'?'.$p);
	}
	return $url;
}

//添加商品的开始和结束默认时间
function goods_time($bankuai){
	if($bankuai['time_type']==0){
		$row['starttime']=strtotime(date('Y-m-d H:00:00',TIME))+$bankuai['zj_stime']*3600;
	}elseif($bankuai['time_type']==1){
		if($bankuai['gd_stime']==0){
			$row['starttime']=strtotime(date('Y-m-d'.$bankuai['gd_minute'],strtotime(date('Y-m-d H:00:00',TIME))));
		}elseif($bankuai['gd_stime']==1){
			$row['starttime']=strtotime(date('Y-m-d'.$bankuai['gd_minute'],strtotime(date('Y-m-d H:00:00',TIME))+3600*24));
		}
	}
	if($bankuai['etime']>0){
		$row['endtime']=$row['starttime']+$bankuai['etime']*3600*24;
	}
	return $row;
}

function app_status(){
	$phone_app=dd_get_cache('mobileset');
	if(isset($phone_app['status']) && $phone_app['status']==1){
		return $phone_app;
	}
	else{
		return 0;
	}
}
?>