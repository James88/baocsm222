<?php //多多
class zhidemai{
	public $duoduo;
	public $table_name='ddzhidemai';
	public $cat;
	public $auditor_word='——';
	
	function __construct($duoduo){
		$this->duoduo=$duoduo;
	}
	
	function show($pagesize,$page=1,$field='*',$where="1=1",$order_by='sort asc,starttime desc'){
		if($order_by==''){$order_by='sort asc,starttime desc';}
		$frmnum=($page-1)*$pagesize;
		if($where=='1=1' || $where=='' || $where=='1'){
			$where='`del`=0';
		}
		elseif(strpos($where,'`del`')!==false){
			$where=$where;
		}
		else{
			$where=$where.' and `del`=0';
		}
		if(define('INDEX') && INDEX==1){
			$where.=' and starttime<"'.TIME.'" and endtime>"'.TIME.'"';
		}
		
		$a=$this->duoduo->select_all($this->table_name,$field,$where.' order by '.$order_by.' limit '.$frmnum.','.$pagesize);
		foreach($a as $k=>$row){
			$a[$k]=$this->do_item($row);
		}
		return $a;
	}
	
	function total($where){
		if($where=='1=1' || $where=='' || $where=='1'){
			$where='`del`=0';
		}
		elseif(strpos($where,'`del`')!==false){
			$where=$where;
		}
		else{
			$where=$where.' and `del`=0';
		}
		if(define('INDEX') && INDEX==1){
			$where.=' and starttime<"'.TIME.'" and endtime>"'.TIME.'"';
		}
		return (float)$this->duoduo->count($this->table_name,$where);
	}
	
	function do_item($item){
		if(isset($item['top'])){
			$item['top']=$item['top']==1?'是':'否';
		}
		/*if(isset($item['uid'])){
			$item['ddusername']=$this->get_ddusername($item['uid']);
		}*/
		if(isset($item['username'])){
			$item['ddusername']=$item['username'];
		}
		if(isset($item['url'])){
			if($item['web']==1){
				$a=$this->get_mall($item['url']);
				$item['mallname']=$a['title'];
				$item['mallurl']=u('mall','view',array('id'=>$a['id']));
			}
			elseif($item['web']==2){
				$item['mallname']='淘宝';
				$item['mallurl']='';
			}
			elseif($item['web']==3){
				$item['mallname']='拍拍';
				$item['mallurl']='';
			}
		}
		if($item['ddusername']!='' && INDEX==1){
			$item['ddusername']=utf_substr($item['ddusername'],3).'**';
		}
		if(defined('ADMIN') && ADMIN==1 && $item['ddusername']==''){
			$item['ddusername']='——';
		}
		if(isset($item['sort']) && $item['sort']==DEFAULT_SORT){
			$item['sort']='——';
		}
		if(isset($item['cid'])){
			$item['catname']=$this->catname($item['cid']);
			$item['caturl']=u('zhidemai','index',array('cid'=>$item['cid']));
		}
		if(isset($item['shuxing'])){
			$s=$this->shuxing($item['shuxing']);
			$item['shuxing_id']=$item['shuxing'];
			$item['shuxing']=$s['shuxing'];
			$item['shuxing_class']=$s['class'];
			
		}
		if(defined('ADMIN') && ADMIN==1 && $item['auditor']==''){$item['auditor']=$this->auditor_word;}
		
		if(isset($item['starttime']) && $item['starttime']>0){
			$item['starttime']=date('Y-m-d H:i:s',$item['starttime']);
		}
		if(isset($item['endtime']) && $item['endtime']>0){
			$item['endtime']=date('Y-m-d H:i:s',$item['endtime']);
		}
		if(isset($item['addtime']) && $item['addtime']>0){
			$item['addtime']=date('Y-m-d H:i:s',$item['addtime']);
		}
		
		$item['jump']=l('zhidemai','jump',array('id'=>$item['id']));
		$item['view_jump']=l('zhidemai','view',array('id'=>$item['id'],'jump'=>1));
		$item['view']=u('zhidemai','view',array('id'=>$item['id']));
		return $item;
	}

