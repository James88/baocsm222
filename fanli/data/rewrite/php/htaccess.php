<?php
include('../../../comm/dd.config.php');
$alias=dd_get_cache('alias');
$cur_path=str_replace('data/rewrite/php/'.filename(),'',$_SERVER['SCRIPT_NAME']);
$cur_path=preg_replace('#^/#','',$cur_path);
ob_start();
?>
# 将 RewriteEngine 模式打开
RewriteEngine On

# Rewrite 定义各重写规则
RewriteRule <?=$cur_path?><?=$alias['mall/list'][0]?>/<?=$alias['mall/list'][1]?>-(.*)-(\d+)\.html$ /<?=$cur_path?>index.php\?mod=mall&act=list&cid=$1&page=$2
RewriteRule <?=$cur_path?><?=$alias['mall/list'][0]?>/<?=$alias['mall/list'][1]?>-(.*)\.html$ /<?=$cur_path?>index.php\?mod=mall&act=list&cid=$1
RewriteRule <?=$cur_path?><?=$alias['mall/list'][0]?>/<?=$alias['mall/list'][1]?>\.html$ /<?=$cur_path?>index.php\?mod=mall&act=list
RewriteRule <?=$cur_path?><?=$alias['mall/view'][0]?>/<?=$alias['mall/view'][1]?>-(\d+)-(.*)-(\d+)\.html$ /<?=$cur_path?>index.php\?mod=mall&act=view&id=$1&do=$2&page=$3
RewriteRule <?=$cur_path?><?=$alias['mall/view'][0]?>/<?=$alias['mall/view'][1]?>-(\d+)-(.*)\.html$ /<?=$cur_path?>index.php\?mod=mall&act=view&id=$1&do=$2
RewriteRule <?=$cur_path?><?=$alias['mall/view'][0]?>/<?=$alias['mall/view'][1]?>-(\d+)\.html$ /<?=$cur_path?>index.php\?mod=mall&act=view&id=$1
RewriteRule <?=$cur_path?><?=$alias['mall/goods'][0]?>/<?=$alias['mall/goods'][1]?>-(.*)-(\d+)-(\d+)-(\d+)-(\d+)-(.*)-(\d+)\.html$ /<?=$cur_path?>index.php\?mod=mall&act=goods&merchantId=$1&order=$2&start_price=$3&end_price=$4&list=$5&q=$6&page=$7
RewriteRule <?=$cur_path?><?=$alias['mall/goods'][0]?>/<?=$alias['mall/goods'][1]?>-(.*)\.html$ /<?=$cur_path?>index.php\?mod=mall&act=goods&q=$1
RewriteRule <?=$cur_path?><?=$alias['mall/goods'][0]?>/<?=$alias['mall/goods'][1]?>\.html$ /<?=$cur_path?>index.php\?mod=mall&act=goods

RewriteRule <?=$cur_path?><?=$alias['article/index'][0]?>/<?=$alias['article/index'][1]?>\.html$ /<?=$cur_path?>index.php\?mod=article&act=index
RewriteRule <?=$cur_path?><?=$alias['article/index'][0]?>/$ /<?=$cur_path?>index.php\?mod=article&act=index
RewriteRule <?=$cur_path?><?=$alias['article/index'][0]?>$ /<?=$cur_path?>index.php\?mod=article&act=index
RewriteRule <?=$cur_path?><?=$alias['article/list'][0]?>/<?=$alias['article/list'][1]?>-(.*)-(\d+)\.html$ /<?=$cur_path?>index.php\?mod=article&act=list&cid=$1&page=$2
RewriteRule <?=$cur_path?><?=$alias['article/list'][0]?>/<?=$alias['article/list'][1]?>-(.*)\.html$ /<?=$cur_path?>index.php\?mod=article&act=list&cid=$1
RewriteRule <?=$cur_path?><?=$alias['article/list'][0]?>/<?=$alias['article/list'][1]?>\.html$ /<?=$cur_path?>index.php\?mod=article&act=list
RewriteRule <?=$cur_path?><?=$alias['article/view'][0]?>/<?=$alias['article/view'][1]?>-(\d+)\.html$ /<?=$cur_path?>index.php\?mod=article&act=view&id=$1

RewriteRule <?=$cur_path?><?=$alias['huodong/list'][0]?>/<?=$alias['huodong/list'][1]?>-(\d+)-(\d+)\.html$ /<?=$cur_path?>index.php\?mod=huodong&act=list&cid=$1&page=$2
RewriteRule <?=$cur_path?><?=$alias['huodong/list'][0]?>/<?=$alias['huodong/list'][1]?>-(\d+)\.html$ /<?=$cur_path?>index.php\?mod=huodong&act=list&page=$1
RewriteRule <?=$cur_path?><?=$alias['huodong/list'][0]?>/<?=$alias['huodong/list'][1]?>\.html$ /<?=$cur_path?>index.php\?mod=huodong&act=list
RewriteRule <?=$cur_path?><?=$alias['huodong/view'][0]?>/<?=$alias['huodong/view'][1]?>-(\d+)\.html$ /<?=$cur_path?>index.php\?mod=huodong&act=view&id=$1

