<?php //多多
class goods{
	public $duoduo;
	private $webset;
	private $dduser;
	public $table_name='goods';
	public $cat;
	public $auditor_word='——';
	public $quanju=0;//设置1时显示全局商品
	public $bankuai;
	public $domain;
	
	function __construct($duoduo){
		$this->duoduo=$duoduo;
		$this->webset=$duoduo->webset;
		$this->dduser=$duoduo->dduser;
	}
	
	function show($pagesize,$page=1,$field='*',$where="1=1",$order_by){
		if($_GET['do']=='yugao'){
			$order_by='endtime asc,id desc';
		}
		if($order_by==''){
			$order_by='starttime desc,id desc';
		}
		$frmnum=($page-1)*$pagesize;
		if($where==''){
			$where="1=1";
		}
		if(strpos($where,'`del`')===false){
			$where.=' and `del`=0';
		}
		
		$where.=" and (top_stime<=".time()." or top_stime=0) and (top_etime>=".time()." or top_etime=0)";
		if($_GET['do']=='yulan'){
			$leixing=$_GET['leixing'];
			$j_time=strtotime(date('Y-m-d 00:00:00',TIME));
			$w_time=strtotime(date('Y-m-d 23:59:59',TIME));
			if($leixing==1){
				$where.=" and starttime>='".$j_time."' and starttime<='".TIME."'";
			}
			if($leixing==3){
				$where.=" and starttime>='".($j_time+3600*24)."' and starttime<='".($w_time+3600*24)."'";
			}
			$order_by="sort=0 asc,sort asc,id desc";//预览功能
		}
		if($this->quanju==1&&$page==1){
			$where.=" and top<>2 ";
			$order_by=" order by top DESC,".$order_by;
		}else{
			$order_by=" order by top=1 DESC,".$order_by;
		}
		$a=$this->duoduo->select_all($this->table_name,$field,$where.$order_by.',id desc limit '.$frmnum.','.$pagesize);
		$goods_attribute_arr=$this->duoduo->select_all('goods_attribute','*','1 ORDER BY sort ASC');
		if(!empty($this->bankuai)&&$this->bankuai['fenlei']==1){
			$type=$this->duoduo->select_all('type','id,title',"tag='goods'");
			foreach($type as $vo){
				$goods_type[$vo['id']]=$vo['title'];
			}
		}else{
			$goods_type=array();
		}
		foreach($a as $k=>$row){
			$a[$k]=$this->do_item($row,$goods_attribute_arr,$goods_type);//属性只需要查一次
		}
		//获取全局商品
		if($this->quanju==1&&$page==1){
			$top_data=$this->duoduo->select_all($this->table_name,$field,' (top_stime<='.time().' or top_stime=0) and (top_etime>='.time().' or top_etime=0) and `del`=0 and top=2 '.$order_by);
			if(is_array($top_data)){
				foreach($top_data as $k=>$row){
					$top_data[$k]=$this->do_item($row,$goods_attribute_arr,$goods_type);//属性只需要查一次
				}
				$a=array_merge($top_data,(array)$a);
			}
		}
		$a=$this->get_shoucang($a);
		return $a;
	}
	
	function get_shoucang($a){
		$dduser=$this->dduser;
		if($dduser['id']>0){
			$where_goods_id='';
			$where_data_id='';
			
			foreach($a as $key=> $row){
				if($row['id']){
					$where_goods_id.='"'.$row['id'].'",';
				}
				elseif($row['data_id']){	
					$where_data_id.='"'.$row['data_id'].'",';
				}
			}
			
			$where_goods_id=str_del_last($where_goods_id);
			$where_data_id=str_del_last($where_data_id);
			
			if($where_goods_id!=''){
				$shoucang_id_arr=$this->duoduo->select_all('record_goods','goods_id','uid="'.$dduser['id'].'" and goods_id in('.$where_goods_id.') and type=2');
			}
			if($where_data_id!=''){
				$shoucang_data_id_arr=$this->duoduo->select_all('record_goods','data_id','uid="'.$dduser['id'].'" and data_id in('.$where_data_id.') and type=2');
			}

			foreach($shoucang_id_arr as $k=>$row){
				$_shoucang_id_arr['a'.$row['goods_id']]=1;
			}
			foreach($shoucang_data_id_arr as $k=>$row){
				$_shoucang_data_id_arr['a'.$row['data_id']]=1;
			}

			foreach($a as $key=>$row){
				if($row['id']){
					if($_shoucang_id_arr['a'.$row['id']]==1){
						$a[$key]['is_shoucang']=1;
					}
					else{
						$a[$key]['is_shoucang']=0;
					}
				}
				elseif($row['data_id']){
					if($_shoucang_data_id_arr['a'.$row['data_id']]==1){
						$a[$key]['is_shoucang']=1;
					}
					else{
						$a[$key]['is_shoucang']=0;
					}
				}
			}
		}
		return $a;
	}
	
