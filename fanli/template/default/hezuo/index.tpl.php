<?php
include(TPLPATH.'/hezuo/top.tpl.php');
?>
                <h2 class="u-h2">商家报名:</h2>
        		<div class="z-sellpartners clearfix">
                <?php foreach($bankuai as $k=>$v){
					if(empty($v['url'])){
						$view_url=u('hezuo','baoming',array('code'=>$v['code']));
					}else{
						$view_url=$v['url'];
					}
				?>
                   <a class="z-sellpartners-fir"  <?php if($v['url']){?>target="_blank"<?php }?>  href="<?=$view_url?>">           
                       <span class="icon"><img src="<?=$v['bankuai_img']?>" /></span>
                       <h3><?=$v['title']?></h3>
                          <?=$v['bankuai_desc']?>
                       <p class="baoming-icon"><i class="btn btn-1"><span>立即报名</span></i></p>
                   </a>
                <?php }?>
           </div>
        </div>
    </div>    
</div>
<?php include(TPLPATH.'/inc/footer.tpl.php'); ?>