RewriteRule <?=$cur_path?><?=$alias['huan/list'][0]?>/<?=$alias['huan/list'][1]?>-(\d+)-(\d+)\.html$ /<?=$cur_path?>index.php\?mod=huan&act=list&cid=$1&page=$2
RewriteRule <?=$cur_path?><?=$alias['huan/list'][0]?>/<?=$alias['huan/list'][1]?>-(\d+)\.html$ /<?=$cur_path?>index.php\?mod=huan&act=list&cid=$1
RewriteRule <?=$cur_path?><?=$alias['huan/list'][0]?>/<?=$alias['huan/list'][1]?>-(.*)\.html$ /<?=$cur_path?>index.php\?mod=huan&act=list&cid=$1
RewriteRule <?=$cur_path?><?=$alias['huan/list'][0]?>/<?=$alias['huan/list'][1]?>\.html$ /<?=$cur_path?>index.php\?mod=huan&act=list
RewriteRule <?=$cur_path?><?=$alias['huan/view'][0]?>/<?=$alias['huan/view'][1]?>-(\d+)\.html$ /<?=$cur_path?>index.php\?mod=huan&act=view&id=$1

RewriteRule <?=$cur_path?><?=$alias['tao/index'][0]?>/<?=$alias['tao/index'][1]?>\.html$ /<?=$cur_path?>index.php\?mod=tao&act=index
RewriteRule <?=$cur_path?><?=$alias['tao/index'][0]?>/$ /<?=$cur_path?>index.php\?mod=tao&act=index
RewriteRule <?=$cur_path?><?=$alias['tao/index'][0]?>$ /<?=$cur_path?>index.php\?mod=tao&act=index
RewriteRule <?=$cur_path?><?=$alias['tao/list'][0]?>/<?=$alias['tao/list'][1]?>-(.*)-(.*)-(\d+)-(\d+)\.html$ /<?=$cur_path?>index.php\?mod=tao&act=list&cid=$1&q=$2&list=$3&page=$4
RewriteRule <?=$cur_path?><?=$alias['tao/list'][0]?>/<?=$alias['tao/list'][1]?>-(.*)-(\d+)\.html$ /<?=$cur_path?>index.php\?mod=tao&act=list&cid=$1&page=$2
RewriteRule <?=$cur_path?><?=$alias['tao/list'][0]?>/<?=$alias['tao/list'][1]?>-0-(.*)\.html$ /<?=$cur_path?>index.php\?mod=tao&act=list&cid=0&q=$1
RewriteRule <?=$cur_path?><?=$alias['tao/list'][0]?>/<?=$alias['tao/list'][1]?>-(.*)\.html$ /<?=$cur_path?>index.php\?mod=tao&act=list&cid=$1
RewriteRule <?=$cur_path?><?=$alias['tao/list'][0]?>/<?=$alias['tao/list'][1]?>\.html$ /<?=$cur_path?>index.php\?mod=tao&act=list
RewriteRule <?=$cur_path?><?=$alias['tao/view'][0]?>/<?=$alias['tao/view'][1]?>-(.*)-(.*)-(.*)\.html$ /<?=$cur_path?>index.php\?mod=tao&act=view&iid=$1&promotion_price=$2&promotion_endtime=$3
RewriteRule <?=$cur_path?><?=$alias['tao/view'][0]?>/<?=$alias['tao/view'][1]?>-(.*)\.html$ /<?=$cur_path?>index.php\?mod=tao&act=view&iid=$1
RewriteRule <?=$cur_path?><?=$alias['tao/shop'][0]?>/<?=$alias['tao/shop'][1]?>-(.*)-(\d+)\.html$ /<?=$cur_path?>index.php\?mod=tao&act=shop&nick=$1&list=$2
RewriteRule <?=$cur_path?><?=$alias['tao/shop'][0]?>/<?=$alias['tao/shop'][1]?>-(.*)\.html$ /<?=$cur_path?>index.php\?mod=tao&act=shop&nick=$1
RewriteRule <?=$cur_path?><?=$alias['tao/zhe'][0]?>/<?=$alias['tao/zhe'][1]?>-(.*)-(\d+)-(\d+)\.html$ /<?=$cur_path?>index.php\?mod=tao&act=zhe&q=$1&cid=$2&page=$3
RewriteRule <?=$cur_path?><?=$alias['tao/zhe'][0]?>/<?=$alias['tao/zhe'][1]?>-(.*)\.html$ /<?=$cur_path?>index.php\?mod=tao&act=zhe&q=$1
RewriteRule <?=$cur_path?><?=$alias['tao/zhe'][0]?>/<?=$alias['tao/zhe'][1]?>\.html$ /<?=$cur_path?>index.php\?mod=tao&act=zhe

