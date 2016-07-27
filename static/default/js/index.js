$(document).ready(function () {
	$("#index-life").slide({mainCell:".bd",autoPlay:false});
	$("#post-list").slide({mainCell:"ul",autoPage:true,effect:"top",autoPlay:true,vis:4});
	$("#main-roll").slide({ mainCell:".bd ul",titCell:".hd",effect:"fold",autoPlay:true, delayTime:600,interTime:3000,autoPage:true});
	$("#main-roll").hover(function(){$(this).find(".prev,.next").stop(true,true).fadeTo("show",0.2) },function(){ $(this).find(".prev,.next").fadeOut()});
	$("#tuan-roll").slide({ mainCell:".bd ul",titCell:".hd",effect:"fold",autoPlay:true, delayTime:600,interTime:3000,autoPage:true});
	$("#tuan-roll").hover(function(){$(this).find(".prev,.next").stop(true,true).fadeTo("show",0.2) },function(){ $(this).find(".prev,.next").fadeOut()});
 });