	//获取单个商品
	function good($id,$field="*",$where){
		$where=" del=0 ".$where;
		if($id){
			$where.=" and id=".(int)$id;
		}
		$good=$this->duoduo->select($this->table_name,$field,$where);
		if(empty($good)){
			return ;
		}
		$goods_attribute_arr=$this->duoduo->select_all('goods_attribute','*','1 ORDER BY sort DESC');
		if(!empty($this->bankuai)&&$this->bankuai['fenlei']==1){
			$type=$this->duoduo->select_all('type','id,title',"tag='goods'");
			foreach($type as $vo){
				$goods_type[$vo['id']]=$vo['title'];
			}
		}else{
			$goods_type=array();
		}
		//获取全局商品
		$good=$this->do_item($good,$goods_attribute_arr,$goods_type);//属性只需要查一次
		return $good;
	}
	//获取单个商品
	function good_api($iid){
		$ddTaoapi = new ddTaoapi();
		$return=$ddTaoapi->taobao_tbk_items_detail_get($iid);
		$goods=array();
		$goods['url']=u('goods','view',array('iid'=>iid_encode($return['num_iid'])));
		$goods['code']=$_GET['code'];
		$goods['laiyuan']='淘宝';
		$goods['laiyuan_type']=1;
		$goods['title']=$return['title'];
		$goods['title']=dd_replace($goods['title']);
		$goods['img']=$return['pic_url'];
		$goods['discount_price']=$return['discount_price'];
		$goods['price']=$return['price'];
		$goods['nick']=$return['nick'];
		$goods['sell']=$return['volume'];
		$goods['jump']=u('jump','goods',array('iid'=>iid_encode($return['num_iid'])));
		$goods['data_id']=$return['num_iid'];
		return $goods;
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
		
		$where.=" and (top_stime<=".time()." or top_stime=0) and (top_etime>=".time()." or top_etime=0)";
		return (float)$this->duoduo->count($this->table_name,$where);
	}
	function top_goods($code,$page_size=1,$field="*",$order=" id desc",$where){
		if($code!=""){
			$where.=" and code='".$code."'";
		}
		$a=$this->duoduo->select_all('goods',$field,' 1 '.$where.' ORDER BY '.$order.' LIMIT '.$page_size);
		foreach($a as $k=>$row){
			$a[$k]=$this->do_item($row);//属性只需要查一次
		}
		return $a;
	}
	
	function get_bankuai_url($code){
		$url=URL;
		$domain=$this->domain;
		if(empty($domain)){
			$domain=$this->domain=dd_get_cache('domain');
		}
		foreach($domain as $row){
			if($row['mod']=='goods' && $row['code']==$code && $row['close']==0){
				$url=$row['url'];
				break;
			}
		}
		return $url;
	}
	
