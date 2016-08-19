<?php
class phpLock{
	private $path = '';
	private $del=true;
	
    public function phpLock($name, $path = '') {
		if($path==''){$path=dirname(__FILE__) .'/lock/';}
		$this->path = $path . $name . '.lock';
		if(file_exists($this->path)){
			$this->del=false;
	        exit('该进程已被占用');
        }
        else{
            file_put_contents($this->path,1);
			register_shutdown_function(array(&$this,'php_over')); //处理页面终止时
        }
	}
	
	public function php_over(){
		if($this->del==true){
	        unlink($this->path);
		}
	}
}
?>
<?php
/*class phpLock {
	//文件锁存放路径
	private $path = null;
	//文件句柄
	private $fp = null;
	//cache key
	private $name;
	//是否存在eaccelerator标志
	private $eAccelerator = false;
	
	private $del=true;

	 
	public function __construct($name, $path = '') {
		//判断是否存在eAccelerator,这里启用了eAccelerator之后可以进行内存锁提高效率
		if($path==''){$path=dirname(__FILE__) .'/lock/';}
		$this->eAccelerator = function_exists("eaccelerator_lock");
		if (!$this->eAccelerator) {
			$this->path = $path . $name . '.lock';
		}
		$this->name = $name;
		$this->lock();
	}

	public function __destruct() {
		if (!$this->eAccelerator) {
			if ($this->fp !== false) {
				flock($this->fp, LOCK_UN);
				clearstatcache();
			}
			//进行关闭
			fclose($this->fp);
			if($this->del==true){
				file_put_contents(DDROOT.'/data/lock/a.txt',1);
			    unlink($this->path);
			}
		} else {
			eaccelerator_unlock($this->name);
		}
	}
	 
	public function lock() {
		//如果无法开启ea内存锁，则开启文件锁
		if (!$this->eAccelerator) {
			//配置目录权限可写
			$this->fp = fopen($this->path, 'w+');
			if ($this->fp === false) {
				return false;
			}
			$lock = flock($this->fp, LOCK_EX + LOCK_NB);
			if ($lock == 1) {
				return 1;
			} else {
				$this->del=false;
				exit ('该进程已被占用');
			}
		} else {
			return eaccelerator_lock($this->name);
		}
	}
 
	public function unlock() {
		if (!$this->eAccelerator) {
			if ($this->fp !== false) {
				flock($this->fp, LOCK_UN);
				clearstatcache();
			}
			//进行关闭
			fclose($this->fp);
		} else {
			return eaccelerator_unlock($this->name);
		}
	}
}*/

//$lock = new CacheLock('key_name');
//for ($i = 0; $i < 2; $i++) {
//	echo str_repeat(" ", 1024); //照顾一下像Firefox这种有比较大的缓冲区的浏览器
//	echo $i . "<br>\n";
//	flush();
//	sleep(5);
//}
//$lock->unlock();
//使用过程中需要注意下文件锁所在路径需要有写权限.
?>