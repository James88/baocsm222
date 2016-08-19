<div id="apDiv9">
    <?php if($dduser['name']!=NULL){?>
    <div style="padding-left:18px; padding-top:21px">
    <div style="float:left;"><img alt="<?=$dduser['name']?>" src="<?=a($dduser['id'],'small')?>"/></div>
    <div style="float:left; margin-left:10px; line-height:20px">
    <div>您好：<span style=" color:#B1319E; font-size:14px"><?=$dduser['name']?></span></div>
    <div><?=TBMONEY?>：<span style=" color:#B1319E; font-size:14px"><?=$dduser['jifenbao']?></span> &nbsp;<?=TBMONEYUNIT?></div>
    <div>积分：<span style=" color:#B1319E; font-size:14px"><?=$dduser['jifen']?></span>&nbsp;点</div>
    </div>
    </div>
    <?php }else{?>
      <div id="apDiv22"></div>
      <div id="apDiv23"><a onclick="window.location='<?=u('user','login')?>&url='+encodeURIComponent(window.location.href)" style="cursor:pointer"><img alt="登陆" src="<?=TPLURL?>/inc/images/fqw_dl.gif" width="171" height="35" /></a></div>
    <?php }?>
    </div>
    
    <div id="apDiv6" style="margin-top:10px"><div id="apDiv9" style="height:auto; padding-bottom:10px">
<div id="apDiv221"></div>
<ul>
  <li><a <?php if($cid==0){?> class="current"<?php }?> href="<?=u('huan','list')?>">全部</a></li>
  <?php foreach($huan_type_arr as $k=>$v){?>
  <li><a <?php if($cid==$k){?> class="current"<?php }?> href="<?=$v['url']?>"><?=$v['title']?></a></li>
  <?php }?>
</ul>
</div>
</div>