	function do_item($item,$goods_attribute_arr=array(),$goods_type=array()){
		if(isset($item['sort']) && $item['sort']==DEFAULT_SORT){
			$item['sort']='——';
		}
		if(isset($item['starttime']) && $item['starttime']>0){
			$item['starttime']=date('Y-m-d H:i:s',$item['starttime']);
		}
		if(isset($item['endtime']) && $item['endtime']>0){
			$item['endtime']=date('Y-m-d H:i:s',$item['endtime']);
		}
		if(isset($item['addtime']) && $item['addtime']>0){
			$item['addtime']=date('Y-m-d H:i:s',$item['addtime']);
		}
		if($item['top']>0){
			$item['is_top']=true;
		}elseif($item['starttime']>=date('Y-m-d 00:00:00')){
			$item['is_new']=true;
		}
		$item['title']=dd_replace($item['title']);
		if(date('Y-m-d',strtotime($item['starttime']))==date('Y-m-d',strtotime("+1 day"))){
			$item['starttime_tag']="明日".date('H:i',strtotime($item['starttime']));
		}elseif(date('Y-m-d H:i:s',strtotime($item['starttime']))>date('Y-m-d 00:00:00',strtotime("+2 day"))){
			$item['starttime_tag']=date('d日H:i',strtotime($item['starttime']));
		}elseif(strtotime($item['starttime'])>TIME){
			$item['starttime_tag']=date('今日H:i',strtotime($item['starttime']));
		}
		if($goods_type){
			$item['cid_title']=$goods_type[$item['cid']];
		}
		$item['opca']=false;
		$item['price_man']=(float)$item['price_man'];
		$item['price_jian']=(float)$item['price_jian'];
		if(FANLI==1){
			//现价*返利比例*最高等级比例*设置的兑换比例
			if($this->dduser['id']>0){
				$fxbl=$this->webset['fxbl'][(int)$this->dduser['type']];
			}else{
				$fxbl=$this->webset['fxbl'][0];
			}
			$item['fanli']=(float)$item['discount_price']*(float)$item['fanli_bl']*0.01*$fxbl;
			$item['fanli_bl']=round($item['fanli_bl']*$fxbl,4);
			if($item['laiyuan_type']<3){
				$item['fanli_je']=round($item['fanli'],2);
				$item['fanli']=intval($item['fanli']*TBMONEYBL);
			}else{
				$item['fanli_je']=$item['fanli']=round($item['fanli'],2);
			}
			$item['unit']=($item['laiyuan_type']<3)?TBMONEY:'元';
		}
		if($item['starttime']>0&&$item['starttime']>SJ){
			$item['is_starttime']=true;
			$item['opca']=true;
		}elseif($item['oversell']==1){
			$item['opca']=true;
		}elseif($item['endtime']&&$item['endtime']<=SJ){
			$item['is_endtime']=true;
			$item['opca']=true;
		}
		if($item['fanli']>0&&$item['fanli_ico']){
			$item['is_fanli_ico']=true;
		}
		$item['goods_attribute']=unserialize($item['goods_attribute']);
		if($item['goods_attribute']&&$goods_attribute_arr){
			foreach($goods_attribute_arr as $vo){
				foreach($item['goods_attribute'] as $ak=>$attribute){
					if($vo['id']==$attribute){
						if($vo['ico']==''){
							if($vo['font_color']){
								$vo['font_color']="color:".$vo['font_color'].";";
							}
							if($vo['bg_color']){
								$vo['bg_color']="background-color:".$vo['bg_color'].";";
							}
							if($vo['bg_color']||$vo['font_color']){
								$vo['style']="style=\"".$vo['font_color'].$vo['bg_color']."\"";
							}
						}
						$item['goods_attribute_arr'][$ak]=$vo;
					}
				}
			}
		}
		$item['zhe']=round($item['discount_price']/$item['price'],2)*10;
		if($item['shouji_price']>0){
			$item['shouji_price_cha']=round($item['discount_price']-$item['shouji_price']);
		}
		if(ADMIN==1 && $item['auditor']==''){$item['auditor']=$this->auditor_word;}
		if($item['discount_price']==0){
			$item['discount_price']=$item['price'];
		}
		$item['_url']=$item['url'];
		if(WEBTYPE==0 && ($item['laiyuan_type']==1||$item['laiyuan_type']==2)){
			$item['url']='';
		}
		else{
			$item['url']=u('goods','view',array('code'=>$item['code'],'id'=>$item['id']));
		}
		
		$item['url_l']=l('goods','view',array('code'=>$item['code'],'id'=>$item['id']));
		if($item['tg_url']){
			$item['jump']=HTTP.$this->get_bankuai_url($item['code']).'/index.php?mod=jump&act=s8&url='.base64_encode($item['tg_url']).'&iid='.iid_encode($item['data_id']);
			$item['wap_jump']=HTTP.$this->get_bankuai_url($item['code']).'/m/index.php?mod=jump&act=index&url='.base64_encode($item['tg_url']).'&id='.$item['id'];
		}
		else{
			$item['item_url']=$item['_url'];
			if($item['laiyuan_type']==1||$item['laiyuan_type']==2){
				$item['jump']='';//u('jump','goods',array('iid'=>iid_encode($item['data_id']),'num_iid'=>$item['data_id'],'yun_jump'=>$item['yun_jump']));
				$item['wap_jump']='';//wap_l('jump','index',array('a'=>'tb','id'=>$item['id']));
			}
			elseif($item['laiyuan_type']==3){
				$item['jump']=u('jump','mall',array('url'=>$item['item_url']));
				$item['wap_jump']=wap_l('jump','index',array('a'=>'mall','url'=>$item['_url']));
			}
			elseif($item['laiyuan_type']==4){
				$commId=str_replace('paipai_','',$item['data_id']);
				$item['jump']=u('jump','paipaigoods',array('commId'=>$commId,'price'=>$item['discount_price'],'name'=>$item['title']));
			}
			
			if($item['uid']>0){
				if($item['laiyuan_type']==3){ //商城类型，反馈标签记录推广人
					$item['jump'].='&code='.urlencode('goods|'.$item['uid'].'|'.$item['id']);
				}
				else{ //淘宝类型，记录浏览日志
					if($item['laiyuan_type']==1 || $item['laiyuan_type']==2){
						$mall=2;
					}
					else{
						$mall=3;
					}
					$data=array('fuid'=>$item['uid'],'mall'=>$mall,'code'=>'goods','shuju_id'=>$item['id'],'goods_id'=>$item['data_id']);
					$item['jump'].='&'.http_build_query($data);
				}
			}
		}
		
		$item=$this->tuiguang($item);
		return $item;
	}
	
