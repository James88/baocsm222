<?php //多多
class rewrite {
	public $n = 0;
	public $is_plugin = 0;
	public $cur_path='';
	
	function __construct(){
		$cur_path=str_replace('data/rewrite/php/'.filename(),'',$_SERVER['SCRIPT_NAME']);
		$cur_path=preg_replace('#^/#','',$cur_path);
		$this->cur_path=$cur_path;
	}
	
	function replace($a,$fuhao){
		return preg_replace('/\\'.$fuhao.'([a-zA-Z0-9])/','\\'.$fuhao.'\1',$a);
	}

	function guize($a, $b, $type) {
		$a = $this->cur_path . $a;
		$b = $this->cur_path . $b;
		switch ($type) {
			case 'htaccess' :
				$a = 'RewriteRule ^' . $this->replace($a,'.') . '$ ';
				$b = '/' . $this->replace($b,'?');
				$str = $a . ' ' . $b.' [L,NC]';
				break;

			case 'httpd' :
				$a = 'RewriteRule ^/' . $a . '$';
				$a = $this->replace($a,'.');
				$b = $this->replace($b,'?');
				$b = '/' . $this->replace($b,'.');
				$str = $a . ' ' . $b;
				break;

			case 'lighttpd';
				$a = '"/' . $a . '$"';
				$b = '"' . $b . '",';
				$str = $a . ' => ' . $b;
				break;

			case 'nginx';
				$a = 'rewrite /' . $a . '$';
				$b = '/' . $b . ' last;';
				$str = $a . ' ' . $b;
				break;

			case 'web_config';
				$this->n++;
				$str = '<rule name="Imported Rule ' . $this->n . '">' . "\r\n";
				$str .= '<match url="^' . $a . '$" ignoreCase="false" />' . "\r\n";
				$b = str_replace('&', '&amp;', $b);
				$b = preg_replace('#\$(\d)#', '{R:\1}', $b);
				$str .= '<action type="Rewrite" url="' . $b . '" />' . "\r\n";
				$str .= "</rule>\r\n";
				break;
		}
		return $str . "\r\n";
	}

	function run($guize) {
		$str='';

		$plugin_rewrite_arr=dd_glob(DDROOT.'/plugin/rewrite/'); //兼容老版本
		foreach($plugin_rewrite_arr as $v){
			$b=include($v);
			$str= $str.$this->loop($b,$guize);
		}
		
		$plugin=glob(DDROOT.'/plugin/*');
		foreach($plugin as $v){
			if(is_dir($v) && file_exists($v.'/set.php')){
				$set=include($v.'/set.php');
				if($set['rewrite']==1){
					$b=include($v.'/rewrite.php');
					$str= $str.$this->loop($b,$guize);
				}
			}
		}

		$a=include(DDROOT.'/data/rewrite.php');
		$str= $str.$this->loop($a,$guize);
		
		return $str;
	}
	
	function loop($a,$guize){
		$str = '';
		$alias=dd_get_cache('alias');
		foreach ($a as $dmod => $row) {
			$m=0;
			foreach ($row as $dact => $arr) {
				if($m==0){
					if($dact=='is_plugin'){
						$this->plugin=1;
						$m++;
						continue;
					}
					else{
						$this->plugin=0;
					}
				}

				$m++;

				foreach ($arr as $shuzu) {
					if(isset($alias[$dmod.'/'.$dact][0])){
						$dmod_zdy=$alias[$dmod.'/'.$dact][0];
					}
					else{
						$dmod_zdy=$dmod;
					}
					if(isset($alias[$dmod.'/'.$dact][1])){
						$dact_zdy=$alias[$dmod.'/'.$dact][1];
					}
					else{
						$dact_zdy=$dact;
					}

					if ($dmod=='qita' && $dact=='qita') {
						$str .= $this->guize($shuzu['a'], $shuzu['b'], $guize);
					} else {
						if ($shuzu['b'] != '') {
							$shuzu['b'] = '&' . $shuzu['b'];
						}
						if($this->plugin==1){
							$root_php='plugin';
						}
						else{
							$root_php='index';
						}
						$str .= $this->guize($dmod_zdy . '/' . $dact_zdy . $shuzu['a'], $root_php.'.php?mod=' . $dmod . '&act=' . $dact . $shuzu['b'], $guize);
						if ($dmod !== 'index' && $dact == 'index' && $shuzu['a']=='.html' && $shuzu['b']=='') { //根目录文件夹访问，规则带有“/”和不带“/”
							$str .= $this->guize($dmod_zdy . '/', $root_php.'.php?mod=' . $dmod . '&act=' . $dact . $shuzu['b'], $guize);
							$str .= $this->guize($dmod_zdy, $root_php.'.php?mod=' . $dmod . '&act=' . $dact . $shuzu['b'], $guize);
						}
					}
				}
			}
		}
		return $str;
	}
}
?>