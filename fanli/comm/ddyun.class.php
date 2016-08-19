<?php
class ddyun{
	function __construct(){
		$this->openurl=DD_YUN_URL.'/api/?';
	}
	
	function get_url($data){
		$url=$this->openurl.http_build_query($data);
		$a=dd_get($url);
		$a=json_decode($a,1);
		return $a['r'];
	}
}