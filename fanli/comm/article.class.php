<?php //多多
class article{
	public $duoduo;
	public $table_name;
	public $fields;
	
	function __construct($duoduo){
		$this->duoduo=$duoduo;
		
		$this->table_name='article';
	}
	
	function select_all($where,$total=0,$field){
		if(strpos($where,'`del`')===false){
			$where='`del`=0 and '.$where;
		}
		$data['data']=$this->duoduo->select_all($this->table_name,$field,$where);
		
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
	
	function select($where,$field){
		if(strpos($where,'`del`')===false){
			$where='`del`=0 and '.$where;
		}
		$data=$this->duoduo->select($this->table_name,$field,$where);
		if($data['content']!=''){
			$data['content']=dd_tag_replace($data['content']);
		}
		return $data;
	}
	
	function update($where,$data){
		$this->duoduo->update('article',$data,$where);
	}
	
	function next_last($id){
		$data['last_article']=$this->select('id<"'.$id.'" and del=0 order by id desc','id,title');
		$data['next_article']=$this->select('id>"'.$id.'" and del=0  order by id asc','id,title');
		return $data;
	}
	
	function hotnews($limit){
		return $this->select_all('1 order by sort=0 asc, sort asc limit 0,'.$limit,'0','id,title');
	}
	
	function do_item($item){
		if(isset($item['sort']) && $item['sort']==DEFAULT_SORT){
			$item['sort']='——';
		}
		if(isset($item['content']) && $item['content']!=''){
			$item['content']=dd_tag_replace($item['content']);
		}
		return $item;
	}
}