<?php
include(TPLPATH.'/inc/header.tpl.php');
?>
<style type="text/css">
.qa {
	padding: 0 0 0 60px;
}

#jmain .jfb_top { 
    background:url(<?=TPLURL?>/inc/images/jfb_01.png);
	width:998px; 
	height:193px; 
	margin-left:-24px;
}

#jmain .qa h2 {
	font-size: 20px;
	font-weight: bolder;
	border-left: 4px solid #ff6300;
	line-height: 22px;
	text-indent: 0.6em;
	margin: 10px 0 10px 0;
}

#jmain .qa h3 {
	font-size: 16px;
	font-weight: bolder;
	/*border-left: 4px solid #ff6300;*/
	line-height: 20px;
	/*text-indent: 0.5em;*/
	margin: 15px 0 10px 15px;
}

#jmain .qa p {
	width: 810px;
	font-size: 14px;
	padding: 0 20px 0 15px;
	line-height: 28px;
	color: #7d7f7a;
}

.blockquote {
	display: block;
	width: 676px;
	padding: 5px;
	margin: 35px 0 15px 15px;
	border: 1px solid #ccc;
	background: #f1f1f1;
	font-size: 18px;
	font-weight: bolder;
}
.link {
	color:#fe4e00;
	font-weight:bolder;
	/*text-decoration: underline;*/
}
</style>
<div class="biaozhun5" style="width:1000px; background:#FFF;  margin:auto; margin-top:10px; padding-bottom:10px">
	<div id="jmain" style="width:950px; margin:auto;">
         <div class="jfb_top" >
         <div style="width:487px; font-size:40px; text-align:right; padding-top:45px; *padding-top:48px; padding-top:48px\9;"><b><?=WEBNAME?><?=TBMONEY?></b></div>
         <div style="width:713px; font-size:16px; text-align:right; margin-top:10px; font-weight:bold">
		 <?=TBMONEYBL?><?=TBMONEYUNIT?><?=TBMONEY?> = 1元！淘宝购物，还款缴费，直接当钱花！</div> 
         </div>
        
        <?php if(TBMONEY!='集分宝'){?>
        <div class="qa">
			<li><h2>什么是<?=TBMONEY?>？如何获得<?=TBMONEY?>？</h2></li>
			<p><?=TBMONEY?>是由<?=WEBNAME?>特有的一种积分服务，具有人民币价值。
				<br/>主要通过以下几种方式获得：
				<br/>1、购物返利得<?=TBMONEY?>；
				<br/>2、登录<?=WEBNAME?>，进会员中心，签到得<?=TBMONEY?>；
				<br/>3、参加网站活动得<?=TBMONEY?>（多多关注网站活动并积极参与）。
			</p>
		</div>
        <div class="qa">
			<li><h2>如何查看我有多少<?=TBMONEYUNIT?><?=TBMONEY?>？如何使用<?=TBMONEY?>？</h2></li>
            <p>登录<?=WEBNAME?>，进会员中心即可看到。<a class="link" target="_blank" href="<?=u('user','index')?>">马上查看>></a>
            	<br/><?=WEBNAME?>的<?=TBMONEYBL?><?=TBMONEYUNIT?><?=TBMONEY?>相当于1元哦！可以做以下用途：
				<br/>1、兑换集分宝；
				<br/>2、兑换实物商品；
				<br/>3、兑换电话费，QQ等虚拟商品；<a class="link" target="_blank" href="<?=u('huan','list')?>">马上兑换>></a>
			</p>
		</div>
        <?php }?>
		<div class="qa">
			<li><h2>什么是集分宝？返利兑换集分宝有什么好处？</h2></li>
			<p>集分宝是由支付宝提供的积分服务，具有人民币价值，100个集分宝可抵扣1元钱。
				<br/>集分宝可以<span class="link">直接当人民币花</span>，而且用途范围很广。主要有以下几种：
				<br/>1、支持在淘宝网、天猫商城等网站抵人民币购物；
				<br/>2、支持还信用卡、缴水电煤；
				<br/>3、兑彩票/礼品；
				<br/>4、给需要帮助的人们捐款，贡献一份爱心。
			</p>
		</div>
		<div class="qa">
			<li><h2>返利如何兑换到集分宝？</h2></li>
			<p><?=WEBNAME?>已与支付宝集分宝进行深入合作，您在<?=WEBNAME?>获得的返利收入（包含<?=TBMONEY?>）可随时申请兑换。返利兑换集分宝过程中的所有手续费成本，由<?=WEBNAME?>承担，您无需支付任何额外费用。
			<br/>为了保障您的资金安全，一般情况下，您申请兑换后，一般情况下会在1个工作日内处理。<a class="link" target="_blank" href="<?=u('huan','list')?>">马上兑换>></a>
			</p>		
		</div>
		<div class="qa">
			<li><h2>如何使用集分宝？</h2></li>
			<p>集分宝使用场景较多，在支付宝收银台付款时，可抵扣相应人民币。主要推荐以下使用方式：
			<br/><br/><img src="<?=TPLURL?>/inc/images/jfb_07.png" width="631" height="33" alt="" /><br/>
			</p>
		</div>
        <div class="qa">
		<span class="blockquote">集分宝使用流程：</span>
		<h3>1、购物、还款、缴费</h3>
		<p>您可以到淘宝网、天猫商城等网站购物，还可以通过支付宝还信用卡、缴水电煤。付款操作进行到支付宝收银台页面 时便均可进行抵现操作。
			<br/><img src="<?=TPLURL?>/inc/images/jfb_10.png" width="718" height="476" alt="" />
		</p>
 		<h3>2、支付宝付款</h3>
		<p>进入到支付宝收银台后，页面上部会显示可用集分宝数量(余额满10个便可抵现)，点击“使用”链接。
			<br/><img src="<?=TPLURL?>/inc/images/jfb_14.png" width="724" height="298" alt="" />
		</p>
 		<h3>3、集分宝抵扣人民币</h3>
		<p>输入要抵现的集分宝数量，点击“确定”按钮。
			<br/><img src="<?=TPLURL?>/inc/images/jfb_17.png" width="717" height="383" alt="" />
		</p>
		<h3>4、抵扣后支付余额</h3>
		<p>
			系统自动换算抵扣金额，您可以继续往下付款，输入兑换后需支付的余额。
			<br/><img src="<?=TPLURL?>/inc/images/jfb_21.png" width="716" height="313" alt="" />
		</p>
		<h3>5、付款成功</h3>
		<p>
			大功告成，付款成功后集分宝对应数量将自动扣除。如果付款失败，集分宝将不会扣掉，可以继续使用。
			<br/><img src="<?=TPLURL?>/inc/images/jfb_23.png" width="719" height="316" alt="" />
		</p>
		<p style="font-weight:bolder;padding:20px;">怎么样，集分宝很好用吧？<br />还不赶紧试试<a class="link" target="_blank" href="<?=u('huan','list')?>">返利兑换集分宝</a>，让你网购省钱更便捷！</p>		
		</div>
	</div>
<div style="clear:both"></div>
</div>


<?php 
include(TPLPATH.'/inc/footer.tpl.php');
?>