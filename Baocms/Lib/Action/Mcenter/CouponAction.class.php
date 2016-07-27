<?php

/*
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.taobao.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class CouponAction extends CommonAction {

	
	public function index() {
                $aready = (int) $this->_param('aready');
		$this->assign('aready', $aready);
		$this->display();
	}

	public function couponloading() {
		$Coupondownloads = D('Coupondownload');
		import('ORG.Util.Page');
		$map = array('user_id' => $this->uid);
                
                $aready = (int) $this->_param('aready');

		if ($aready == 2) {
			$map['is_used'] = array('egt',1);
		}elseif ($aready == 1) {
			$map['is_used'] = 0;
                }else{
                    $aready == null;
                }
                
		$count = $Coupondownloads->where($map)->count();
		$Page = new Page($count, 25);
		$show = $Page->show();
		$var = C('VAR_PAGE') ? C('VAR_PAGE') : 'p';
		$p = $_GET[$var];
		if ($Page->totalPages < $p) {
			die('0');
		}
		$list = $Coupondownloads->where($map)->order('is_used asc')->limit($Page->firstRow . ',' . $Page->listRows)->select();
		$coupon_ids = array();
		foreach ($list as $k => $val) {
			$coupon_ids[$val['coupon_id']] = $val['coupon_id'];
		}
		$shops = D('Shop')->itemsByIds($shop_ids);
		$coupon = D('Coupon')->itemsByIds($coupon_ids);
		$this->assign('coupon', $coupon);
		$this->assign('shops', $shops);
		$this->assign('list', $list);
		$this->assign('page', $show);
		$this->display();
	}

	public function coupondel($download_id) {
		$download_id = (int) $download_id;
		if (empty($download_id)) {
			$this->error('该优惠券不存在');
		}
		if (!$detail = D('Coupondownload')->find($download_id)) {
			$this->error('该优惠券不存在');
		}
		if ($detail['user_id'] != $this->uid) {
			$this->error('请不要操作别人的优惠券');
		}
		D('Coupondownload')->delete($download_id);
		$this->success('删除成功！', U('coupon/index'));
	}
	
	
}