	function admin_list($pagesize=20,$where='',$order_by='sort asc,id desc'){
		$a=$this->duoduo->get_table_struct($this->table_name);
		foreach($a as $k=>$v){
			if($k!='duoduo_table_index' && $k!='content'){
				$b[]=$k;
			}
		}
		$page=(int)$_GET['page'];
		if($page==0) $page=1;
		$re['total']=$this->total($where);
		$re['data']=$this->show($pagesize,$page,implode(',',$b),$where,$order_by);
		return $re;
	}
	
	function top(){
		$a=$this->show(1,1,'id,title,subtitle','top=1 and starttime<="'.TIME.'" and (endtime=0 or endtime>"'.TIME.'")');
		return $a[0];
	}
	
	function hot($pagesize){ //取最近的50个商品，再按照顶排序
		$a=$this->show($pagesize,1,'id,title,img,ding','starttime<="'.TIME.'" and (endtime=0 or endtime>"'.TIME.'")','id desc',50);
		$count=count($a);
		for($i=0;$i<$count;$i++){
			for ($j = $count - 1; $j > $i ; $j--) {
            	// 相邻两个数比较
				if ($a[$j]['ding'] > $a[$j-1]['ding']) {
					// 暂存较小的数
					$iTemp = $a[$j-1];
					// 把较大的放前面
					$a[$j-1] = $a[$j];
					// 较小的放后面
					$a[$j] = $iTemp;
				}
			}
		}
		return array_slice($a, 0, $pagesize, true);
	}
	
	function index_list($pagesize=20,$page=1,$where='',$total=0){
		if($where==''){$where='1=1';}
		$where.=' and starttime<="'.TIME.'" and (endtime=0 or endtime>"'.TIME.'")';
		if($total==1){
			$re['total']=$re['total']=$this->total($where);
			$re['data']=$this->show($pagesize,$page,'*',$where);
		}
		else{
			$re['data']=$this->show($pagesize,$page,'*',$where);
		}
		return $re;
	}
	
	function around($id){
		$data['last_zdm']=$this->view('id<"'.$id.'" order by id desc',0);
		$data['next_zdm']=$this->view('id>"'.$id.'" order by id asc',0);
		return $data;
	}

	function catname($cid=''){
		if($cid>0){
			if($this->cat==''){
				$this->cat=include(DDROOT.'/data/ddgoods.php');
			}
			$re=$this->cat['cat']['zhidemai'][$cid];
		}
		else{
			$this->cat=include(DDROOT.'/data/ddgoods.php');
			$re=$this->cat['cat']['zhidemai'];
			$re=array(''=>'全部')+$re;
		}
		return $re;
	}
	
	function update_sort($id,$sort){
		$this->duoduo->update_sort($id,$sort,$this->table_name);
	}
	
	function get_ddusername($uid){
		return $this->duoduo->select('user','ddusername','id="'.$uid.'"');
	}
	
	function get_mall($url){
		$domain=get_domain($url);
		return $this->duoduo->select(get_mall_table_name(),'title,id','domain="'.$domain.'"');
	}
	
	function status($status=''){
		if(is_numeric($status)){
			if($this->cat==''){
				$this->cat=include(DDROOT.'/data/ddgoods.php');
			}
			$re=$this->cat['status'][$status];
		}
		else{
			$this->cat=include(DDROOT.'/data/ddgoods.php');
			$re=$this->cat['status'];
			foreach($re as $k=>$v){
				$re[$k]=strip_tags($v);
			}
		}
		return $re;
	}
	
	function shuxing($shuxing=''){
		$a=array(0=>'无','1'=>'全网最低','2'=>'历史新低');
		$c=array('1'=>'lowest-network','2'=>'record-low');
		if($shuxing==''){
			$re=$a;
		}
		else{
			$re=array('shuxing_id'=>$shuxing,'shuxing'=>$a[$shuxing],'class'=>$c[$shuxing]);
		}
		return $re;
	}
	
