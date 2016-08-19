<?php
/**
 * ============================================================================
 * 版权所有 多多科技，保留所有权利。
 * 网站地址: http://soft.duoduo123.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/

if(!defined('INDEX')){
	exit('Access Denied');
}
include(TPLPATH.'/hezuo/top.tpl.php');
?>
<div style="height:30px; margin:10px 0;"><a href="<?=u(MOD,ACT)?>" class="u-h2 alist  <?php if($tag=='hezuo'){?>cur<?php }?>" >我的报名</a>&nbsp;<a href="<?=u(MOD,ACT,array('tag'=>'goods'))?>" class="u-h2 alist <?php if($tag=='goods'){?>cur<?php }?>">我报名的商品</a>&nbsp;<a href="<?=u(MOD,ACT,array('tag'=>'mall'))?>" class="u-h2 alist <?php if($tag=='mall'){?>cur<?php }?>">我报名的店铺</a>
</div>
  <div class="clearfix"></div>
        <div class="bm_input" style="height:auto;">
        <?php if($tag=='hezuo'){?>
			<?php if(!empty($ddgoods)){?>
             <div class="pay_cont" style="margin:10px;">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tbody>
                    <tr>     
                      <th width="500px">内容</th>
                      <th width="160px">提交时间</th>
                      <th width="15%">栏目</th>
                      <th>操作</th>
                    </tr>
                    <?php  foreach($ddgoods as $vo){?>
                    <tr> 
                     <td><a class="ddnowrap" style="width:450px;" title="<?=$vo['content']?>"><?=$vo['content']?></a></td>
                      <td><?=date('Y-m-d H:i:s',$vo['addtime'])?></td>
                      <td><?=$bankuai[$vo['code']]?></td>
                      <td><a href="<?=u(MOD,'baoming',array('id'=>$vo['id']))?>">修改</a></td>
                    </tr>
                    <?php }?>
                  </tbody>
                </table>
                <div class="megas512"><?=pageft($total,$pagesize,u(MOD,ACT,array('tag'=>$tag)),WJT)?></div>            
             <?php }else{?>
                 <div class="megas512"><span style=" font-size:12px;">还没有报名商品，<a href="<?=u('hezuo','baoming')?>">立刻报名</a></span></div>
             <?php }?>
        <?php }elseif($tag=='goods'){?>
       		 <?php if(!empty($ddgoods)){?>
        	<div class="pay_cont" style="margin:10px;">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tbody>
                    <tr>     
                      <th>商品标题</th>
                      <th width="20%">开始时间</th>
                 	  <th width="20%">结束时间</th>
                      <th width="100px">栏目</th>
                    </tr>
                    <?php  foreach($ddgoods as $vo){?>
                    <tr> 
                       <td><a href="<?=$vo['url']?>" target="_blank" class="ddnowrap" style="width:450px;" title="<?=$vo['title']?>"><?=$vo['title']?></a></td>
                       <td><?=is_kong(date('Y-m-d H:i:s',$vo['starttime']))?></td>
                   	   <td><?=is_kong(date('Y-m-d H:i:s',$vo['endtime']))?></td>
                       <td><?=$bankuai[$vo['code']]?></td>
                    </tr>
                    <?php }?>
                  </tbody>
                </table>
                <div class="megas512"><?=pageft($total,$pagesize,u(MOD,ACT,array('tag'=>$tag)),WJT)?></div>          
             <?php }else{?>
                 <div class="megas512"><span style=" font-size:12px;">还没有报名商品，<a href="<?=u('hezuo','baoming')?>">立刻报名</a></span></div>
             <?php }?>
        <?php }elseif($tag=='mall'){?>
        	<?php if(!empty($ddgoods)){?>
        	<div class="pay_cont" style="margin:10px;">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tbody>
                    <tr>     
                      <th width="500px">商城名称</th>
                      <th>网址</th>
                      <th width="20%">到期时间</th>
                    </tr>
                   <!-- <tr>
                      <td><input type="checkbox" onClick="checkAll(this,'ids[]')" /></td>
                      <td><a href="<?=$vo['url']?>" target="_blank" class="ddnowrap" style="width:250px;" title="<?=$vo['title']?>">a123123131313132sfafasfdasdfasdfasfafsad</a></td>
                      <td>152.3</td>
                      <td>2015-04-18</td>
                      <td>9.9包邮</td>
                      <td>审核中</td>
                      <td><a href="#">修改</a></td>
                    </tr>-->
                    <?php  foreach($ddgoods as $vo){?>
                    <tr> 
                      <td><a class="ddnowrap" style="width:450px;" title="<?=$vo['title']?>"><?=$vo['title']?></a></td>
                      <td><a href="<?=u('mall','view',array('id'=>$vo['id']))?>" target="_blank"><?=$vo['url']?></a></td>
                       <td><?=$vo['edate']?date("Y-m-d",$vo['edate']):'--'?></td>
                    </tr>
                    <?php }?>
                  </tbody>
                </table>
                <div class="megas512"><?=pageft($total,$pagesize,u(MOD,ACT,array('tag'=>$tag)),WJT)?></div>            
             <?php }else{?>
                 <div class="megas512"><span style=" font-size:12px;">还没有报名商品，<a href="<?=u('hezuo','baoming')?>">立刻报名</a></span></div>
             <?php }?>
        <?php }?>
        </div>
      </div>
  </div>
<?php include(TPLPATH.'/inc/footer.tpl.php'); ?>
