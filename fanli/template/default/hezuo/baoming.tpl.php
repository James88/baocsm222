<?php
if(!defined('INDEX')){
	exit('Access Denied');
}
include(TPLPATH.'/hezuo/top.tpl.php');
?>
<h2 class="u-h2">我要报名:</h2>
<div class="bm_wrap">
  <div class="clearfix"></div>
  <div class="bmbody_wrap">
    <div class="grid1000 ">
      <div class="clearfix">
        <div class="bm_input" style="height:auto;">
          <div class="re_content">
            <h3 class="title"><?php if(empty($_GET['code'])){?>欢迎你来报名<?php }else{?>亲，你正在报名<?=$webset['ddgoodslanmu'][$_GET['code']]?><?php }?>，任何问题请<a style="font-size:14px; color:#F00" target="_blank" href="<?=u('about','index',array('id'=>2))?>">[联系我们]</a></h3>
            <form class="GoodAddform" name="form" id="form" method="post" action="<?=u('hezuo','baoming')?>">
              <ul>
                <li>
                  <label>报名理由：</label>
                  <textarea name="content" style="color:#535353; width:580px; height:250px;" id="superiority" maxlength="140" onclick="if(this.value=='清晰的描述您的宝贝描述，审核人员会做为审核的参考依据。'){this.value=''}"><?=$this_row['content']?$this_row['content']:'清晰的描述您的宝贝描述，审核人员会做为审核的参考依据。'?></textarea>
                </li>
                <li>
                  <label>验证码：</label>
                  <?php if($webset['yinxiangma']['open']==0){?>
                  <input name="captcha" type="text" id="captcha" size="6" maxlength="4" style="width:180px;" class="ddinput"/>&nbsp;&nbsp;<?=yzm()?>
                  <?php }else{?>
                  <div style="width:300px; overflow:hidden"><?=$yinxiangma?></div>
                  <?php }?>
                </li>
              </ul>
              <input name="code" value="<?=$_GET['code']?>" type="hidden"><input name="id" value="<?=$_GET['id']?>" type="hidden">
              <div style="clear:both"></div>
              <div class="anniu">
                <input name="sub" value="提 交" id="sub" title="检测通过后才能提交" class="smt submit" type="submit">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</div>
<?php include(TPLPATH.'/footer.tpl.php'); ?>