	function vote($data_id,$uid,$type){
		$data_id=(int)$data_id;
		$uid=(int)$uid;
		$type=(int)$type;
		if($type==1){$f='ding';}else{$f='cai';}
		if($uid==0){
			$re=array('s'=>0,'r'=>'会员没有登录');
		}
		elseif($data_id==0 || ($type!=1 && $type!=0)){
			$re=array('s'=>0,'r'=>'数据错误');
		}
		else{
			$vote=$this->duoduo->select('ddzhidemai_vote','id,type','uid="'.$uid.'" and data_id="'.$data_id.'"');
			if($vote['id']>0){
				
				if($vote['type']==-1){ //如果当前是无效投票数据
					$update_data=array('type'=>$type);
					$update_ddzhidemai=array('f'=>$f,'v'=>1,'e'=>'+');
					$r=1;
				}
				elseif($vote['type']==1){ //如果原数据是顶
					if($type==1){ //行为是顶，重置
						$update_data=array('type'=>-1);
						$r=-1;
						$update_ddzhidemai=array('f'=>'ding','v'=>1,'e'=>'-');
					}
					else{ //行为是踩，提示错误
						$re=array('s'=>0,'r'=>'您已经投过票了');
					}
				}
				else{ //如果原数据是踩
					if($type==0){ //行为是踩，重置
						$update_data=array('type'=>-1);
						$r=-1;
						$update_ddzhidemai=array('f'=>'cai','v'=>1,'e'=>'-');
					}
					else{ //行为是顶，提示错误
						$re=array('s'=>0,'r'=>'您已经投过票了');
					}
				}
				
				$this->duoduo->update('ddzhidemai_vote',$update_data,'id="'.$vote['id'].'"');
				
				if(!isset($re)){
					$re=array('s'=>1,'r'=>$r);
				}
				
			}
			else{
				$data=array('data_id'=>$data_id,'uid'=>$uid,'addtime'=>TIME,'type'=>$type);
				$this->duoduo->insert('ddzhidemai_vote',$data);
				$update_ddzhidemai=array('f'=>$f,'e'=>'+','v'=>1);
				$re=array('s'=>1,'r'=>1);
			}
			$this->duoduo->update('ddzhidemai',$update_ddzhidemai,'id="'.$data_id.'"');
		}
		return $re;
	}
	
	function comment_list($data_id=0,$uid=0){
		$data_id=$this->duoduo->select('ddzhidemai','data_id','id="'.$data_id.'"');
		$where='1=1';
		if($data_id>0){
			$where.=' and data_id="'.$data_id.'"';
		}
		if($uid>0){
			$where.=' and uid="'.$uid.'"';
		}
		$comment=$this->duoduo->select_all('ddzhidemai_comment','*',$where.' order by id desc');
		foreach($comment as $k=>$row){
			$comment[$k]['addtime']=date('Y-m-d H:i:s',$row['addtime']);
		}
		return $comment;
	}
	
	function comment_sub($data_id,$uid,$username,$comment){
		$data_id=$this->duoduo->select('ddzhidemai','data_id','id="'.$data_id.'"');
		$username=strip_tags(trim($username));
		$comment=strip_tags(trim($comment));
		if($uid==0){
			$re=array('s'=>0,'r'=>'会员没有登录');
		}
		elseif($data_id==0){
			$re=array('s'=>0,'r'=>'数据错误');
		}
		elseif($comment==''){
			$re=array('s'=>0,'r'=>'评论内容不能为空');
		}
		elseif(str_utf8_mix_word_count($comment)>140){
			$re=array('s'=>0,'r'=>'评论字数不能大于140个字');
		}
		/*elseif(TIME-$this->duoduo->select('ddzhidemai_comment','addtime','uid="'.$uid.'"')<600){
			$re=array('s'=>0,'r'=>'过一会再来评论吧');
		}*/
		else{
			$data=array('data_id'=>$data_id,'content'=>$comment,'addtime'=>TIME,'uid'=>$uid,'username'=>$username);
			$post=$data;
			unset($post['uid']);
			$post['ddurl']=URL;
			$this->duoduo->insert('ddzhidemai_comment',$data);
			$data=array('f'=>'pinglun','e'=>'+','v'=>1);
			$this->duoduo->update('ddzhidemai',$data,'data_id="'.$data_id.'"');
        	$re=array('s'=>1);
			
			$url=DD_U_URL.'/index.php?m=DdApi&a=zhidemai_comment&key='.md5(DDYUNKEY);
			$this->post($url,$post);
		}
		return $re;
	}
	
