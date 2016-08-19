/*
**	Anderson Ferminiano
**	contato@andersonferminiano.com -- feel free to contact me for bugs or new implementations.
**	jQuery ScrollPagination
**	28th/March/2011
**	http://andersonferminiano.com/jqueryscrollpagination/
**	You may use this script for free, but keep my credits.
**	Thank you.
*/

(function( $ ){
	 
		 
 $.fn.scrollPagination = function(options) {
  	
		var opts = $.extend($.fn.scrollPagination.defaults, options);  
		var target = opts.scrollTarget;
		if (target == null){
			target = obj; 
	 	}
		opts.scrollTarget = target;
	 
		return this.each(function() {
		  $.fn.scrollPagination.init($(this), opts);
		});

  };
  
  $.fn.stopScrollPagination = function(){
	  return this.each(function() {
	 	$(this).attr('scrollPagination', 'disabled');
	  });
	  
  };
  
  $.fn.scrollPagination.loadContent = function(obj, opts){
	 var target = opts.scrollTarget;
	 var mayLoadContent = $(target).scrollTop()+opts.heightOffset >= $(document).height() - $(target).height();
	 if (mayLoadContent){
		 $(opts.ajax_loading_tip).fadeIn();	
		 if (opts.beforeLoad != null){
			opts.beforeLoad(); 
		 }
		 $(obj).children().attr('rel', 'loaded');
		 if(opts.contentData.open==0) return false;
		 opts.contentData.open=0;
		 scrollPaginationPage++;
		 opts.contentData.page=scrollPaginationPage;
		 $.ajax({
			  type: 'GET',
			  url: opts.contentPage,
			  data: opts.contentData,
			  success: function(data){
				opts.numLog++;
				data=data.Trim();
				if(opts.numLog>=opts.ajaxLoadNum || data=='' || data=='over'){
					
					$(opts.mainDiv).stopScrollPagination();
					if(opts.pageDiv!=''){$(opts.pageDiv).show();}
					if(opts.numLog>=opts.ajaxLoadNum){
						$(opts.ajax_loading_tip).hide();
					}
					else{
						$(opts.ajax_loading_tip).show().html(opts.overWord).fadeIn();
					}
				}

				$(obj).append(data); 
				
				var objectsRendered = $(obj).children('[rel!=loaded]');
				
				if (opts.afterLoad != null){
					opts.afterLoad(objectsRendered);	
				}
				opts.contentData.open=1;
				
			  },
			  error:function(XMLHttpRequest, textStatus, errorThrown){
			      //alert(XMLHttpRequest.status);
                  //alert(XMLHttpRequest.readyState);
                  //alert(textStatus);
			  }
		 });
	 }
	 
  };
  
  $.fn.scrollPagination.init = function(obj, opts){
	 var target = opts.scrollTarget;
	 $(obj).attr('scrollPagination', 'enabled');

	 $(target).scroll(function(event){
		if ($(obj).attr('scrollPagination') == 'enabled'){
	 		$.fn.scrollPagination.loadContent(obj, opts);		
		}
		else {
			event.stopPropagation();	
		}
	 });
	 
	 $.fn.scrollPagination.loadContent(obj, opts);
	 
 };
	
 $.fn.scrollPagination.defaults = {
      	 'contentPage' : null,
     	 'contentData' : {},
		 'beforeLoad': null,
		 'afterLoad': null	,
		 'scrollTarget': null,
		 'heightOffset': 0,
		 'ajaxLoadNum':0,
		 'numLog':0,
		 'mainDiv':'',
		 'pageDiv':'',
		 'ajax_loading_tip':'#ajax_goods_loading',
		 'overWord':'^_^ 没有了',
		 'open':1
 };	
})( jQuery );

function ajaxLoad(mainDiv,pageDiv,ajaxLoadNum,url,data,heightOffset,afterLoad){
	//scrollPaginationPage=1;
	heightOffset=heightOffset||500;
	$(mainDiv).scrollPagination({
		'contentPage': url,
		'contentData': data, 
		'scrollTarget': $(window),
		'heightOffset': heightOffset,
		'ajaxLoadNum':ajaxLoadNum,
		'mainDiv':mainDiv,
		'pageDiv':pageDiv,
		'numLog':0,
		'afterLoad': function(elementsLoaded){
			if(elementsLoaded){
				afterLoad($(elementsLoaded));
			}
			else{
				
			}
		}
	});
}