// JavaScript Document
$(function(){
	$("a.taopic").live('mouseover',function(e){
		$(this).find('img').attr('alt','');
		$(this).find('img').attr('title','');
		var topx = 120;
		var positionX=e.originalEvent.x-$(this).offset().left||e.originalEvent.layerX||0;
		var positionY=e.originalEvent.y-$(this).offset().top||e.originalEvent.layerY||0;
		var imgSrc = decode64($(this).attr('pic'));
		$('#layerPic .photo').html('<img src="'+imgSrc+'" />');
		$('#layerPic').css('display', 'block');
		var imgH = $('#layerPic img')[0].height;
		if (imgH>200) {
			$('#layerPic img').css('height', '200px');
			imgH = 200;
		}
		var imgX = $(this).offset().left;
		var imgY = $(this).offset().top;
		var layX = imgX + 100;
		var layY = imgH + 70;
		var toTop = $(document).scrollTop() - $(this).offset().top;
		if (toTop>0) {
			layY += toTop;
			toTop = 20;
		} else {
			var toTop = $(this).offset().top - $(document).scrollTop() + imgH + 20 - $(window).height();
			if (toTop>0) {
				layY -= toTop;
				if (toTop>imgH) toTop = imgH;
			} else toTop = 20;
		}

		$('#layerPic').css('left', layX+'px');
		$('#layerPic').css('top', layY+'px');
		$('#layerPic .sell_bg').css('top', (toTop+20)+'px');
		$("a.taopic").mouseout(function(e){
			$('#layerPic').css('display', 'none');						  
		});
	});
});