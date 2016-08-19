<div class="zdm-aside" style=" float:left;margin-left:10px">
  <div class="zdm-box">
    <div class="hd aside-ranking clearfix">
      <h3 class="l money"> <i></i>最火爆料 </h3>
    </div>
    <div class="bd J-item-wrap huobao" data-boxname="pingce">
      <ul>
        <?php foreach($huo_goods as $row){?>
        <li class="aside-ranking-item"> <a href="<?=$row['url']?>" class="J-item-track" title="<?=$row['title']?>" target="_blank" >
          <p>
            <?=dd_html_img($row['img'],$row['title'],120)?>
          </p>
          <p class="text">
            <?=$row['title']?>
          </p>
          </a>
          <div class="comment-num"> <i> </i> <?=$row['ding']?> </div>
        </li>
        <?php }?>
      </ul>
    </div>
  </div>
</div>
