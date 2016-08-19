<?php
/**
 * ============================================================================
 * 版权所有 多多网络，并保留所有权利。
 * 网站地址: http://soft.duoduo123.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/

if(!defined('ADMIN')){
	exit('Access Denied');
}

$_GET['from_url']=str_replace('duoduo://','http://',$_GET['from_url']);

function seban($div='',$return=0){
	$arr=array('FFFFFF'=>'白色','f1f1f1'=>'灰色','060'=>'深绿','00F'=>'深蓝','F00'=>'鲜红','906'=>'深紫','C39'=>'浅紫','636'=>'褐色','63F'=>'浅蓝','39F'=>'青色','EC1A5B'=>'深红','none'=>'无颜色');
	if($return==1){
		return $arr;
	}
	$html='';
	foreach($arr as $k=>$v){
		if($k!='none'){$k='#'.$k;}
		$html.='<td><div style="background:'.$k.'" bg="'.$k.'" title="'.$v.'">&nbsp;</div></td>';
	}
	echo $html;?>
<style>
.yanse div{ width:15px; height:15px; cursor:pointer; border:#999 1px solid; padding:2px}
</style>
    <script>
$(function(){
	$('.yanse div').click(function(){
		var color=$(this).attr('bg');
		if(typeof color!='undefined' && color!=''){
			var $f=$(this).parents('.yanse');
			$f.find('input<?=$div?>').val(color);
		}
	});
})
</script>
    <?php 
}

function get_mod_act_info(){
	$f=DDROOT.'/mod/*';
	$mod_act=array('index'=>'首页');
	$a=glob($f);
	foreach($a as $v){
		if(file_exists($v.'/info.txt')){
			check_bom($v.'/info.txt',1);
			$b=file_get_contents($v.'/info.txt');
			$b=dd_json_decode($b,1);
			$title=$b['title'];
			$mod=str_replace(DDROOT.'/mod/','',$v);
			$mod_act[$mod]=$title;
		}
	}
	return $mod_act;
}

function ad_catch($arr){
	$id=$arr['id'];
	$tag=$arr['tag'];
	$adtag=$tag!=''?$tag:$id;
	if($arr['content']==''){
		$c='<a target="_blank" ';
		if($arr['link']!=''){
			$c.='href="'.$arr['link'].'"';
		}
		$c.='><img src="'.$arr['img'].'" ';
		if($arr['height']!=''){
			$c.='height="'.$arr['height'].'" ';
		}
		if($arr['width']!=''){
			$c.='width="'.$arr['width'].'" ';
		}
		$c.='alt="'.$arr['title'].'" /></a>';
	
		if($arr['type']==1){
			$js="document.write('".$c."')";
			create_file(DDROOT.'/data/ad/'.$adtag.'.js',$js);
		}
		elseif($arr['img']!=''){
			$ad_content=$c;
		}
    }
	else{
		if($arr['type']==1){
			$js_ad='';
			$a=explode("\r\n",$arr['content']);
			foreach($a as $v){
				$v=preg_replace('#\s+\/\/(.*)#','',$v);
				$v=str_replace('<!--','',$v);
				$js_ad=$js_ad.' '.$v;
			}
			$js='document.write("'.$js_ad.'")';
			create_file(DDROOT.'/data/ad/'.$adtag.'.js',$js);
		}
		else{
			$ad_content=$arr['content'];
			$ad_content=strtr($ad_content,array('\"'=>'"',"\'"=>"'"));
		}
	}	
	
	$data=$arr;
	if($arr['type']==2){
		$data['ad_content']=$ad_content;
	}
	else{
		$data['ad_content']='';
	}
	dd_set_cache('ad/'.$adtag,$data);
}

function taopid_cache(){
	global $duoduo;
	$taopid=$duoduo->select_all('taopid','*');
	foreach($taopid as $row){
		$b=parse_url($row['url']);
		$a[$b['host']]=$row;
	}
	dd_set_cache('taopid',$a);
}

function get_lm($need_zhlm){
	$top_nav_name=array(array('url'=>u('tradelist','set'),'name'=>'淘宝联盟设置'),array('url'=>u('taopid','list',array('curnav'=>'pid')),'name'=>'淘宝联盟pid','curnav'=>'pid'),array('url'=>u('mall','set'),'name'=>'综合联盟'));
	if($need_zhlm==1){
		$top_nav_name=array_merge($top_nav_name,array(array('url'=>u('mall','duomai_set'),'name'=>'多麦联盟'),array('url'=>u('mall','weiyi_set'),'name'=>'唯一联盟'),array('url'=>u('mall','wujiumiao_set'),'name'=>'59秒联盟'),array('url'=>u('mall','yiqifa_set'),'name'=>'亿起发联盟'),array('url'=>u('mall','linktech_set'),'name'=>'领科特联盟'),array('url'=>u('mall','chanet_set'),'name'=>'成果联盟'),array('url'=>u('mall','yqh_set'),'name'=>'一起惠'),array('url'=>u('bijia','set'),'name'=>'全网搜索')));
	}
	return $top_nav_name;
}

$shenhe_arr=array(1=>'待审',2=>'通过',3=>'失败');

$api_cid_arr=array('0'=>'全部')+dd_get_cache('tao_sys_cat','array');

$api_sort_arr=array('total_sales_des'=>'销量高到低','tk_rate_des'=>'佣金比率高到低','tk_total_sales_des'=>'推广量高到低','tk_total_commi_des'=>'支出佣金高到低');

$is_mall_arr=array('false'=>'不限制','true'=>'天猫');

$dd_mod_act_arr=get_mod_act_info();

$admin_set_tip=(int)$_SESSION['admin_set_tip'];

$a=glob(DDROOT.'/template/'.MOBAN.'/goods/*');
foreach($a as $k=>$v){
	if(is_dir($v)){
		$v=str_replace(DDROOT.'/template/'.MOBAN.'/goods/','',$v);
		if($v!='inc'){
			$bankuai_tpl_arr[$v]=$v;
		}
	}
}

if(!file_exists(DDROOT.'/update.php') && empty($_POST) && MOD!='login' && MOD!='index' && ACT!='top' && ACT!='left' && MOD!='mall' && MOD!='tradelist' && MOD!='fun'){
	//设置向导
	if((!defined('DDYUNKEY') || DDYUNKEY=='' || $webset['siteid']=='') && (int)$_SESSION['admin_mall_set_tip']==0){
		$_SESSION['admin_mall_set_tip']=1;
		jump(u('mall','set'),'请先设置：通信密钥，保证网站的正常运行');
	}
	
	if($webset['taodianjin_pid']=='' && (int)$_SESSION['admin_tradelist_set_tip']==0){
		$_SESSION['admin_tradelist_set_tip']=1;
		jump(u('tradelist','set'),'请先设置：淘点金 保证网站的正常运行');	
	}
	
	$mall_id=$duoduo->select('mall','id','1');
	if(empty($mall_id) && defined('DDYUNKEY') && DDYUNKEY!='' && (int)$_SESSION['admin_mall_list_tip']==0){
		$_SESSION['admin_mall_list_tip']=1;
		jump(u('mall','list'),'请先获取商城数据');
	}	
}

/*公共数据*/
$shifou_arr=array(0=>'否',1=>'是');
$zhuangtai_arr=array(0=>'关闭',1=>'开启');
$_zhuangtai_arr=array(0=>'开启',1=>'关闭');

