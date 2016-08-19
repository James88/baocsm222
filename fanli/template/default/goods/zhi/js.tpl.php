<?php
if(!defined('INDEX')){
	exit('Access Denied');
}
?>
<script>
function comment($t){
	var comment=$t.parents('.zdm-expand-pub-comment').find('.J-add-comment').val();
	var data_id=$t.attr('data_id');
	var data={comment:comment,data_id:data_id,'do':'comment','sub':1};
	$.getJSON('<?=CURURL?>/template/<?=MOBAN?>/goods/zhi/ajax.php',data,function(data){
		if(data.s==0){
			alert(data.r);
		}
		else{
			$t.parents('.zdm-expand-comment').prepend(data.r);
			$t.parents('.zdm-expand-pub-comment').find('.J-success-status').show();
			setTimeout(function(){
				$t.parents('.zdm-expand-pub-comment').find('.J-success-status').hide();
				$t.parents('.zdm-expand-pub-comment').find('.J-add-comment').val('');
				var $a=$t.parents('.zdm-expand-wrap').prev('.J-expend-wrap-before').find('.item-view-comment');
				$a.html(parseInt($a.html())+1);
			},500);
		}
	});
}
$.ajaxSetup ({ 
    cache: false //关闭AJAX相应的缓存
});

function goodsVote($t){
	if(DDUID==0){
		alert('登录后才能评论');
		return false;
	}
	var id=$t.attr('data-id');
	var type=$t.attr('data-type');
	var data={type:type,id:id,'do':'vote'};
	
	$.getJSON('<?=CURURL?>/template/<?=MOBAN?>/goods/zhi/ajax.php',data,function(data){
		if(data.s==1){
			$t.html(parseInt($t.html())+parseInt(data.r));
		}
		else{
			alert(data.r);
		}
	});
}

function goodsComment($t){
	var data_id=$t.attr('data-id');
	$s=$t.parent('.item-vote').next(".J-expend-wrap");
	$s.toggle();
	var data={data_id:data_id,'do':'comment'};
	$.get('<?=CURURL?>/template/<?=MOBAN?>/goods/zhi/ajax.php',data,function(data){
		$s.find('.zdm-expand-comment').html(data);
	})
}

function goodsItemToggle($t){
	var a=$t.attr('data-status');
	if(a==0){
		$t.find('a').html('收起全文 ∧');
		var $p=$t.prev('.nodelog-detail');
		$p.css('max-height','none');
		$t.attr('data-status',1);
	}
	else{
		$t.find('a').html('展开全文 ∨');
		var $p=$t.prev('.nodelog-detail');
		$p.css('max-height','200px');
		$t.attr('data-status',0);
	}
}
</script>