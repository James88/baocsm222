var baolock = 1;
var baonum = 1;
function showLoader(msg) {
    $("#loader").html(msg).show();
}

function hideLoader()
{
    $("#loader").hide();
}

function dingwei(page, lat, lng) {
    page = page.replace('llaatt', lat);
    page = page.replace('llnngg', lng);
    $.get(page, function (data) {
    }, 'html');
}


function ajaxLogin(){
	window.location.href = "/mobile/passport/login.html"; 
}

function loaddata(page, obj, sc) {
    var link = page.replace('0000', baonum);
    showLoader('正在加载中....');

    $.get(link, function (data) {
        if (data != 0) {
            obj.append(data);
        }
        baolock = 0;
        hideLoader();
    }, 'html');
    if (sc === true) {
        $(window).scroll(function () {
            if (!baolock && $(window).scrollTop() == $(document).height() - $(window).height()) {
                baolock = 1;
                baonum++;
                var link = page.replace('0000', baonum);
                showLoader('正在加载中....');
                $.get(link, function (data) {
                    if (data != 0) {
                        obj.append(data);
                    }
                    baolock = 0;
                    hideLoader();
                }, 'html');
            }
        });
    }
}


var input_array = Array();
$(document).ready(function () {
    $("input").each(function () {
        if (!$(this).val()) {
            $(this).val($(this).attr('placeholder'));
        }
        if ($(this).attr('type') == 'password') {
            input_array.push($(this).attr('name'));
            $(this).attr('type', 'text');
        }
    });
    $("input").focus(function () {
        if ($(this).val() == $(this).attr('placeholder')) {
            $(this).val('');
        }
        if (input_array.indexOf($(this).attr('name')) >= 0) {
            $(this).attr('type', 'password');
        }

    }).blur(function () {
        if ($(this).val() == '') {
            $(this).val($(this).attr('placeholder'));
        }
        if ($(this).attr('type') == 'password' && $(this).val() == $(this).attr('placeholder')) {
            input_array.push($(this).attr('name'));
            $(this).attr('type', 'text');
        }
    });
}); 