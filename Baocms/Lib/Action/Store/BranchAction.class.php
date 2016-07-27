<?php

/*
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.taobao.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class BranchAction extends CommonAction {

    private $create_fields = array('name', 'city_id', 'area_id', 'business_id', 'addr', 'lng', 'lat', 'orderby','telephone');
    private $edit_fields = array('name', 'city_id', 'area_id', 'business_id', 'addr', 'lng', 'lat', 'orderby','telephone');

    public function _initialize() {
        parent::_initialize();
        $this->assign('city',D('City')->fetchAll());
        $this->assign('area', D('Area')->fetchAll());
        $this->assign('business', D('Business')->fetchAll());
    }

    public function index() {
        
        $branch = D('Shopbranch');
        import('ORG.Util.Page'); // 导入分页类
        $map = array('closed' => 0, 'shop_id' => $this->shop_id);
        if ($keyword = $this->_param('keyword', 'htmlspecialchars')) {
            $map['name|addr'] = array('LIKE', '%' . $keyword . '%');
            $this->assign('keyword', $keyword);
        }
        $count = $branch->where($map)->count(); // 查询满足要求的总记录数 
        $Page = new Page($count,10); // 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show(); // 分页显示输出
        $var = C('VAR_PAGE') ? C('VAR_PAGE') : 'p';
        $p = $_GET[$var];
        if ($Page->totalPages < $p) {
            die('0');
        }
        $list = $branch->where($map)->order(array('orderby' => 'asc', 'branch_id' => 'desc'))->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $this->assign('list', $list); // 赋值数据集
        $this->assign('page', $show); // 赋值分页输出
        $this->display();
    }
    

    public function delete($branch_id = 0) {
        if (is_numeric($branch_id) && ($branch_id = (int) $branch_id)) {
            $obj = D('Shopbranch');
            if (!$detail = $obj->find($branch_id)) {
                $this->error('请选择要删除的分店');
            }
            if ($detail['closed'] == 1) {
                $this->error('该分店不存在');
            }
            if ($detail['shop_id'] != $this->shop_id) {
                $this->error('请不要试图越权操作其他人的内容');
            }
            $obj->save(array('branch_id' => $branch_id, 'closed' => 1));
            $this->success('删除成功！', U('branch/index'));
        } else {
            $this->error('请选择要删除的分店');
        }
    }

    public function manage($branch_id=0) {
        if ($branch_id = (int) $branch_id) {
            $obj = D('Shopbranch');
            if (!$detail = $obj->find($branch_id)) {
                $this->error('请选择要设置的分店');
            }
            if ($detail['shop_id'] != $this->shop_id) {
                $this->error('请不要试图越权操作其他人的内容');
            }
            if ($this->isPost()) {
                $data['password'] = htmlspecialchars($_POST['password']);
                //$res = $obj->where(array('shop_id'=>$this->shop_id,'password'=>$data['password']))->find();
                //if(!empty($res)){
                //    $this->baoError('该账户已存在');
                //}
                if(empty($data['password'])){
                    $this->baoError('口令不能为空');
                }
                $data['branch_id'] = $branch_id;
                if (false !== $obj->save($data)) {
                    $this->baoSuccess('操作成功', U('branch/index'));
                }
                $this->baoError('操作失败');
            } else {
                $this->assign('detail', $detail);
                $this->display();
            }
        }else{
            $this->baoError('请选择要设置的分店');
        }
    }

}