	function tuiguang($item){
		$tg_url=urlencode($item['url_l']."&rec=".$this->dduser['id']);
		$img=urlencode(tb_img($item['img'],220));
		$title=urlencode($item['title']);
		$item['sina_url']="http://v.t.sina.com.cn/share/share.php?title=".$title."&url=".$tg_url."&pic=".$img;
		$item['qzone_url']="http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=".$tg_url."&title=".$title."&summary=".$title."&pics=".$img."&desc=".$title;
		$item['renren_url']="http://widget.renren.com/dialog/share?resourceUrl=".$tg_url."&srcUrl=".$tg_url."&title=".$title."&images=".$img."&description=".$title;
		$item['qqim_url']='http://connect.qq.com/widget/shareqq/index.html?url='.$tg_url.'&desc='.$title.'&pics='.$img.'&site=bshare';
		$item['qqmb_url']="http://share.v.t.qq.com/index.php?c=share&a=index&title=".$title."&site=".$tg_url."&pic=".$img."&url=".$tg_url."&appkey=dcba10cb2d574a48a16f24c9b6af610c";
		return $item;
	}

	function admin_list($pagesize=20,$where='',$order_by='sort asc,id desc'){
		$a=$this->duoduo->get_table_struct($this->table_name);
		foreach($a as $k=>$v){
			if($k!='duoduo_table_index'){
				$b[]=$k;
			}
		}
		$page=(int)$_GET['page'];
		if($page==0) $page=1;
		
		if($where=='1=1' || $where==''){
			$total_where='`del`=0';
		}
		elseif(strpos($where,'`del`')!==false){
			$total_where=$where;
		}
		else{
			$total_where=$where.' and `del`=0';
		}
		$re['total']=$this->total($total_where);
		$re['data']=$this->show($pagesize,$page,implode(',',$b),$where,$order_by);
		return $re;
	}
	
