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

$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=20;
$frmnum=($page-1)*$pagesize;
$q=$_GET['q'];
$total=$duoduo->count('type',"`title` like '%$q%' and tag='".$mod_tag."'");

if($_GET['mod']=='mall_type' && $_GET['act']=='list' && $need_zhlm==0){
	$type = array (
		array (
			'id' => 14,
			'title' => '综合商城'
		),
		array (
			'id' => 15,
			'title' => '服装服饰'
		),
		array (
			'id' => 16,
			'title' => '数码家电'
		),
		array (
			'id' => 17,
			'title' => '美容化妆'
		),
		array (
			'id' => 18,
			'title' => '家庭生活'
		),
		array (
			'id' => 19,
			'title' => '母婴用品'
		),
		array (
			'id' => 20,
			'title' => '图书音像'
		),
		array (
			'id' => 21,
			'title' => '团购返利'
		),
		array (
			'id' => 22,
			'title' => '鞋包配饰'
		),
		array (
			'id' => 23,
			'title' => '旅行酒店'
		),
		array (
			'id' => 24,
			'title' => '虚拟商品'
		),
		array (
			'id' => 25,
			'title' => '食品饮料'
		)
	);
	
	$duoduo->delete('type','tag="mall"');

	foreach($type as $row){
		$data=array('title'=>$row['title'],'tag'=>'mall');
		$id=(int)$duoduo->select('type','id="'.$row['id'].'"');
		if($id==0){
			$data['id']=$row['id'];
			$duoduo->insert('type',$data);
		}
		else{
			$duoduo->update('type',$data,'id="'.$row['id'].'"');
		}
	}
	jump(-1,'综合商城分类重置完毕');
}

//获取分类列表信息
function getCategoryList($id = 0, $level = 0,$page=0,$frmnum=20) {
	global $duoduo;
	global $mod_tag;
	global $q;
	global $frmnum;
	global $pagesize;
	$category_arr = $duoduo->select_all('type','*','pid="'.$id.'" and tag="'.$mod_tag.'" and title like "%'.$q.'%" order by sort asc,id asc limit '.$frmnum.','.$pagesize);
	for($lev = 0; $lev < $level; $lev ++) {
		$level_nbsp .= "&nbsp;&nbsp;";
	}
	$level++;
	$level_nbsp .= "<span style=\"font-size:12px;font-family:wingdings\">".$level."</span>";
	foreach ( $category_arr as $category ) {
		$id = $category ['id'];
		$name = $category ['title'];
		$category ['sort'] = $category['sort']==DEFAULT_SORT?'——':$category['sort'];
		if($category['sys']==1){
            $tip='title="系统数据，不准删除"  disabled="disabled"';
		}
		else{
		    $tip='';
		}
		echo "
<tr>
  <td><input ".$tip." type='checkbox' name='ids[]' value='".$id."' /></td>
  <td style='text-align:left; padding-left:5px'>" . $level_nbsp . "&nbsp;" . $name . "(cid: $id)</td>
  <td>" . getArticleNumOfCategory ( $id ) . "&nbsp;</td>
  <td class='input' field='sort' w='50' tableid='".$id."' status='a' title='双击编辑'>" . $category ['sort'] . "&nbsp;</td>
  <td><a href='".u(MOD,'addedi',array('id'=>$id,'do'=>'add'))."'>添加子分类</a> |&nbsp;<a href='".u($mod_tag,'addedi',array('cid'=>$id))."'>添加内容</a> |&nbsp;<a href='".u(MOD,'addedi',array('id'=>$id,'do'=>'edi'))."'>修改分类</a></td>
</tr> ";
		getCategoryList ( $id, $level );
	}
}

//分类下数量
function getArticleNumOfCategory($cid) {
	global $duoduo;
	global $mod_tag;
	return $duoduo->count($mod_tag,'cid="'.$cid.'"');
}