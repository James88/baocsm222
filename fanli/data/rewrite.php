<?php //多多
return array (
	'mall' => array (
		'index' => array (
			array (
				'a' => '-(.*)-(\d+).html',
				'b' => 'cid=$1&page=$2'
			),
			array (
				'a' => '-(.*).html',
				'b' => 'cid=$1'
			),
			array (
				'a' => '.html',
				'b' => ''
			),
		),
		'view' => array (
			array (
				'a' => '-(\d+)-(.*)-(\d+).html',
				'b' => 'id=$1&do=$2&page=$3'
			),
			array (
				'a' => '-(\d+)-(.*).html',
				'b' => 'id=$1&do=$2'
			),
			array (
				'a' => '-(\d+).html',
				'b' => 'id=$1'
			),
		),
		'goods' => array (
			array (
				'a' => '-(.*)-(\d+)-(\d+)-(\d+)-(\d+)-(.*)-(\d+).html',
				'b' => 'merchantId=$1&order=$2&start_price=$3&end_price=$4&list=$5&q=$6&page=$7'
			),
			array (
				'a' => '-(.*).html',
				'b' => 'q=$1'
			),
			array (
				'a' => '.html',
				'b' => ''
			),
		),
	),
	'article' => array (
		'index' => array (
			array (
				'a' => '.html',
				'b' => ''
			),
		),
		'list' => array (
			array (
				'a' => '-(.*)-(\d+).html',
				'b' => 'cid=$1&page=$2'
			),
			array (
				'a' => '-(.*).html',
				'b' => 'cid=$1'
			),
			array (
				'a' => '.html',
				'b' => ''
			),
		),
		'view' => array (
			array (
				'a' => '-(\d+).html',
				'b' => 'id=$1'
			),
		),
	),
	'huan' => array (
		'list' => array (
			array (
				'a' => '-(\d+)-(\d+).html',
				'b' => 'cid=$1&page=$2'
			),
			array (
				'a' => '-(\d+).html',
				'b' => 'cid=$1'
			),
			array (
				'a' => '.html',
				'b' => ''
			),
		),
		'view' => array (
			array (
				'a' => '-(\d+).html',
				'b' => 'id=$1'
			),
		),
	),
	'tao' => array (
		'index' => array (
			array (
				'a' => '.html',
				'b' => ''
			),
		),
		'view' => array (
			array (
				'a' => '-(.*)-(.*)-(.*).html',
				'b' => 'iid=$1&promotion_price=$2&promotion_endtime=$3'
			),
			array (
				'a' => '-(.*).html',
				'b' => 'iid=$1'
			),
		),
	),
	'goods' => array (
		'index' => array (
			array (
				'a' => '-(.*)-(\d+)-(.*)-(\d+).html',
				'b' => 'code=$1&cid=$2&do=$3&page=$4'
			),
			array (
				'a' => '-(.*)-(\d+)-(\d+).html',
				'b' => 'code=$1&cid=$2&page=$3'
			),
			array (
				'a' => '-(.*)-(\d+)-(.*).html',
				'b' => 'code=$1&cid=$2&do=$3'
			),
			array (
				'a' => '-(.*)-(\d+).html',
				'b' => 'code=$1&cid=$2'
			),
			array (
				'a' => '-(.*)-(.*).html',
				'b' => 'code=$1&do=$2'
			),
			array (
				'a' => '-(\d+).html',
				'b' => 'cid=$1'
			),
			array (
				'a' => '-(.*).html',
				'b' => 'code=$1'
			),
			array (
				'a' => '.html',
				'b' => ''
			),
		),
		'view' => array (
			array (
				'a' => '-(.*)-(.*).html',
				'b' => 'code=$1&id=$2'
			),
			array (
				'a' => '-(.*).html',
				'b' => 'id=$1'
			),
		),
	),
	'baobei' => array (
		'list' => array (
			array (
				'a' => '-(.*)-(\d+)-(.*)-(\d+).html',
				'b' => 'sort=$1&cid=$2&q=$3&page=$4'
			),
			array (
				'a' => '-(\d+)-(\d+).html',
				'b' => 'cid=$1&page=$2'
			),
			array (
				'a' => '-(\d+)-(.*).html',
				'b' => 'cid=$1&q=$2'
			),
			array (
				'a' => '-(\d+).html',
				'b' => 'cid=$1'
			),
			array (
				'a' => '.html',
				'b' => ''
			),
		),
		'user' => array (
			array (
				'a' => '-(\d+)-(\d+)-(\d+).html',
				'b' => 'uid=$1&xs=$2&page=$3'
			),
			array (
				'a' => '-(\d+)-(\d+).html',
				'b' => 'uid=$1&xs=$2'
			),
			array (
				'a' => '-(\d+).html',
				'b' => 'uid=$1'
			),
		),
		'view' => array (
			array (
				'a' => '-(\d+).html',
				'b' => 'id=$1'
			),
		),
	),
	'help' => array (
		'index' => array (
			array (
				'a' => '-(\d+).html',
				'b' => 'cid=$1'
			),
			array (
				'a' => '.html',
				'b' => ''
			),
		),

	),
	'about' => array (
		'index' => array (
			array (
				'a' => '-(\d+).html',
				'b' => 'id=$1'
			),
			array (
				'a' => '.html',
				'b' => ''
			),
		),
	),
	'sitemap' => array (
		'index' => array (
			array (
				'a' => '.html',
				'b' => ''
			),

		),
	),
	'paipai' => array (
		'index' => array (
			array (
				'a' => '.html',
				'b' => ''
			),

		),
		'list' => array (
			array (
				'a' => '-(\d+)-(.*)-(\d+)-(.*)-(\d+)-(\d+)-(\d+)-(\d+).html',
				'b' => 'cid=$1&q=$2&sort=$3&property=$4&begPrice=$5&endPrice=$6&list=$7&page=$8'
			),
			array (
				'a' => '-(.*).html',
				'b' => 'q=$1'
			),
			array (
				'a' => '.html',
				'b' => ''
			),
		),
	),
	'task' => array (
		'index' => array (
			array (
				'a' => '.html',
				'b' => ''
			),
		),
	),
	'qita' => array (
		'qita' => array (
			array (
				'a' => 'tbimg/(.*).jpg',
				'b' => 'comm/showpic.php?pic=$1',
			),
			array (
				'a' => 'plugin/(.*).html',
				'b' => 'plugin.php?plugin_query=$1',
			),
			array (
				'a' => 'index.html',
				'b' => 'index.php',
			),
		)
	),
);
?>