RewriteRule <?=$cur_path?><?=$alias['shop/list'][0]?>/<?=$alias['shop/list'][1]?>-(\d+)-(\d+)-(\d+)-(\d+)-(.*)-(\d+)\.html$ /<?=$cur_path?>index.php\?mod=shop&act=list&cid=$1&start_level=$2&end_level=$3&type=$4&nick=$5&page=$6
RewriteRule <?=$cur_path?><?=$alias['shop/list'][0]?>/<?=$alias['shop/list'][1]?>-(.*)-(\d+)\.html$ /<?=$cur_path?>index.php\?mod=shop&act=list&cid=$1&page=$2
RewriteRule <?=$cur_path?><?=$alias['shop/list'][0]?>/<?=$alias['shop/list'][1]?>-(.*)\.html$ /<?=$cur_path?>index.php\?mod=shop&act=list&cid=$1
RewriteRule <?=$cur_path?><?=$alias['shop/list'][0]?>/<?=$alias['shop/list'][1]?>\.html$ /<?=$cur_path?>index.php\?mod=shop&act=list

RewriteRule <?=$cur_path?><?=$alias['baobei/list'][0]?>/<?=$alias['baobei/list'][1]?>-0-(.*)-(\d+)\.html$ /<?=$cur_path?>index.php\?mod=baobei&act=list&cid=0&q=$1&page=$2
RewriteRule <?=$cur_path?><?=$alias['baobei/list'][0]?>/<?=$alias['baobei/list'][1]?>-0-(.*)\.html$ /<?=$cur_path?>index.php\?mod=baobei&act=list&cid=0&q=$1
RewriteRule <?=$cur_path?><?=$alias['baobei/list'][0]?>/<?=$alias['baobei/list'][1]?>-(.*)-(\d+)-(\d+)\.html$ /<?=$cur_path?>index.php\?mod=baobei&act=list&sort=$1&cid=$2&page=$3
RewriteRule <?=$cur_path?><?=$alias['baobei/list'][0]?>/<?=$alias['baobei/list'][1]?>-(\d+)-(\d+)\.html$ /<?=$cur_path?>index.php\?mod=baobei&act=list&cid=$1&page=$2
RewriteRule <?=$cur_path?><?=$alias['baobei/list'][0]?>/<?=$alias['baobei/list'][1]?>-(\d+)\.html$ /<?=$cur_path?>index.php\?mod=baobei&act=list&cid=$1
RewriteRule <?=$cur_path?><?=$alias['baobei/list'][0]?>/<?=$alias['baobei/list'][1]?>\.html$ /<?=$cur_path?>index.php\?mod=baobei&act=list
RewriteRule <?=$cur_path?><?=$alias['baobei/user'][0]?>/<?=$alias['baobei/user'][1]?>-(\d+)-(\d+)-(\d+)\.html$ /<?=$cur_path?>index.php\?mod=baobei&act=user&uid=$1&xs=$2&page=$3
RewriteRule <?=$cur_path?><?=$alias['baobei/user'][0]?>/<?=$alias['baobei/user'][1]?>-(\d+)-(\d+)\.html$ /<?=$cur_path?>index.php\?mod=baobei&act=user&uid=$1&xs=$2
RewriteRule <?=$cur_path?><?=$alias['baobei/user'][0]?>/<?=$alias['baobei/user'][1]?>-(\d+)\.html$ /<?=$cur_path?>index.php\?mod=baobei&act=user&uid=$1
RewriteRule <?=$cur_path?><?=$alias['baobei/view'][0]?>/<?=$alias['baobei/view'][1]?>-(\d+)\.html$ /<?=$cur_path?>index.php\?mod=baobei&act=view&id=$1

