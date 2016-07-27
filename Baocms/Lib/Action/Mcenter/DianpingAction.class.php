<?php

/*
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.taobao.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class DianpingAction extends CommonAction {


    public function index($shop_id) {
		$shop_id = (int) $shop_id;
		if (!$detail = D('Shop')->find($shop_id)) {
			$this->baoMsg('该商家不存在');
		}
		$cates = D('Shopcate')->fetchAll();
		$cate = $cates[$detail['cate_id']];
		$this->assign('cate', $cate);
		if ($this->isPost()) {
			$data = $this->checkFields($this->_post('data', false), array('score', 'd1', 'd2', 'd3', 'cost', 'contents'));
			$data['user_id'] = $this->uid;

			$data['shop_id'] = $shop_id;

			$data['score'] = (int) $data['score'];
			if ($data['score'] <= 0 || $data['score'] > 5) {
				$this->baoMsg('请选择评分');
			}

			$data['d1'] = (int) $data['d1'];
			if (empty($data['d1'])) {
				$this->baoMsg($cate['d1'] . '评分不能为空');
			}
			if ($data['d1'] > 5 || $data['d1'] < 1) {
				$this->baoMsg($cate['d1'] . '评分不能为空');
			}
			$data['d2'] = (int) $data['d2'];
			if (empty($data['d2'])) {
				$this->baoMsg($cate['d2'] . '评分不能为空');
			}
			if ($data['d2'] > 5 || $data['d2'] < 1) {
				$this->baoMsg($cate['d2'] . '评分不能为空');
			}
			$data['d3'] = (int) $data['d3'];
			if (empty($data['d3'])) {
				$this->baoMsg($cate['d3'] . '评分不能为空');
			}
			if ($data['d3'] > 5 || $data['d3'] < 1) {
				$this->baoMsg($cate['d3'] . '评分不能为空');
			}

			$data['cost'] = (int) $data['cost'];
			$data['contents'] = htmlspecialchars($data['contents']);
			if (empty($data['contents'])) {
				$this->baoMsg('不说点什么么');
			}
			$data['create_time'] = NOW_TIME;
			$data['show_date'] = date('Y-m-d', NOW_TIME); //15天后显示 --> 立刻显示
			$data['create_ip'] = get_client_ip();
			$obj = D('Shopdianping');
			if ($dianping_id = $obj->add($data)) {
				$photos = $this->_post('photos', false);
				$local = array();
				foreach ($photos as $val) {
					if (isImage($val))
						$local[] = $val;
				}
				if (!empty($local))
				D('Shopdianpingpics')->upload($dianping_id, $data['shop_id'], $local);
				D('Shop')->updateCount($shop_id, 'score_num');
				D('Users')->updateCount($this->uid, 'ping_num');
				D('Shopdianping')->updateScore($shop_id);
				$this->baoMsg('评价成功',0);
			}
			$this->baoMsg('操作失败！');
		}else {
			$this->assign('detail', $detail);
			$this->display();
		}
	}
    
    
}