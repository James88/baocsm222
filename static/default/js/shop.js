$.ajaxSetup ({ 
    cache: false
});
var  lock  = 0;


function loading(){
    var boxHtml = '<div class="niumsgbox"></div>';
   
    if($(".niumsgbox").length  ==  0){
        $("body").append(boxHtml);
    }
    $(".niumsgbox").html('<img src="/static/default/images/loading.gif" /><span style="color:blue;">正在加载中...</span>');
    $(".niumsgbox").show();
    lock = 1;
}

function LoginSuccess(){
    $(".niumsgbox").show();
    $(".niudialog").remove();
    success('登录成功',3000,"loginCallback()");
}

function loginCallback(){
    $.get("/index.php?m=passport&a=check&mt="+Math.random(),function(data){
        $(".topOne").find('.left').html(data); 
    },'html');
    return true;
}

function ajaxLogin(){
    hidde();
    var boxHtml = '<div class="niudialog"></div>';
    if($(".niudialog").length  ==  0){
        $("body").append(boxHtml);
        $(".niudialog").css('height',document.body.scrollHeight + 'px');
    }
    var url = '/index.php?g=home&m=passport&a=ajaxloging&t='+Math.random();    
    var width = document.body.clientWidth
    $.get(url,function(data){
       
        $(".niudialog").html('<div class="niudialog_bg"></div>'+data);
        var left =  (width - 616)/2;
        var top = $(window).scrollTop() + 200;
        $(".loginPop").css({
            'left':left+'px',
            'top':top+'px'
            });
        
        $(".niudialog").show();
    },'html');    

}

function success(msg,timeout,callback){
    var boxHtml = '<div class="niumsgbox"></div>';
    if($(".niumsgbox").length  ==  0){
        $("body").append(boxHtml);
    }
    
    $(".niumsgbox").html('<img src="/static/default/images/right.gif" /><span  style=" color: green;">'+msg+'</span>');
    $(".niumsgbox").show();
    setTimeout(function(){
        lock = 0;
        $(".niumsgbox").hide();
        eval(callback);
    },timeout ? timeout : 3000);
}
function error(msg,timeout,callback){
    var boxHtml = '<div class="niumsgbox"></div>';
    if($(".niumsgbox").length  ==  0){
        $("body").append(boxHtml);
    }
    $(".niumsgbox").html('<img src="/static/default/images/wrong.gif" /><span  style=" color: red;">'+msg+'</span>');
    $(".niumsgbox").show();
    setTimeout(function(){
        lock = 0;
        $(".niumsgbox").hide();
        eval(callback);           
    },timeout ? timeout : 3000);
}

function hidde(){
    $(".niumsgbox").hide();
    lock = 0;
}

function jumpUrl(url){
    if(url){
        location.href=url;
    }else{
        history.back(-1);
    }
}
    
function yzmCode(){ //更换验证码
    $(".yzm_code").click();
}  



