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

$plugin_id=(int)$_GET['plugin_id'];

if(isset($_GET['code'])){
	$plugin_code=$_GET['code'];
	$plugin_arr=$duoduo->select('plugin','id,install','code="'.$plugin_code.'"');	
	$plugin_id=$plugin_arr['id'];
	if(empty($plugin_id)){
		jump(u('plugin','list'),'请先获取百宝箱订单！');
	}
	if($plugin_arr['install']==0){
		jump(u('plugin','update',array('code'=>$plugin_code,'do'=>'install')),'请先安装！');
	}
}

$do=$_GET['do']?$_GET['do']:'index';
include(DDROOT.'/comm/plugin.class.php');
$plugin=$duoduo->select('plugin','*','id="'.$plugin_id.'"');
$plugin_set=DDROOT.'/plugin/'.$plugin['code'].'/set.php';
if(is_file($plugin_set)){
	$plugin_set=include($plugin_set);
}
else{
	$plugin_set=array();
}
$plugin_class=new plugin($duoduo,$plugin['code']);
$table_name='plugin_'.$plugin['code'];
include(DDROOT.'/plugin/'.$plugin['code'].'/admin/fun.php');

if(!empty($_POST) && $do=='index'){
	if(!is_numeric($_POST['status'])){
		jump(-1,'应用状态数值无效');
	}
	$plugin_status=dd_get_cache('plugin');
	$plugin_status[$plugin['code']]=$_POST['status'];
	dd_set_cache('plugin',$plugin_status);
	$data_a=array('status'=>$_POST['status']);
	$duoduo->update('plugin',$data_a,'id="'.$plugin_id.'"');
	
	if(!empty($plugin_set['search'])){
		if(!is_numeric($_POST['search'])){
			jump(-1,'搜索状态数值无效');
		}
		if($_POST['search']==1){
			$row=array('act'=>$plugin_set['search']['act'],'search_name'=>$_POST['search_name'],'search_tip'=>$_POST['search_tip'],'search_width'=>$_POST['search_width']);
			$plugin_class->install_search($row);
			$plugin_set['search']['search_name']=$_POST['search_name'];
			$plugin_set['search']['search_tip']=$_POST['search_tip'];
			$plugin_set['search']['search_width']=$_POST['search_width'];
			$plugin_set_var='<?php //多多'."\r\nreturn ".var_export($plugin_set,1).';'."\r\n".'?>';
			dd_file_put(DDROOT.'/plugin/'.$plugin['code'].'/set.php',$plugin_set_var);
		}
		else{
			$plugin_class->uninstall_search();
		}
	}
}

if(isset($_POST['sub']) && $plugin_set['admin_auto'][$do]==1){
	if($do=='index'){
		unset($_POST['sub']);
		del_magic_quotes_gpc($_POST,1);
		
		$a=dd_get_cache('plugin/'.$plugin['code']);
		
		foreach($_POST as $k=>$v){
			if(strpos($k,'password')!==false){
				if($v==DEFAULTPWD){
					$_POST[$k]=$a[$k];
				}
			}
		}
		
		dd_set_cache('plugin/'.$plugin['code'],$_POST);
		jump(-1,'设置完成');
	}
	elseif($do=='list'){
		
	}
	elseif($do=='addedi'){
		$id=(int)$_POST['id'];
		unset($_POST['sub']);
		unset($_POST['id']);
		if($id>0){
			$duoduo->update($table_name,$_POST,'id="'.$id.'"');
		}
		else{
			$duoduo->insert($table_name,$_POST);

		}
		jump('-2','完成');
	}
}
elseif($plugin_set['admin_auto'][$do]==1){
	if($do=='index'){
		$plugin_data=dd_get_cache('plugin/'.$plugin['code']);
	}
	elseif($do=='list'){
		$get=$_GET;
		$order_by=$_GET['order_by']?$_GET['order_by']:'order by id desc';
		$sql_where=$_GET['sql_where'];
		$where='1=1';
		preg_match_all('/\{(.*?)\}/',$sql_where,$a);
		
		foreach($a[1] as $v){
			$b=explode(':',$v);
			if($b[1]=='char'){
				$c='%'.$_GET[$b[0]].'%';
				if($_GET[$b[0]]==''){
					$d=0;
				}
				else{
					$d=1;
				}
			}
			else{
				$c=$_GET[$b[0]];
				if($_GET[$b[0]]==0){
					$d=0;
				}
				else{
					$d=1;
				}
			}
			if($d==1 || $b[3]=='empty'){
				$where.=' and '.$b[0].' '.$b[2].' "'.$c.'"';
			}
		}
		
		$page_arr=u(MOD,ACT,array('do'=>$do,'plugin_id'=>$plugin_id));
		
		$page = !($_GET['page'])?'1':intval($_GET['page']);
		$pagesize=20;
		$frmnum=($page-1)*$pagesize;
		
		$total=$duoduo->count($table_name,$where);
		$plugin_data=$duoduo->select_all($table_name,'*',$where.' '.$order_by.' limit '.$frmnum.','.$pagesize);
	}
	elseif($do=='addedi'){
		if(isset($_GET['id'])){
			$id=(int)$_GET['id'];
			$plugin_data=$duoduo->select($table_name,'*','id="'.$id.'"');	
		}
		else{
			$plugin_data=array();
		}
	}
	elseif($do=='del'){
		$ids=$_GET['ids'];
		if($ids==''){
    		jump('-1','无效参数');
		}
		else{
   	 		$ids=implode($ids,',');
    		$re=$duoduo->delete_id_in($ids,$table_name);
    		if($re==1){
        		jump('-1','删除完成');
    		}
    		else{
        		echo "error";
    		}
		}
	}
}

