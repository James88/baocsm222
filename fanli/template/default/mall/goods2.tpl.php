<div class="goodslist_main_2">
                    <ul>
                    <?php foreach($goods as $row) {?>
                        <li class="info" style="height:322px;">
                            <div class="goodslist_main_left_img_2 pic"><a href="<?=$row["goods_jump"]?>" target="_blank"><?=html_img($row["pic_url"],0,$row["title"],'',160,160)?></a></div>
                        	<div class="goodslist_main_left_bt_2"><a target="_blank" href="<?=$row["goods_jump"]?>"><?php echo $row["title"] ?></a></div>
                            <div class="goodslist_main_left_seller_2"><p>商家：<a <?php if($row['renzheng']==1){?>href="<?=$row['mall_url']?>"<?php }?> target=_blank><?=$row['mall_name']?></a> <?=$row['renzheng']?'<img alt="网站认证" src="'.TPLURL.'/images/renzheng.gif" />':''?></p>
                            </div>
                        	<p class="price">价格：<span><?=$row["price"]?></span> 元 </p> 
                            <p class="fxje">最高返：<span class="greenfont"><?=$row["fan"]?></span></p>
                            <div class="goodslist_main_right_tb_2">
                                  <a  href="<?=$row["goods_jump"]?>" target="_blank" ><div class="goodslist_main_right_buy">去商城购买</div></a>
                            </div>
                        </li>  
                        <?php }?>                
                    </ul>
                </div>