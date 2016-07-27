// JavaScript Document
$(function(event){
    
    			
    $('#down_menu>ul>li>a').on('tap',function(event){
        event.preventDefault();
        $(this).parent().find('ul').toggle();
        $(this).parent().siblings().find('ul').hide()
    });
    
    $.mobile.ajaxEnabled = false; //不需要了  
    //增减数字

		
    //评价分

    $('#pinjia li span').on('tap',function(){
        $(this).addClass('checked').siblings().removeClass('checked');  //0.333

    });
			

    $('.register input,#down_menu .mega').attr('data-role','none');   // 去除注册页样式
		
			
    $('#mmi li').on('tap',function(event){   
        // 支付订单页checkd
						 
        $(this).find('input').attr('checked','checked');
        $(this).siblings().find('input').removeAttr('checked');
        $(this).addClass('active').siblings().removeClass('active');
    });
				
    $('.ooo').eq(0).css('display','block');  
   
		
   

		
})

