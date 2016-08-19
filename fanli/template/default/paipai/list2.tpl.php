	<div class="goodslist_main_2" id="splistbox">
                    <ul>
                    <?php foreach($goods as $row) {?>
                        <li class="info" style="height:350px">
                            <div class="goodslist_main_left_img_2"><a rel="nofollow" href="<?=$row["jump"]?>" target="_blank"><?=html_img($row["middleImg"],0,$row["title"],'',160,160)?></a></div>
                        	<div class="goodslist_main_left_bt_2 title"><a target="_blank" rel="nofollow" href="<?=$row["jump"]?>"><?php echo $row["title"] ?></a></div>
                            <div class="goodslist_main_left_xy_2"><p>卖家信用：<img alt="等级" src="http://static.paipaiimg.com/module/icon/credit/credit_s<?=$row["level"]?>.gif" align="absmiddle" /></p> </div>
                            <div class="goodslist_main_left_seller_2"><p title="<?=$row["nickName"]?>">联系卖家：<?=qq($row["uin"],2)?></p>
                            </div>
                        	<p class="price">拍拍价：<span><?=$row["price"]?></span> 元 </p> 
                            <?php if(FANLI==1){?><p class="fxje"> 可返：<span class="greenfont"><?=$row["fxje"]?></span> 元 </p><?php }?>
                            <div class="goodslist_main_right_tb_2">
                                  <a rel="nofollow" href="<?=$row['jump']?>" target="_blank" ><div class="goodslist_main_right_buy">去拍拍购买</div></a>
                            </div>
                        </li>  
                     <?php }?> 
                                 
                    </ul>
                </div>	