$(document).ready(function(e){
  
    $(document ).on("click","input[type='submit']",function(e){
        e.preventDefault();
        if(!lock){
            loading();
            if($(this).attr('rel')){
                $("#"+$(this).attr('rel')).submit();
            }else{
                $(this).parents('form').submit();    
            }
        }         
    }); 
    $(document).on('click','.yzm_code',function(){
        $("#"+$(this).attr('rel')).attr('src','/index.php?m=public&a=verify&mt='+Math.random());
    });
    
    $(document).on("click","a[mini='act']",function(e){
        e.preventDefault();
        if(!lock){
            loading();
            
            $("#w-frame").attr('src',$(this).attr('href'));      
        }  
    });
    
     $(document).on("click","a[mini='buy']",function(e){ //购买的算法
        e.preventDefault();
        if(!lock){
            loading();
            var url = $(this).attr('href');
            if(url.indexOf('?') >0){
                url+='&num='+$('#'+$(this).attr('rel')).val();
            }else{
                url+='?num='+$('#'+$(this).attr('rel')).val();
            }
            $("#w-frame").attr('src',url);      
        }  
    });
    $(document).on("click","a[mini='tuan']",function(e){ //购买的算法
        e.preventDefault();
        if(!lock){
            lock=1;
            var url = $(this).attr('href');
            if(url.indexOf('?') >0){
                url+='&num='+$('#'+$(this).attr('rel')).val();
            }else{
                url+='?num='+$('#'+$(this).attr('rel')).val();
            }
           location.href= url;    
        }  
    });
    
    
    $(document).on("click","a[mini='load']",function(e){ //前台的MINILOAD 重构了
        e.preventDefault();
        var boxHtml = '<div class="niudialog"></div>';
        if($(".niudialog").length  ==  0){
            $("body").append(boxHtml);
            $(".niudialog").css('height',document.body.scrollHeight + 'px');
        }
        if(!lock){
            loading();
            var href = $(this).attr('href');
            if(href.indexOf('?') >0){
                href+='&mini=load';
            }else{
                href+='?mini=load'; //ajax 的判断
            }
             
            $.get(href,function(data){
               
                hidde();
                if(data == 0){
                    ajaxLogin();
                }else{
                    $(".niudialog").html('<div class="niudialog_bg"></div>'+data);
                    $(".niudialog").show();
                }                
            },'html');
        }
    });
    $(document).on("click",".niu_closed",function(e){
        e.preventDefault();
        hidde();
        $('.niudialog').hide();
    });
    
    //全选
    $(document).on("click",".checkAll",function(e){
        var child = $(this).attr('rel');
        $(".child_"+child).prop('checked',$(this).prop("checked"));
    });
    


   
    
    $(".jq_opacity_img img").mouseover(function(){
        $(this).stop().animate({
            opacity:'0.5'
        },300);
    }).mouseout(function(){
        $(this).stop().animate({
            opacity:'1'
        },300);
    });
    

   
});





var sArray=new Object;sArray[0]=new Image;sArray[0].src="/static/default/images/icon_star_1.gif";for(var i=1;i<6;i++){sArray[i]=new Image();sArray[i].src="/static/default/images/icon_star_2.gif"}var starTimer;var pro;var rate;initStar();function initStar(){try{setProfix("datascore_");showStars(document.getElementById("datascore").value,'datascore');setProfix("datascore1_");setStars(document.getElementById("datascore1").value,'datascore1');setProfix("datascore2_");setStars(document.getElementById("datascore2").value,'datascore2');setProfix("datascore3_");setStars(document.getElementById("datascore3").value,'datascore3')}catch(e){}}function showStars(starNum,rate){try{clearStarTimer();greyStars();colorStars(starNum)}catch(e){}}function setProfix(profix){pro=profix}function colorStars(starNum){try{for(var i=1;i<=starNum;i++){var tmpStar=document.getElementById(pro+i);tmpStar.src=sArray[starNum].src}}catch(e){}}function greyStars(){try{for(var i=1;i<6;i++){var tmpStar=document.getElementById(pro+i);tmpStar.src=sArray[0].src}}catch(e){}}function greyAll(curpro,currate){try{document.getElementById(currate).value="";for(var i=1;i<6;i++){var tmpStar=document.getElementById(curpro+i);tmpStar.src=sArray[0].src}}catch(e){}}function setStars(starNum,rate){rate=rate;try{clearStarTimer();var rating=document.getElementById(rate);rating.value=starNum;showStars(starNum)}catch(e){}}function clearStars(currate){rate=currate;try{var rating=document.getElementById(rate);if(rating.value!=''){setStars(rating.value,rate)}else{greyStars()}}catch(e){}}function resetStars(){try{clearStarTimer();var rating=document.getElementById(rate);if(rating.value!=''){setStars(rating.value,rate)}else{greyStars()}}catch(e){}}function clearStarTimer(){if(starTimer){clearTimeout(starTimer);starTimer=null}}








