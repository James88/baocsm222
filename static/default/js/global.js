                $(document).ready(function () {
				
		$("#wx-drop").hover(function(){
			$(this).find("span").toggle();
		});
		$("#mo-drop").hover(function(){
			$(this).find("span").toggle();
		});
		$("#me-drop").hover(function(){
			var width = $(this).width()+41;
			$(this).find("ul").width(width);
			$(this).find("ul").toggle();
		});
		$("#nv-drop").hover(function(){
			var width = $(this).width()+41;
			$(this).find("ul").width(width);
			$(this).find("ul").toggle();
		});
		
		$.get("<{:U('mall/ajaxcart',array('t'=>$nowtime))}>", function (data) {
			if(data.length < 3){
				$("#cart-num").html(data);
			}else{
				$("#cart-num").html("0");
			}
		}, 'html');
				
					 $("#search_form dt").click(function () {
						$("#search_form dd").toggle();
					 });
					 
                    $("#search_form dd a").click(function () {
                        $("#search_form").prop('action', $(this).attr('rel'));
                        $("#search_form dt span").html($(this).html());
                        $('#search_form dd').hide();
                    });
					
					 $("#nav-drop dl").hover(function () {
						$(this).find(".pop-nav").toggle();
					});
					
					 $("#nav-drop").hover(function () {
						$("#nav-drop .drop-box").toggle();
					});
					

                });
				
	function up(){
		$('html,body').animate({scrollTop:0},300);
	}