<div class="goodslist_main" id="splistbox">
                    <ul>
                    <?php if(!empty($thegoods)){?>
                    <div style="height:20px; font-weight:bold; font-size:14px; color:#F30;">当前查询商品</div>
                    <li class="info">
                        <div class="goodslist_main_left">
                        	<div class="goodslist_main_left_img"><a class="taopic" rel="nofollow" href="<?=$thegoods["jump"]?>" target="_blank" pic="<?=base64_encode($thegoods["bigImg"])?>"><?=html_img($thegoods["middleImg"],0,$thegoods["title"])?></a></div>
                        	<div class="goodslist_main_left_bt title"><a target="_blank" rel="nofollow" href="<?=$thegoods["jump"]?>"><?php echo $thegoods["title"] ?></a></div>
                            <div class="goodslist_main_left_sell"><p>
                            <?php if($thegoods['dwTransportPriceType']==1){?>
                            运费政策：卖家承担运费
                            <?php }elseif($thegoods['dwTransportPriceType']==2){?>
                            平邮：<?=$arr['dwNormalMailPrice']?> 快递：<?=$arr['dwExpressMailPrice']?> EMS：<?=$arr['dwEmsMailPrice']?>
                            <?php }elseif($thegoods['dwTransportPriceType']==3){?>
                            运费政策：同城交易
                            <?php }elseif($thegoods['dwTransportPriceType']==4){?>
                            运费政策：无需运费
                            <?php }?>
                            </p> </div>
                            <div class="goodslist_main_left_seller"><p>卖家联系QQ： <?=qq($thegoods["uin"])?></p>
                            </div>
                        </div>
                        <div class="goodslist_main_right">
                        	<div class="goodslist_main_right_price">
                            <p class="price">拍拍价：<span><?=$thegoods["price"]?></span> 元 </p> 
                            <?php if(FANLI==1){?>
                            <?php if($thegoods["fxje"]>0){?>
                            <p class="fxje"> 可返利<span class="greenfont"><?=$thegoods["fxje"]?></span> 元 </p> 
                            <?php }else{?>
                            <p> <span class="greenfont">暂无返利</span> </p>
                            <?php }?>
                            <?php }?>
                            <p>&nbsp;<a target="_blank" href="<?=$thegoods["jump"]?>">详情</a></p>
                        	</div>
                            <div style="clear:both"></div>
                            <div class="goodslist_main_right_tb">
                                <a target="_blank" href="<?=$thegoods["url"]?>"><div class="goodslist_main_right_bj"></div></a>
                                <a target="_blank" rel="nofollow" href="<?=$thegoods['jump']?>"><div class="goodslist_main_right_buy">去拍拍购买</div></a>
                            </div>
                        </div>
                        </li>

                    <li style="height:20px; overflow:hidden; font-weight:bold; font-size:14px; color:#F30;">&nbsp;同名商品</li>
                    <?php }?>
                    <?php foreach($goods as $row) {?>
                        <li class="info">
                        <div class="goodslist_main_left">
                        	<div class="goodslist_main_left_img"><a class="taopic" rel="nofollow" href="<?=$row["jump"]?>" target="_blank" pic="<?=base64_encode($row["bigImg"])?>"><?=html_img($row["middleImg"],0,$row["title"])?></a></div>
                        	<div class="goodslist_main_left_bt title"><a target="_blank" rel="nofollow" href="<?=$row["jump"]?>"><?php echo $row["title"] ?></a></div>
                            <div class="goodslist_main_left_sell"><p>本期已售出<span><?php echo $row["saleNum"] ?> </span>件 <img alt="等级" src="http://static.paipaiimg.com/module/icon/credit/credit_s<?=$row["level"]?>.gif" align="absmiddle" /> </p> </div>
                            <div class="goodslist_main_left_seller"><p><div style="float:left; max-width:220px; _width:220px; overflow:hidden; white-space:nowrap; line-height:24px">卖家：<?=$row["nickName"]?></div><div style="float:left; margin-left:5px"><?=qq($row["uin"])?></div></p>
                            </div>
                        </div>
                        <div class="goodslist_main_right">
                        	<div class="goodslist_main_right_price">
                            <p class="price">拍拍价：<span><?=$row["price"]?></span> 元 </p> 
                            <?php if(FANLI==1){?>
                            <?php if($row["fxje"]>0){?>
                            <p class="fxje"> 可返<span class="greenfont"><?=$row["fxje"]?></span> 元 </p> 
                            <?php }else{?>
                            <p> <span class="greenfont">暂无返利</span> </p>
                            <?php }?>
                            <?php }?>
                            <p>&nbsp;<a target="_blank" href="<?=$row["jump"]?>">详情</a></p>
                        	</div>
                            <div style="clear:both"></div>
                            <div class="goodslist_main_right_tb">
                                <a target="_blank" href="<?=$row["url"]?>"><div class="goodslist_main_right_bj"></div></a>
                                <a target="_blank" rel="nofollow" href="<?=$row['jump']?>"><div class="goodslist_main_right_buy">去拍拍购买</div></a>
                            </div>
                        </div>
                        </li>
                    <?php }?>
                    </ul>
                </div>