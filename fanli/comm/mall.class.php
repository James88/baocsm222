<?php //多多
class mall{
	public $duoduo;
	public $table_name;
	public $fields;
	
	function __construct($duoduo){
		$this->duoduo=$duoduo;
		if(DDMALL==1){
			$this->table_name='mall';
		}
		else{
			$this->table_name='mall';
		}
		$table_struct=$duoduo->get_table_struct($this->table_name);
		$fields='';
		foreach($table_struct as $k=>$v){
			if($k!='content' && $k!='duoduo_table_index'){
				$fields.=$k.',';
			}
		}
		$this->fields=preg_replace('/,$/','',$fields);
	}
	
	function get_ddmall(){
		return defined('DDMALL')?DDMALL:0;
	}
	
	function get_table(){
		return $this->table_name;
	}
	
	function select($where,$total=0){
		if(defined('INDEX') && INDEX==1){
			if(strpos($where,'`edate`')===false){
				$where='`edate`>"'.strtotime(date('Ymd')).'" and '.$where;
			}
		}
		if(strpos($where,'`del`')===false){
			$where='`del`=0 and '.$where;
		}
		$data['data']=$this->duoduo->select_all($this->table_name,$this->fields,$where);
		foreach($data['data'] as $k=>$row){
			$data['data'][$k]=$this->do_item($row);
		}
		if($total==1){
			if(strpos($where,'order by')!==false){
				$where=trim(preg_replace('/order by.*/','',$where));
			}
			$total=$this->duoduo->count($this->table_name,$where);
			$data['total']=$total;
		}
		else{
			$data=$data['data'];
		}
		return $data;
	}
	
	function view($where){
		if(strpos($where,'=')!==false){
			$data=$this->duoduo->select($this->table_name,'*',$where);
		}
		elseif(is_numeric($where)){
			$data=$this->duoduo->select($this->table_name,'*','id="'.$where.'"');
		}
		else{
			$data=$this->duoduo->select($this->table_name,'*','domain="'.$where.'"');
		}
		return $data;
	}
	
	function update_sort($id,$sort){
		$this->duoduo->update_sort($id,$sort,$this->table_name);
	}
	
	function do_item($item){
		if(isset($item['sort']) && $item['sort']==DEFAULT_SORT){
			$item['sort']='——';
		}
		$item['jump']=l('jump','mall',array('mid'=>$item['id']));
		$item['view_jump']=l('mall','view',array('id'=>$item['id'],'jump'=>1));
		$item['view']=u('mall','view',array('id'=>$item['id']));
		return $item;
	}
	
	function index($num,$mall=array()){
		$where='1=1 order by sort=0 asc,sort asc,id desc limit '.$num;
		$a=$this->select($where);
		if(!empty($mall)){
			$b[]=$mall;
			$malls=array_merge($b,$a);
		}
		else{
			$malls=$a;
		}
		return $malls;
	}
	
	function malls_pinyin(){
		$malls[0]='全部';
		$sql="select id,title,pinyin from ".BIAOTOU.$this->table_name." order by pinyin asc";
		$query=$this->duoduo->query($sql);
		while($arr=$this->duoduo->fetch_array($query)){
			$malls2[$arr['id']]='('.substr($arr['pinyin'],0,1).')'.$arr['title'];
		}
		if(!empty($malls2)){
			$malls=$malls+$malls2;
		}
		
		return $malls;
	}
	
	function count($where='1'){
		return $this->duoduo->count($this->table_name,$where);
	}
}