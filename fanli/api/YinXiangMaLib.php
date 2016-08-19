<?php
/*
 * Copyright (c) 2011 by YinXiangMa.com
 * Author: HongXiang Duan, YiQiang Wang, ShuMing Hu
 * Created: 2011-5-5
 * Function: YinXiangMa API php code
 * Version: v3.0
 * Date: 2012-12-01
 * PHP library for YinXiangMa - 印象码 - 验证码广告云服务平台.
 *    - Documentation and latest version
 *          http://www.YinXiangMa.com/
 *    - Get a YinXiangMa API Keys
 *          http://www.YinXiangMa.com/server/signup.php
 */


/********************************************************************************************
 * 以下内容请不要改动。如果改动，可能会有错误发生。
 * "印象码 - 验证码广告云服务平台"。
 ********************************************************************************************
 */
define("PRIVATE_KEY",$webset['yinxiangma']['private_key']);
define("PUBLIC_KEY",$webset['yinxiangma']['public_key']);
dd_session_start();
function YinXiangMa_ValidResult($YinXiangMaToken,$level,$YXM_input_result){	
	if($YXM_input_result==md5("true".PRIVATE_KEY.$YinXiangMaToken)) { $result= "true"; }
	else { $result= "false"; }
	return $result;
}

function YinXiangMa_GetYinXiangMaWidget(){
	
	$YinXiangMaWidgetHtml="<script type='text/javascript' charset='gbk'>
		function YXM_valided_true()
		{
			$('.register_b').attr('disabled',false);
			//document.getElementById('ajax_valid_result').value = '验证码输入正确！';
		}
		function YXM_valided_false()
		{
			$('.register_b').attr('disabled','disabled');
		}
		</script>
        <script type='text/javascript' charset='gbk'>
		var YXM_PUBLIC_KEY = '".PUBLIC_KEY."';//这里填写PUBLIC_KEY
		var YXM_localsec_url = '".SITEURL."/api/YinXiangMa_Local/';//这里设置应急策略路径
		function YXM_local_check()
		{
		if(typeof(YinXiangMaDataString)!='undefined')return;
		YXM_oldtag = document.getElementById('YXM_script');
		var YXM_local=document.createElement('script');
		YXM_local.setAttribute('type','text/javascript');
		YXM_local.setAttribute('id','YXM_script');
		YXM_local.setAttribute('src',YXM_localsec_url+'yinxiangma.js?pk='+YXM_PUBLIC_KEY+'&v=YinXiangMa_PHPSDK_3.0');
		YXM_oldtag.parentNode.replaceChild(YXM_local,YXM_oldtag);  
		}
		setTimeout('YXM_local_check()',2000);
		document.write(\"<input type='hidden' id='YXM_here' /><script type='text/javascript' charset='gbk' id='YXM_script' async src='http://api.yinxiangma.com/api2/yzm.yinxiangma.php?pk=\"+YXM_PUBLIC_KEY+\"&v=YinXiangMaPHPSDK_3.0'><\"+\"/script>\");
		</script>";

	
	return $YinXiangMaWidgetHtml;
}
?>