$mall_path = DDROOT.'/data/mall.txt';
$mall_tag=file_get_contents($mall_path);
if(file_exists($mall_path) && $mall_tag=='all'){
	$need_zhlm = 1;
}

switch (MOD) {
	case 'ad' :
		if (ACT == 'del') {
			$ids = $_GET['ids'];
			foreach ($ids as $k => $v) {
				unlink(DDROOT . '/data/ad/' . $v . '.js');
				$img = $duoduo->select(MOD, 'img', 'id="' . $v . '"');
				del_pic($img);
			}
		}
	break;
	
	case 'api':
	    $open_arr=array(0=>'关闭',1=>'开启');
		if(ACT=='addedi' && isset($_POST['sub'])){
			$meta=$_POST[$_POST['code'].'_meta'];
			unset($_POST[$_POST['code'].'_meta']);
			$duoduo->set_webset($_POST['code'].'_meta',$meta);
			$duoduo->webset();
		}
	break;
	
	case 'city';
	    $status=array(0=>'显示',1=>'隐藏');
	break;
	
	case 'data';
	    get2var();
        post2var();
		define('DDBACKUPDATA', DDROOT . '/data/bdata');

		if (empty ($dopost)) {
			$dopost = '';
		}

		//跳转到一下页的JS
		$gotojs = "function GotoNextPage(){
			document.gonext." . "submit();
		}" . "\r\nset" . "Timeout('GotoNextPage()',500);";

		$dojs = "<script language='javascript'>$gotojs</script>";

		$phpstart = PHP_EXIT."\r\n";
	break;
	
	case 'duihuan';
	    $status_arr=array(0=>'<span style="color:#ff3300">兑换待审核</span>',1=>'<span style="color:#009900">兑换成功</span>',2=>'<span style="color:#333333">兑换失败</span>');
	break;
	
	case 'huan_goods';
	    $status[1] = '隐藏';
		$status[0] = '显示';

		if (ACT == 'del') {
			$ids = $_GET['ids'];
			foreach ($ids as $k => $v) {
				$img = $duoduo->select(MOD, 'img', 'id="' . $v . '"');
				del_pic($img);
			}
		}

		if (ACT == 'addedi' && $_POST['sub'] != '') {
			$arr = array (
				'jifenbao',
				'jifen',
				'num',
				'limit',
			);
			empty2zero($_POST, $arr);
		}
		
		$malls1[0]='无';
		$sql="select id,title,pinyin from ".BIAOTOU."mall order by pinyin asc";
		$query=$duoduo->query($sql);
		while($arr=$duoduo->fetch_array($query)){
		    $malls2[$arr['id']]='('.substr($arr['pinyin'],0,1).')'.$arr['title'];
		}
		if(empty($malls2)){$malls2=array();}
        $malls=$malls1+$malls2;
		if(ACT=='addedi'){
		    $mall_id=$_GET['mall_id'];
		}
		
	break;
	
	case 'huodong';
        if(ACT=='addedi' && $_POST['sub']!=''){
			if((int)$_POST['mall_id']==0){
				jump(-1,'商城必须选择');
			}
		}
		else{
			$malls=mall_pinyin($duoduo);
		}
		if(ACT=='addedi'){
		    $mall_id=$_GET['mall_id'];
		}
	break;
	
	case 'link':
	    $type=array(1=>'图片链接',0=>'文字链接',);
	break;
	
	case 'mall':
	    $lianmeng=include(DDROOT.'/data/lm.php');
		foreach($lianmeng as $k=>$row){
		    $lm[$k]=$row['title'];
		}

		if ($_POST['sub'] != '' && ACT == 'addedi') {
			$array=array('yiqifaid','duomaiid','weiyiid','wujiumiaoid','chanetid','chanet_draftid','edate','merchantId');
			empty2zero($_POST,$array);
		}

		if ($_GET['mallid'] > 0 && $_GET['api_city'] != '') {
			include (DDROOT . '/comm/ddTuan.class.php');
			$tuan = new tuan;
			$tuan->init();
			$arr = dd_get_xml($_GET['api_city']);
			$tuan->get_tuan_city($arr, $_GET['mallid'], $_GET['rule']);
			echo script('alert("获取完毕");window.close()');
			exit;
		}
		
		if(ACT=='set' && isset($_POST['sub']) && ($_POST['chanet']['pwd']==DEFAULTPWD)){
		    $_POST['chanet']['pwd']=$webset['chanet']['pwd'];
		}
		if(ACT=='set' && isset($_POST['sub']) && ($_POST['chanet']['key']==DEFAULTPWD)){
		    $_POST['chanet']['key']=$webset['chanet']['key'];
		}
		if(ACT=='set' && isset($_POST['sub']) && ($_POST['duomai']['key']==DEFAULTPWD)){
		    $_POST['duomai']['key']=$webset['duomai']['key'];
		}
		if(ACT=='set' && isset($_POST['sub']) && ($_POST['linktech']['pwd']==DEFAULTPWD)){
		    $_POST['linktech']['pwd']=$webset['linktech']['pwd'];
		}
		if(ACT=='set' && isset($_POST['sub']) && ($_POST['yiqifa']['key']==DEFAULTPWD)){
		    $_POST['yiqifa']['key']=$webset['yiqifa']['key'];
		}
		
	break;
	
	case 'mall_comment':
		if(ACT=='addedi' && $_POST['sub']!=''){
			if((int)$_POST['mall_id']==0){
				jump(-1,'商城必须选择');
			}
		}
		else{
			$malls=mall_pinyin($duoduo);
		}
        
	break;
	
	case 'nav':
	    $status=array(0=>'显示',1=>'隐藏');
        $target=array(0=>'原窗口',1=>'新窗口');
		$type=array(0=>'无',1=>'new',2=>'hot');
		$nav_arr1=(array)$duoduo->select_2_field('nav');
		$nav_arr=array(0=>'无')+$nav_arr1;
		$nav_tag=$duoduo->select_2_field('nav','id,tag');
	break;
	
	case 'service':
	    $type=array(1=>'QQ客服',2=>'旺旺客服');
	break;
	
	case 'slides':
	    $status[1] = '隐藏';
		$status[0] = '显示';
		
		$category=dd_get_cache('slides','array');

		if (ACT == 'del') {
			$ids = $_GET['ids'];
			foreach ($ids as $k => $v) {
				$img = $duoduo->select(MOD, 'img', 'id="' . $v . '"');
				del_pic($img);
			}
		}
	break;
	
	case 'smtp':
	    $status = array (
			0 => '关闭',
			1 => '开启'
		);
		if (isset($_POST['smtphost']) && $_POST['smtphost'] != '') {
			$from = $_POST['smtpuser'];
			$to = $_POST['test_email'];
			$usepassword = $_POST['smtppwd']==DEFAULTPWD?$webset['smtp']['pwd']:$_POST['smtppwd'];
			$smtp = $_POST['smtphost'];
			$type = $_POST['type'];
			$title = $_POST['title'];
			$html = del_magic_quotes_gpc($_POST['html']);
			echo mail_send($to, $title, $html, $from, $usepassword, $smtp,$type);
			exit;
		}

		if(ACT=='set' && isset($_POST['sub']) && (!isset($_POST['smtp']['pwd']) || $_POST['smtp']['pwd']==DEFAULTPWD)){
		    $_POST['smtp']['pwd']=$webset['smtp']['pwd'];
		}
	break;
	
	case 'tradelist':
		$auto_fanli_plan=array('trade_uid','equal','time');
	    $checked_arr=include(DDROOT.'/data/checked_arr.php'); //订单会员状态
		$checked_arr=array(''=>'全部')+$checked_arr;
		
	   
		$status_arr=include(DDROOT.'/data/status_arr.php');//订单状态
		foreach($status_arr as $k=>$v){
			$_status_arr[$k]=strip_tags($v);
		}
	break;
	
	case 'paipai_order':
		//array(0=>'未核对',2=>'有效',-1=>'退款');
	    $checked_status=include(DDROOT.'/data/status_arr_paipai.php'); //订单状态
	break;
	
	case 'mall_order':
		$lianmeng=include(DDROOT.'/data/lm.php');
	    $status_arr2=include(DDROOT.'/data/status_arr_mall.php'); //订单状态		
		$lianmeng_arr=array();

		if($need_zhlm==1){
			$i=1;
			foreach($lianmeng as $k=>$arr){
				if($i==1){$first=$k;}
				if($webset[$arr['code']]['status']==1){
					$lianmeng_arr[$k]=$arr['title'];
				}
				$i++;
			}
		}
		else{
			$first=8;
		}
		$lianmeng_arr[8]='综合联盟';
		
	break;
	
	case 'tuan_goods':
	    $malls1[0]='全部';
		$sql="select id,title,pinyin from ".BIAOTOU."mall where cid=21 order by pinyin asc";
		$query=$duoduo->query($sql);
		while($arr=$duoduo->fetch_array($query)){
		    $malls2[$arr['id']]='('.substr($arr['pinyin'],0,1).')'.$arr['title'];
		}
		if(empty($malls2)){$malls2=array();}
        $malls=$malls1+$malls2;
        $cat=$duoduo->select_2_field('tuan_type');
	break;
	
	case 'user':
	    if(ACT=='set'){
		    if($_POST['sub']!=''){
				if((float)$_POST['user']['auto_increment']>$webset['user']['auto_increment']){
				    $sql="ALTER TABLE `".BIAOTOU."user` AUTO_INCREMENT =".(float)$_POST['user']['auto_increment']."";
				    $duoduo->query($sql);
				}
			}
			else{
			    $result = $duoduo->query("show table status like '".BIAOTOU."user'");
                $auto_increment = mysql_result($result, 0, 'Auto_increment');
			}
		}
	    $tixian_status=array('0'=>'未提现','1'=>'提现中');
        $duihuan_status=array('0'=>'未兑换','1'=>'兑换中');
        $jihuo_status=array('0'=>'未激活','1'=>'已激活');
        $fxb_status=array('0'=>'禁用','1'=>'可用');
		
		if(ACT=='set' && isset($_POST['sub']) && !isset($_POST['user']['auto_increment'])){
		    $_POST['user']['auto_increment']=$webset['user']['auto_increment'];
		}
		foreach($webset['level'] as $k=>$v ){//帐号类型
			$user_level_type[$k]=$v['title'];
		} 
	break;
	
	case 'duoduo2010':
	    $role_arr=$duoduo->select_2_field('role','id,title','1=1');
	break;
	
	case 'menu':
	    if(!isset($_POST['sub'])){
		    $node1_arr=$duoduo->select_2_field('menu','id,title','`mod`="" and `act`=""');
		    $node2_arr=array(0=>'无');
            $node_arr=$node2_arr+$node1_arr;
		}
	    
		$hide_arr=array(0=>'显示',1=>'隐藏');
		if (ACT == 'del') {
			$ids = $_GET['ids'];
			foreach ($ids as $k => $v) {
				$duoduo->delete('menu_access','id="'.$v.'"');
			}
		}
	break;
	
	case 'tuan_goods':
	    $malls=$duoduo->select_2_field(get_mall_table_name(),'id,title','cid="'.$webset['tuan']['mall_cid'].'" and  api_url is not null and api_url<>"" and api_rule<>"" and api_rule is not null order by sort desc');
        $cat=$duoduo->select_2_field('tuan_type');
	break;
	
	case 'shop':
		$shop_type = include (DDROOT . '/data/tao_shop_cid.php');
	break;
	
	case 'article':
		if (ACT == 'del') {
			$ids = $_GET['ids'];
			foreach ($ids as $k => $v) {
				$img = $duoduo->select(MOD, 'img', 'id="' . $v . '"');
				del_pic($img);
			}
		}
	break;
}
?>