if($do=='create_set'){
	foreach($plugin_set['table'] as $k=>$v){
		$re=$duoduo->get_table_struct('plugin_'.$k);
		if($re!==0){
			$plugin_set['table'][$k]=$re;
		}
	}
	$plugin_set['debug']=0;
	$plugin_set_var='<?php //多多'."\r\nreturn ".var_export($plugin_set,1).';'."\r\n".'?>';
	dd_file_put(DDROOT.'/plugin/'.$plugin['code'].'/set.php',$plugin_set_var);
	//dd_file_put(DDROOT.'/plugin/'.$plugin['code'].'/set.json',json_encode($plugin_set));
	jump(-1,'完成');
}

if(isset($plugin_set['admin_nav'])){
	$plugin_admin_nav=$plugin_set['admin_nav'];
}
else{
	$plugin_admin_nav=array();
}

$mod_act_name=$plugin['title'].$plugin_admin_nav[$do]['title'];

if(!isset($_GET['no_header']) && !isset($_POST['no_header'])){
include(ADMINTPL.'/header.tpl.php');
?>
<style>
.explain-col a.current{ color:#F00; font-weight:bold}
.a{float:left; border-width:1px 0; border-color:#bbbbbb; border-style:solid; display:block; font-weight:normal; text-decoration:none}
.b{height:22px; border-width:0 1px; border-color:#bbbbbb; border-style:solid; margin:0 -1px; background:#e3e3e3; position:relative; float:left;}
.c{line-height:10px; color:#f9f9f9; background:#f9f9f9; border-bottom:2px solid #eeeeee;}
.d{padding:0 8px; line-height:22px; font-size:12px; color:#000000; clear:both; margin-top:-12px; cursor:pointer;}
a.a:hover{ text-decoration:none;}
a.a:hover .d{ color:#F00}
</style>
<?php
if(!empty($plugin_admin_nav)){
	echo '<div class="explain-col">';
	foreach($plugin_admin_nav as $k=>$row){
		if($row['url']!=''){
			$href=$row['url'];
			$target="_blank";
		}
		else{
			if(isset($row['mod']) && isset($row['act'])){
				$href=u($row['mod'],$row['act'],$row['arr']);
			}
			else{
				if(is_array($row['arr']) && !empty($row['arr'])){
					$_arr=array_merge(array('do'=>$k,'plugin_id'=>$plugin_id),$row['arr']);
				}
				else{
					$_arr=array('do'=>$k,'plugin_id'=>$plugin_id);
				}
				$href=u(MOD,ACT,$_arr);
			}
			$target="_self";
		}
		if($do==$k){
			$class="current";
		}
		else{
			$class='';
		}
		echo '<a class="'.$class.'" target="'.$target.'" href="'.$href.'">'.$row['title'].'</a>&nbsp;&nbsp;&nbsp;';
   	}
   	echo "</div>";
}

$debug_arr=array(array('do'=>'create_set','title'=>'生成配置文件'));

if($plugin_set['debug']==1){
	foreach($debug_arr as $row){
		echo '<a class="a" href="'.u(MOD,ACT,array('plugin_id'=>$plugin_id,'do'=>$row['do'])).'"><div class="b"><div class="c">&nbsp;</div><div class="d">'.$row['title'].'</div></div></a><div style=" clear:both"></div>';
	}
}
}
include(DDROOT.'/plugin/'.$plugin['code'].'/admin/'.$do.'.php');
?>

<script>
$(function(){
	<?php if($plugin_set['debug']==1){?>
	$('a').each(function(){
		var href=$(this).attr('href').toLowerCase();
		if(href.indexOf('index.php')==0 && href.indexOf('mod=plugin')>0){
			if(href.indexOf('&do=')<0 || href.indexOf('&do=&')>=0){
				var text=$(this).text();
				$(this).html(text+'<span style=" font-size:11px; color:red">[缺少do参数]</span>');
			}
			if(href.indexOf('&plugin_id=')<0 || href.indexOf('&plugin_id=&')>=0){
				//href+='&plugin_id=<?=$plugin_id?>';
				$(this).html(text+'<span style=" font-size:11px; color:red">[缺少plugin_id参数]</span>');
			}
			//$(this).attr('href',href);
		}
	});
	$('form').each(function(){
		var action=$(this).attr('action').toLowerCase();
		var method=$(this).attr('method').toLowerCase();
		var name=$(this).attr('name');
		if(method=='post' && action.indexOf('index.php')==0){
			if(action.indexOf('&do=')<0 || action.indexOf('&do=&')>=0){
				alert('警告：form[name='+name+']缺少do参数');
			}
			if(action.indexOf('&plugin_id=')<0 || action.indexOf('&plugin_id=&')>=0){
				alert('警告：form[name='+name+']缺少plugin_id参数');
			}
			//$(this).attr('action',action);
		}
		else if(method=='get'){
			var l=$(this).find('input[name=do]').length;
			if(l==0){
				alert('警告：form[name='+name+']缺少do参数');
			}
			var l=$(this).find('input[name=plugin_id]').length;
			if(l==0){
				alert('警告：form[name='+name+']缺少plugin_id参数');
				//$(this).prepend('<input type="hidden" value="<?=$plugin_id?>" name="plugin_id" />');
			}
		}
	});
	<?php }?>
	<?php if($do=='index'){?>
	var l=$('input[name=status]').length;
	if(l==0){
		alert('警告：缺少状态input');
	}
	<?php if(!empty($plugin_set['search'])){?>
	var l=$('input[name=search]').length;
	if(l==0){
		alert('警告：缺少搜索状态input');
	}
	<?php }?>
	<?php }?>
})
</script>
<?php
if(!isset($_GET['no_header']) && !isset($_POST['no_header'])){
	include(ADMINTPL.'/footer.tpl.php');
}
?>