	function index_list($par,$pagesize=20,$page=1,$where='',$total=0,$order_by=''){
		//分析是不是api调用
		$code=$par['code'];
		if($code){
			$bankuai_cache=dd_get_cache('bankuai');
			$this->bankuai=$bankuai_cache[$code];
			$this->quanju=(int)$this->bankuai['quanju'];//是否调用全局置顶商品
			if($this->bankuai['data_from']==1){
				$canshu=array();
				if($this->bankuai['fenlei']==0){
					$dan_api=unserialize($this->bankuai['dan_api']);
					$canshu=array();
					if($dan_api['cat']){
						$canshu['cat']=$dan_api['cat'];
					}
					if($dan_api['q']){
						$canshu['q']=$dan_api['q'];
					}
				}
				if($this->bankuai['fenlei']==1){
					$yun_cid=unserialize($this->bankuai['yun_cid']);
					$cid=(int)$par['cid'];
					if($cid==0){
						foreach($yun_cid as $vo){
							if($vo['cat']||$vo['q']){
								$cat=$vo['cat'];
								$q=$vo['q'];
								break;
							}
						}
					}else{
						$cat=$yun_cid[$cid]['cat'];
						$q=$yun_cid[$cid]['q'];
					}
					if($cat){
						$canshu['cat']=$cat;
					}
					if($q){
						$canshu['q']=$q;				
					}
				}
				$canshu['sort']=$this->bankuai['api_sort'];
				$canshu['page_no']=$page;
				$canshu['page_size']=$pagesize;
				$canshu['total']=$total;
				$canshu['code']=$code;
				$return=$this->taobao_tbk_item_get($canshu);
				return $return;
			}
		}
		if($where==''){$where='1=1';}
		if($_GET['do']=='yugao'){
			$this->quanju=0;//预告没置顶了
			$where.=' and starttime>"'.TIME.'"';
			$order_by.="starttime ASC,id DESC";
		}else{
			if($_GET['do']!='yulan'){
				$where.=' and (starttime<="'.TIME.'" or starttime=0) ';
			}
			$where.=' and (endtime=0 or endtime>"'.TIME.'")';
		}
		if($_GET['do']=='chaofan'){
			$where.=' and fanli_bl>0 and fanli_ico=1';
		}
		if($_GET['do']=='youhuiquan'){
			$where.=' and price_man>0 and price_jian>0';
		}
		if($total==1){
			$re['total']=$this->total($where);
			$re['data']=$this->show($pagesize,$page,'*',$where,$order_by);
		}
		else{
			$re=$this->show($pagesize,$page,'*',$where,$order_by);
		}
		return $re;
	}
	function taobao_tbk_item_get($canshu){
		$ddTaoapi = new ddTaoapi();
		$return=$ddTaoapi->taobao_tbk_item_get($canshu);
		if($return['s']==0){
			jump(-1,$return['r']);
			return $return;
		}
		$num_iids='';
		foreach($return['r'] as $k=>$row){
			$num_iids.=','.$row['num_iid'];
		}
		$num_iids=preg_replace('/^,/','',$num_iids);
		$b=$ddTaoapi->taobao_taobaoke_rebate_auth_get($num_iids,3);
		foreach($b as $k=>$row){
			$b['a'.$row['param']]=$row['rebate'];
			unset($b[$k]);
		}	
		$re['total']=$return['total']<10000?$return['total']:10000;		
		$data=array();
		foreach($return['r'] as $key=>$vo){	
			if(isset($b['a'.$vo['num_iid']])&&$b['a'.$vo['num_iid']]==false){
				continue;
			}
			$data[$key]['item_url']=$vo['item_url'];
			$data[$key]['data_id']=$vo['num_iid'];
			$data[$key]['id']='tb'.$vo['num_iid'];
			$data[$key]['img']=$vo['pict_url'];
			$data[$key]['price']=$vo['reserve_price'];
			$data[$key]['discount_price']=$vo['zk_final_price'];
			$data[$key]['zhe']=round($data[$key]['discount_price']/$data[$key]['price'],2)*10;
			$data[$key]['title']=strip_tags($vo['title']);
			$data[$key]['title']=dd_replace($data[$key]['title']);
			$data[$key]['cid']=0;
			$data[$key]['code']=$canshu['code'];
			if($vo['user_type']==1){
				$data[$key]['laiyuan']='天猫';
				$data[$key]['laiyuan_type']=2;
			}else{
				$data[$key]['laiyuan']='淘宝';
				$data[$key]['laiyuan_type']=1;
			}
			
			$data[$key]['jump']=u('jump','goods',array('iid'=>iid_encode($data[$key]['data_id'])));
			if(WEBTYPE==0){
				$item['url']='';
			}
			else{
				$data[$key]['url']=u('tao','view',array('iid'=>iid_encode($data[$key]['data_id'])));
			}
			$data[$key]['url_l']=l('tao','view',array('iid'=>iid_encode($data[$key]['data_id'])));
			$data[$key]=$this->tuiguang($data[$key]);
		}
		unset($b);
		$data=$this->get_shoucang($data);
		if($canshu['total']==1){
			$re['data']=$data;
			$re['s']=1;
			return $re;
		}
		else{
			return $data;
		}
		
	}
	function update_sort($id,$sort){
		$this->duoduo->update_sort($id,$sort,$this->table_name);
	}
	
