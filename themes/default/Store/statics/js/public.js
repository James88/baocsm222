var baolock = 1;
var baonum  = 1;
function showLoader(msg) {  
    //显示加载器.for jQuery Mobile 1.2.0  
    $.mobile.loading('show', {  
        text: msg ? msg : '加载中...', //加载器中显示的文字  
        textVisible: true, //是否显示文字  
        theme: 'a',        //加载器主题样式a-e  
        textonly: false,   //是否只显示文字  
        html: ""           //要显示的html内容，如图片等  
    });  
}  
  
//隐藏加载器.for jQuery Mobile 1.2.0  
function hideLoader()  
{  
    //隐藏加载器  
    $.mobile.loading('hide');  
}  

function dingwei(page,lat,lng){
    page = page.replace('llaatt',lat);
    page = page.replace('llnngg',lng);
    $.get(page,function(data){        
    },'html');
}


function loaddata(page,obj,sc){
    var link = page.replace('0000',baonum);
    //showLoader('正在加载中....');
    
    $.get(link,function(data){
        if(data != 0){
            obj.append(data);              
        }
        baolock = 0;
        //hideLoader();
    },'html');
    if(sc === true){
        $(window).scroll(function(){              
            if(!baolock && $(window).scrollTop() ==$(document).height() - $(window).height()  ){
                baolock = 1;
                baonum++;
                var link = page.replace('0000',baonum);
                //showLoader('正在为客官探路');
                $.get(link,function(data){
                    if(data != 0){
                        obj.append(data);               
                    } 
                    baolock = 0;         
                   // hideLoader();
                },'html');
            }           
        });
    }
    
}