RewriteRule <?=$cur_path?><?=$alias['tuan/list'][0]?>/<?=$alias['tuan/list'][1]?>-(\d+)-(\d+)-(\d+)-(.*)-(\d+)\.html$ /<?=$cur_path?>index.php\?mod=tuan&act=list&cid=$1&mall_id=$2&city_id=$3&sort=$4&page=$5
RewriteRule <?=$cur_path?><?=$alias['tuan/list'][0]?>/<?=$alias['tuan/list'][1]?>-(\d+)-(\d+)-(.*)\.html$ /<?=$cur_path?>index.php\?mod=tuan&act=list&cid=$1&city_id=$2&sort=$3
RewriteRule <?=$cur_path?><?=$alias['tuan/list'][0]?>/<?=$alias['tuan/list'][1]?>-(\d+)-(\d+)\.html$ /<?=$cur_path?>index.php\?mod=tuan&act=list&cid=$1&page=$2
RewriteRule <?=$cur_path?><?=$alias['tuan/list'][0]?>/<?=$alias['tuan/list'][1]?>-(.*)-(\d+)\.html$ /<?=$cur_path?>index.php\?mod=tuan&act=list&q=$1&page=$2
RewriteRule <?=$cur_path?><?=$alias['tuan/list'][0]?>/<?=$alias['tuan/list'][1]?>-(\d+)\.html$ /<?=$cur_path?>index.php\?mod=tuan&act=list&cid=$1
RewriteRule <?=$cur_path?><?=$alias['tuan/list'][0]?>/<?=$alias['tuan/list'][1]?>-(.*)\.html$ /<?=$cur_path?>index.php\?mod=tuan&act=list&q=$1
RewriteRule <?=$cur_path?><?=$alias['tuan/list'][0]?>/<?=$alias['tuan/list'][1]?>\.html$ /<?=$cur_path?>index.php\?mod=tuan&act=list
RewriteRule <?=$cur_path?><?=$alias['tuan/view'][0]?>/<?=$alias['tuan/view'][1]?>-(\d+)\.html$ /<?=$cur_path?>index.php\?mod=tuan&act=view&id=$1

RewriteRule <?=$cur_path?><?=$alias['help/index'][0]?>/<?=$alias['help/index'][1]?>-(\d+)\.html$ /<?=$cur_path?>index.php\?mod=help&act=index&cid=$1
RewriteRule <?=$cur_path?><?=$alias['help/index'][0]?>/<?=$alias['help/index'][1]?>\.html$ /<?=$cur_path?>index.php\?mod=help&act=index
RewriteRule <?=$cur_path?><?=$alias['help/index'][0]?>/$ /<?=$cur_path?>index.php\?mod=help&act=index
RewriteRule <?=$cur_path?><?=$alias['help/index'][0]?>$ /<?=$cur_path?>index.php\?mod=help&act=index

RewriteRule <?=$cur_path?><?=$alias['about/index'][0]?>/<?=$alias['about/index'][1]?>-(\d+)\.html$ /<?=$cur_path?>index.php\?mod=about&act=index&id=$1
RewriteRule <?=$cur_path?><?=$alias['about/index'][0]?>/<?=$alias['about/index'][1]?>\.html$ /<?=$cur_path?>index.php\?mod=about&act=index
RewriteRule <?=$cur_path?><?=$alias['about/index'][0]?>/$ /<?=$cur_path?>index.php\?mod=about&act=index
RewriteRule <?=$cur_path?><?=$alias['about/index'][0]?>$ /<?=$cur_path?>index.php\?mod=about&act=index

RewriteRule <?=$cur_path?><?=$alias['paipai/index'][0]?>/<?=$alias['paipai/index'][1]?>\.html$ /<?=$cur_path?>index.php\?mod=paipai&act=index
RewriteRule <?=$cur_path?><?=$alias['paipai/index'][0]?>/$ /<?=$cur_path?>index.php\?mod=paipai&act=index
RewriteRule <?=$cur_path?><?=$alias['paipai/index'][0]?>$ /<?=$cur_path?>index.php\?mod=paipai&act=index
RewriteRule <?=$cur_path?><?=$alias['paipai/list'][0]?>/<?=$alias['paipai/list'][1]?>-(\d+)-(.*)-(\d+)-(.*)-(\d+)-(\d+)-(\d+)-(\d+)\.html$ /<?=$cur_path?>index.php\?mod=paipai&act=list&cid=$1&q=$2&sort=$3&property=$4&begPrice=$5&endPrice=$6&list=$7&page=$8
RewriteRule <?=$cur_path?><?=$alias['paipai/list'][0]?>/<?=$alias['paipai/list'][1]?>-(.*)\.html$ /<?=$cur_path?>index.php\?mod=paipai&act=list&q=$1
RewriteRule <?=$cur_path?><?=$alias['paipai/list'][0]?>/<?=$alias['paipai/list'][1]?>\.html$ /<?=$cur_path?>index.php\?mod=paipai&act=list

RewriteRule <?=$cur_path?><?=$alias['sitemap/index'][0]?>/<?=$alias['sitemap/index'][1]?>\.html$ /<?=$cur_path?>index.php\?mod=sitemap&act=index
RewriteRule <?=$cur_path?>tbimg/(.*)\.jpg$ /<?=$cur_path?>comm/showpic.php\?pic=$1

<?php if($webset['static']['index']['index']!=1){?>
RewriteRule <?=$cur_path?>index\.html$ /<?=$cur_path?>index.php
<?php }?>
<?php
$c=ob_get_contents();
dd_file_put('../.htaccess',$c);
ob_clean();
?>