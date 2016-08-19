<div class="goodslist_main" id="splistbox">
                    <ul>
                    <?php foreach($goods as $row) {?>
                        <li class="info">
                        <div class="goodslist_main_left">
                        	<div class="goodslist_main_left_img pic"><a class="taopic" href="<?=$row['goods_jump']?>" target="_blank" pic="<?=$row['base64_pic']?>"><?=html_img($row["pic_url"],0,$row["title"])?></a></div>
                        	<div class="goodslist_main_left_bt"><a target="_blank" href="<?=$row['goods_jump']?>"><?=$row["title"]?></a></div>
                            <div class="goodslist_main_left_sell"><p>&nbsp;</p> </div>
                            <div class="goodslist_main_left_seller"><p>商家：<a <?php if($row['renzheng']==1){?>href="<?=$row['mall_url']?>"<?php }?> target=_blank><?=$row['mall_name']?></a> <?=$row['renzheng']?'<img alt="网站认证" src="'.TPLURL.'/images/renzheng.gif" />':''?></p>
                            </div>
                        </div>
                        <div class="goodslist_main_right">
                        	<div class="goodslist_main_right_price">
                            <p class="price">价格：<span><?=$row['price']?></span> 元 </p> 
                            <p class="fxje"> 最高返<span class="greenfont"><?=$row["fan"]?></span></p> 

                            <p>&nbsp;<a target="_blank" href="<?=$row["goods_jump"]?>">详情</a></p>
                        	</div>
                            <div style="clear:both"></div>
                            <div class="goodslist_main_right_tb">
                                <a target="_blank" href="<?=$row['goods_jump']?>"><div class="goodslist_main_right_buy">去商城购买</div></a>
                            </div>
                        </div>
                        </li>
                    <?php }?>
                         
                    </ul>
                </div>