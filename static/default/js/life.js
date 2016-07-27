$(document).ready(function () {		
	$("#v-roll").slide({ mainCell:".bd ul",titCell:".hd",effect:"fold",autoPlay:true, delayTime:600,interTime:3000,autoPage:true});
	$("#v-roll").hover(function(){$(this).find(".prev,.next").stop(true,true).fadeTo("show",0.2) },function(){ $(this).find(".prev,.next").fadeOut()});
 });