	function post($url, $arr) {
		$context['http'] = array ('timeout' => 5);
		$context['http']['method'] = 'POST';
		$context['http']['content'] = http_build_query($arr);
		$output = file_get_contents($url, false, stream_context_create($context));
		return $output;
	}
	
	function view($id,$get_comment=1){
		if(is_numeric($id)){
			$where=' and id="'.$id.'"';
		}
		else{
			$where=' and '.$id;
		}
		$zhidemai=$this->duoduo->select($this->table_name,'*','`del`=0 and (endtime=0 or endtime>"'.TIME.'")'.$where);
		$zhidemai=$this->do_item($zhidemai);
		if($zhidemai['id']>0 && $get_comment==1){
			$data['comment']=$this->duoduo->select('ddzhidemai_comment','*','data_id="'.$id.'"');
			$data['zhidemai']=$zhidemai;
		}
		else{
			$data=$zhidemai;
		}
		return $data;
	}
	
	function jump($id){
		$duoduo=$this->duoduo;
		$zhidemai=$duoduo->select($this->table_name,'web,url,uid','id="'.$id.'"');
		$web=$zhidemai['web'];
		$url=$zhidemai['url'];
		$uid=$zhidemai['uid'];
		if($web==1){
			$domain=get_domain($url);
			$chong_mall_url=include(DDROOT.'/data/chong_mall_url.php');
			foreach($chong_mall_url as $vo){
				if($vo['type']==1){
					if(strpos($url,$vo['host'])!==false){
						$mall_id=(int)$duoduo->select(get_mall_table_name(),'id','url like "%'.$vo['host'].'%"');
					}
				}elseif($vo['type']==0){
					if(strpos($url,get_domain($vo['host']))!==false){
						$mall_id=(int)$duoduo->select(get_mall_table_name(),'id','url like "%'.$vo['host'].'%"');
					}
				}
				if($mall_id){
					break;
				}
			}
			if(empty($mall_id)){
				$mall_id=(int)$duoduo->select(get_mall_table_name(),'id','domain="'.$domain.'"');
			}
			
			if($mall_id==0){exit('商城不存在');}
			$jump_url=u('jump','mall',array('mid'=>$mall_id,'url'=>$url));
		}
		elseif($web==2){
			$goods_id=(float)get_tao_id($url);
			$jump_url=u('jump','goods',array('iid'=>$goods_id));
		}
		elseif($web==3){
			include(DDROOT.'/comm/paipai.class.php');
			$paipai=new paipai($dduser,array());
			$goods_id=$paipai->url2commId($url);
			$jump_url=u('jump','paipaigoods',array('commId'=>$goods_id));
		}
		else{
			error_html('缺少web参数');
		}
		if($uid>0){
			if($web==1){ //商城类型，反馈标签记录推广人
				$jump_url.='&code='.urlencode('zdm|'.$uid.'|'.$id);
			}
			elseif($web==2 || $web==3){ //淘宝类型，记录浏览日志
				$data=array('fuid'=>$uid,'mall'=>$web,'code'=>'zdm','shuju_id'=>$id,'goods_id'=>$goods_id);
				$jump_url.='&'.http_build_query($data);
				//$this->duoduo->ddtuiguang_insert($data);
			}
		}
		return $jump_url;
	}
}