	function get_ddusername($uid){
		return $this->duoduo->select('user','ddusername','id="'.$uid.'"');
	}
	
	function status($status=''){
		if(is_numeric($status)){
			if($this->cat==''){
				$this->cat=include(DDROOT.'/data/goods.php');
			}
			$re=$this->cat['status'][$status];
		}
		else{
			$this->cat=include(DDROOT.'/data/goods.php');
			$re=$this->cat['status'];
			foreach($re as $k=>$v){
				$re[$k]=strip_tags($v);
			}
		}
		return $re;
	}
	//踩和顶
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
			$vote=$this->duoduo->select('goods_vote','id,type','uid="'.$uid.'" and data_id="'.$data_id.'"');
			if($vote['id']>0){
				if($vote['type']==-1){ //如果当前是无效投票数据
					$update_data=array('type'=>$type);
					$update_goods=array('f'=>$f,'v'=>1,'e'=>'+');
					$r=1;
				}
				elseif($vote['type']==1){ //如果原数据是顶
					if($type==1){ //行为是顶，重置
						$update_data=array('type'=>-1);
						$r=-1;
						$update_goods=array('f'=>'ding','v'=>1,'e'=>'-');
					}
					else{ //行为是踩，提示错误
						$re=array('s'=>0,'r'=>'您已经投过票了');
					}
				}
				else{ //如果原数据是踩
					if($type==0){ //行为是踩，重置
						$update_data=array('type'=>-1);
						$r=-1;
						$update_goods=array('f'=>'cai','v'=>1,'e'=>'-');
					}
					else{ //行为是顶，提示错误
						$re=array('s'=>0,'r'=>'您已经投过票了');
					}
				}
				
				$this->duoduo->update('goods_vote',$update_data,'id="'.$vote['id'].'"');
				
				if(!isset($re)){
					$re=array('s'=>1,'r'=>$r);
				}
				
			}
			else{
				$data=array('data_id'=>$data_id,'uid'=>$uid,'addtime'=>TIME,'type'=>$type);
				$this->duoduo->insert('goods_vote',$data);
				$update_goods=array('f'=>$f,'e'=>'+','v'=>1);
				$re=array('s'=>1,'r'=>1);
			}
			$this->duoduo->update('goods',$update_goods,'id="'.$data_id.'"');
		}
		return $re;
	}
	
	function comment_list($data_id=0,$uid=0,$page=0,$pagesize=10){
		$where='1=1';
		if($data_id>0){
			$where.=' and data_id="'.$data_id.'"';
		}
		if($uid>0){
			$where.=' and uid="'.$uid.'"';
		}
		if($page>0){
			$page1 = ($page-1)*$pagesize;
			$limit = 'limit '.$page1.' , '.$pagesize;
		}
		$comment=$this->duoduo->select_all('goods_comment','*',$where.' order by id desc '.$limit);
		foreach($comment as $k=>$row){
			$comment[$k]['addtime']=date('Y-m-d H:i:s',$row['addtime']);
		}
		return $comment;
	}
	
	function comment_sub($data_id,$uid,$username,$comment){
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
		elseif($this->duoduo->count('goods_comment','uid="'.$uid.'" and data_id="'.$data_id.'"')>=3){
			$re=array('s'=>0,'r'=>'亲，最多评论3次！');
		}
		/*elseif(TIME-$this->duoduo->select('ddzhidemai_comment','addtime','uid="'.$uid.'"')<600){
			$re=array('s'=>0,'r'=>'过一会再来评论吧');
		}*/
		else{
			$data=array('data_id'=>$data_id,'content'=>$comment,'addtime'=>TIME,'uid'=>$uid,'username'=>$username);
			$post['ddurl']=URL;
			$this->duoduo->insert('goods_comment',$data);
			$data=array('f'=>'pinglun','e'=>'+','v'=>1);
			$this->duoduo->update('goods',$data,'id="'.$data_id.'"');
        	$re=array('s'=>1);
		}
		return $re;
	}
}