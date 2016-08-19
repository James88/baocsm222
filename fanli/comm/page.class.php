<?php
//为了避免重复包含文件而造成错误，加了判断函数是否存在的条件：
if (!function_exists('pageft')) {
	//定义函数pageft(),三个参数的含义为：
	//$totle：信息总数；
	//$displaypg：每页显示信息数，这里设置为默认是20；
	//$url：分页导航中的链接，除了加入不同的查询信息“page”外的部分都与这个URL相同。
	//　　　默认值本该设为本页URL（即$_SERVER["REQUEST_URI"]），但设置默认值的右边只能为常量，所以该默认值设为空字符串，在函数内部再设置为本页URL。
	function pageft($totle, $displaypg = 20, $url = '',$wjt=0, $shownum = 1, $showtext = 1, $showselect = 0, $showlvtao = 7) {
		if(defined('ADMIN') && ADMIN==1 && $totle==0){
			return "暂无数据";
		}
		if(defined('ADMIN') && ADMIN==1){
			$showselect = 1;
		}
		$page = $_GET['page']?(int)$_GET['page']:1;
		
		if($wjt==0){
		    $url.='&page';
		}
		elseif($wjt==1){
		    $url=preg_replace('/\.html$/','',$url);
		}

		//页码计算：
		$lastpg = ceil($totle / $displaypg); //最后页，也是总页数
		$page = min($lastpg, $page);
		$prepg = $page -1; //上一页
		$nextpg = ($page == $lastpg ? 0 : $page +1); //下一页
		$firstcount = ($page -1) * $displaypg;

		//开始分页导航条代码：
		if ($showtext == 1) {
			$pagenav = "<span class='disabled'>" . ($totle ? ($firstcount +1) : 0) . "-" . min($firstcount + $displaypg, $totle) . "/$totle 记录</span><span class='disabled'>$page/$lastpg 页</span>";
		} else {
			$pagenav = "";
		}
		//如果只有一页则跳出函数：
		if ($lastpg <= 1)
			return false;

		if ($wjt == '1') {
			if ($prepg)
				$pagenav .= "<a href='$url-1.html'>首页</a>";
			else
				$pagenav .= "<a href='$url-1.html'>首页</a>";
			if ($prepg)
				$pagenav .= "<a href='$url-$prepg.html'><</a>";
			else
				$pagenav .= "<a href='$url-$prepg.html'><</a>";
		} else {
			if ($prepg)
				$pagenav .= "<a href='$url=1'>首页</a>";
			else
				$pagenav .= "<a href='$url=1'>首页</a>";
			if ($prepg)
				$pagenav .= "<a href='$url=$prepg'><</a>";
			else
				$pagenav .= "<a href='$url=$prepg'><</a>";
		}
		if ($shownum == 1) {
			$o = $showlvtao; //中间页码表总长度，为奇数
			$u = ceil($o / 2); //根据$o计算单侧页码宽度$u
			$f = $page - $u; //根据当前页$currentPage和单侧宽度$u计算出第一页的起始数字
			//str_replace('{p}',,$fn)//替换格式
			if ($f < 0) {
				$f = 0;
			} //当第一页小于0时，赋值为0
			$n = $lastpg; //总页数,20页
			if ($n < 1) {
				$n = 1;
			} //当总数小于1时，赋值为1
			if ($page == 1) {
				$pagenav .= '<span class="current">1</span>';
			} else {
				if ($wjt == '1') {
					$pagenav .= "<a href='$url-1.html'>1</a>";
				} else {
					$pagenav .= "<a href='$url=1'>1</a>";
				}
			}
			///////////////////////////////////////
			for ($i = 1; $i <= $o; $i++) {
				if ($n <= 1) {
					break;
				} //当总页数为1时
				$c = $f + $i; //从第$c开始累加计算
				if ($i == 1 && $c > 2) {
					$pagenav .= '...';
				}
				if ($c == 1) {
					continue;
				}
				if ($c == $n) {
					break;
				}
				if ($c == $page) {
					$pagenav .= '<span class="current">' . $page . '</span>';
				} else {
					if ($wjt == '1') {
						$pagenav .= "<a href='$url-$c.html'>$c</a>";
					} else {
						$pagenav .= "<a href='$url=$c'>$c</a>";
					}
				}
				if ($i == $o && $c < $n -1) {
					$pagenav .= '...';
				}
				if ($i > $n) {
					break;
				} //当总页数小于页码表长度时	
			}
			if ($page == $n && $n != 1) {
				$pagenav .= '<span class="current">' . $n . '</span>';
			} else {
				if ($wjt == '1') {
					$pagenav .= "<a href='$url-$n.html'>$n</a>";
				} else {
					$pagenav .= "<a href='$url=$n'>$n</a>";
				}
			}
		}

		if ($wjt == '1') {
			if ($nextpg)
				$pagenav .= "<a href='$url-$nextpg.html'>></a>";
			else
				$pagenav .= "<a href='$url-$nextpg.html'>></a>";
			if ($nextpg)
				$pagenav .= "<a href='$url-$lastpg.html'>尾页</a>";
			else
				$pagenav .= "<a href='$url-$lastpg.html'>尾页</a>";
			;
		} else {
			if ($nextpg)
				$pagenav .= "<a href='$url=$nextpg'>></a>";
			else
				$pagenav .= "<a href='$url=$nextpg'>></a>";
			if ($nextpg)
				$pagenav .= "<a href='$url=$lastpg'>尾页</a>";
			else
				$pagenav .= "<a href='$url=$lastpg'>尾页</a>";
			;
		}
		if ($showselect == 1) {
			//下拉跳转列表，循环列出所有页码：	
			if($lastpg>=25){
				$pagenav .= "跳至<select name='topage' size='1' onchange='window.location=\"$url=\"+this.value'>\n";
				$tempnav='';
				$temptag=0;
				for ($k = zhengshuzuixiaoling($page-10); $k <= $page+10; $k++) {
					if ($k == $page)
						$tempnav .= "<option value='$k' selected>$k</option>\n";
					else
						$tempnav .= "<option value='$k'>$k</option>\n";
				}
				for($k=11;$k<=$lastpg;$k++){
					if($k==$lastpg){
						if ($k == $page){
							$pagenav .= $tempnav;
							$temptag=1;
						}
						else{
							if($k>$page && $temptag==0){
								$pagenav=$pagenav.$tempnav;
								$temptag=1;
							}
							$pagenav .= "<option value='$k'>$k</option>\n";
						}
					}
				}
				
				$pagenav .= "</select>页";	
			}else{
				$pagenav .= "跳至<select name='topage' size='1' onchange='window.location=\"$url=\"+this.value'>\n";
				for ($i = 1; $i <= $lastpg; $i++) {
					if ($i == $page)
						$pagenav .= "<option value='$i' selected>$i</option>\n";
					else
						$pagenav .= "<option value='$i'>$i</option>\n";
				}
				$pagenav .= "</select>页";
			}
		}
		return $pagenav;
	}
	
	function zhengshuzuixiaoling($num){
		if($num<0){
			$num=1;
		}
		return $num;
	}
}
?>