<?php

/****************** 版权声明 ******************************
 *
 *----------------合肥生活宝网络科技有限公司-----------------
 *----------------      www.taobao.com    -----------------
 *QQ:800026911  
 *电话:0551-63641901  
 *EMAIL：youge@baocms.com
 * 
 ***************  未经许可不得用于商业用途  ****************/

class  HouseworkAction extends CommonAction{
    
    public function index(){
        $Housework = D('Housework');
        import('ORG.Util.Page'); // 导入分页类
        $map = array();
        $keyword = $this->_param('keyword', 'htmlspecialchars');
        if ($keyword) {
            $map['name|tel|contents'] = array('LIKE', '%' . $keyword . '%');
            $this->assign('keyword', $keyword);
        }  
        if ($svc_id = (int) $this->_param('svc_id')) {
            $map['svc_id'] = $svc_id;
            $this->assign('svc_id', $svc_id);
        }
        $count = $Housework->where($map)->count(); // 查询满足要求的总记录数 
        $Page = new Page($count, 15); // 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show(); // 分页显示输出
        $list = $Housework->where($map)->order(array('housework_id' => 'desc'))->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $this->assign('list', $list); // 赋值数据集
        $this->assign('page', $show); // 赋值分页输出
        $this->assign('workTypes',$Housework->getCfg());
        $this->display(); // 输出模板
    }
    
    public function edit($housework_id){
        if ($housework_id = (int) $housework_id) {
            $obj = D('Housework');
            if (!$detail = $obj->find($housework_id)) {
                $this->baoError('请选择要编辑的活动');
            }
            if ($this->isPost()) {
                $data['is_real'] = (int)$this->_post('is_real');
                $data['num']     = (int)  $this->_post('num');
                $data['gold']    = (int) $this->_post('gold');
                $data['housework_id'] = $housework_id;
                if (false !== $obj->save($data)) {
                    $this->baoSuccess('操作成功', U('housework/index'));
                }
                $this->baoError('操作失败');
            } else {
    
                $this->assign('detail', $detail);
                $this->display();
            }
        } else {
            $this->baoError('请选择要编辑的活动');
        }
        
        
    }
    
     public function delete($housework_id = 0) {
        if (is_numeric($housework_id) && ($housework_id = (int) $housework_id)) {
            $obj = D('Housework');
            $obj->delete($housework_id);
            $this->baoSuccess('删除成功！', U('housework/index'));
        } else {
            $housework_id = $this->_post('housework_id', false);
            if (is_array($housework_id)) {
                $obj = D('Housework');
                foreach ($housework_id as $id) {
                    $obj->delete($id);
                }
                $this->baoSuccess('删除成功！', U('housework/index'));
            }
            $this->baoError('请选择要删除的预约');
        }
    }
    
}