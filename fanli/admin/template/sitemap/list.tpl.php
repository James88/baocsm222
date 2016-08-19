<?php 
/**
 * ============================================================================
 * 版权所有 多多科技，保留所有权利。
 * 网站地址: http://soft.duoduo123.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/

if(!defined('ADMIN')){
	exit('Access Denied');
}
$top_nav_name=array(array('url'=>u('seo','list'),'name'=>'SEO设置'),array('url'=>u('sitemap','list'),'name'=>'网站地图'),array('url'=>u('seo','arr'),'name'=>'伪静态设置'),array('url'=>u('seo','set'),'name'=>'加密设置'));
include(ADMINTPL.'/header.tpl.php');

$sitesub_arr=array(
	array('title'=>'百度搜索网址提交入口','url'=>'http://zhanzhang.baidu.com/sitesubmit/index'),
	array('title'=>'360搜索引擎登录入口','url'=>'http://info.so.360.cn/site_submit.html'),
	array('title'=>'360新闻源收录入口','url'=>'http://info.so.360.cn/news_submit.html'),
	array('title'=>'Google网址提交入口','url'=>'https://www.google.com/webmasters/tools/submit-url?pli=1'),
	array('title'=>'Google新闻网站内容','url'=>'http://www.google.com/support/news_pub/bin/request.py?contact_type=suggest_content&hl=cn'),
	array('title'=>'搜狗网站收录提交入口','url'=>'http://www.sogou.com/feedback/urlfeedback.php'),
	array('title'=>'SOSO搜搜网站收录提交入口','url'=>'http://www.soso.com/help/usb/urlsubmit.shtml'),
	array('title'=>'即刻搜索网站提交入口','url'=>'http://zz.jike.com/submit/genUrlForm'),
	array('title'=>'盘古数据开放平台','url'=>'http://open.panguso.com/data/resource/url/new'),
	array('title'=>'bing(必应)网页提交登录入口','url'=>'http://www.bing.com/toolbox/submit-site-url'),
	array('title'=>'简搜搜索引擎登陆口','url'=>'http://www.jianso.com/add_site.html'),
	array('title'=>'雅虎中国网站登录口','url'=>'http://sitemap.cn.yahoo.com/'),
	array('title'=>'网易有道搜索引擎登录口','url'=>'http://tellbot.youdao.com/report'),
	array('title'=>'中搜免费登录服务','url'=>'http://register.zhongsou.com/NetSearch/frontEnd/free_protocol.htm'),
	array('title'=>'MSN必应网站登录口','url'=>'http://cn.bing.com/docs/submit.aspx?FORM=WSDD2'),
	array('title'=>'Alexa网站登录入口','url'=>'http://www.alexa.com/help/webmasters'),
	array('title'=>'TOM搜索网站登录口','url'=>'http://search.tom.com/tools/weblog/log.php'),
	array('title'=>'铭万网B2B(必途)网址登陆口','url'=>'http://search.b2b.cn/pageIncluded/AddPage.php'),
	array('title'=>'博客大全提交','url'=>'http://lusongsong.com/daohang/login.asp'),
	array('title'=>'蚁搜搜索网站登录口','url'=>'http://www.antso.com/apply.asp'),
	array('title'=>'快搜搜索网站登录口','url'=>'http://www.kuaisou.com/main/inputweb.asp'),
	array('title'=>'汕头搜索登录口','url'=>'http://www.stsou.com/join.asp'),
	array('title'=>'孙悟空搜索网站登录','url'=>'http://www.swkong.com/add.php'),
	array('title'=>'博客大全提交','url'=>'http://lusongsong.com/daohang/login.asp'),
	array('title'=>'天网网站登陆口','url'=>'http://home.tianwang.com/denglu.htm'),
	array('title'=>'速搜全球登陆口','url'=>'http://www.suso.com.cn/suso/link.asp'),
	array('title'=>'酷帝网站目录提交入口','url'=>'http://www.coodir.com/accounts/addsite.asp'),
	array('title'=>'快搜网站登陆口','url'=>'http://www.kuaisou.com/main/inputweb.asp'),
	array('title'=>'找人网登陆口','url'=>'http://m.zhaoren.net/djxunzhi.htm'),
	array('title'=>'爱读小说搜搜索引擎登录入口','url'=>'http://www.25xsw.com/search/url_submit.php'),
	array('title'=>'搜猫搜索引擎登录入口','url'=>'http://test.somao123.com/search/url_submit.php'),
	array('title'=>'泽许搜索网站登录入口','url'=>'http://wap.zxyt.cn/guide/?m=adc4&Nsid=b936a850e4a451c2/&wver=c'),
	array('title'=>'一淘网开放搜索申请入口','url'=>'http://open.etao.com/apply_intro.htm?spm=0.0.0.0.Voi9lJ'),
	array('title'=>'站长之家网站排行榜','url'=>'http://top.chinaz.com/include.aspx'),
	array('title'=>'爱搜搜索引擎登录入口','url'=>'http://www.aiso0.com/search/url_submit.php')
);
?>

<div class="explain-col" style="margin:5px 0 5px 0;">
    <table cellspacing="0" width="600px">
    	<tr>
            1.点击【生成网站地图】生成网站地图<br />
            2.<a target="_blank" href="http://www.baidu.com/#wd=%E5%A6%82%E4%BD%95%E6%8F%90%E4%BA%A4%E7%BD%91%E7%AB%99%E5%9C%B0%E5%9B%BE&rsv_spt=1&issp=1&rsv_bp=0&ie=utf-8&tn=baiduhome_pg&rsv_sug3=16&rsv_sug4=641&rsv_sug1=11&inputT=12094">去搜索引擎提交 </a><br />
            html文件：<?=file_exists(DDROOT.'/sitemap.html')?'<a target="_blank" href="'.SITEURL.'/sitemap.html">'.SITEURL.'/sitemap.html</a>':'请先生成'?><br />
            xml文件：<?=file_exists(DDROOT.'/sitemap.xml')?'<a target="_blank" href="'.SITEURL.'/sitemap.xml">'.SITEURL.'/sitemap.xml</a>':'请先生成'?>
        </tr>
    </table>
</div>
<form name="form1" action="" method="get">
<table cellspacing="0" width="100%" style="border:1px  solid #DCEAF7; border-bottom:0px; background:#E9F2FB;">
        <tr>
              <td width="360px">&nbsp;<img src="images/arrow.gif" width="16" height="22" align="absmiddle" />&nbsp;&nbsp;<a href="<?=u('sitemap','list',array('do'=>'jty'))?>" class="link3">【生成网站地图】</a><?php if($total > 0){?>&nbsp;&nbsp;<?php }?></td>
             <!-- <td width="" align="right">关键字：<input type="text" name="title" value="<?=$title?>" />&nbsp;<input type="submit" value="搜索" /></td>
              <td width="150px" align="right">共有 <b><?php echo $total;?></b> 条记录&nbsp;&nbsp;</td>-->
            </tr>
      </table>
      <input type="hidden" name="mod" value="<?=MOD?>" />
      <input type="hidden" name="act" value="<?=ACT?>" />
      </form>
      <form name="form2" method="get" action="" style="margin:0px; padding:0px">
                  <table id="listtable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
                    <tr>
                      <th style="text-align:right; width:280px">提交平台：</th>
                      <th style="text-align:left; padding-left:10px">地址</th>
                    </tr>
                    <?php foreach($sitesub_arr as $v){?>
					  <tr>
                        <td style="text-align:right; width:280px"><?=$v['title']?>：</td>
                        <td style="text-align:left; padding-left:10px"><a href="<?=$v['url']?>" target="_blank"><?=$v['url']?></a></td>
					  </tr>
                      <?php }?>
                  </table>
				<div style="position:relative; padding-bottom:10px">
            <input type="hidden" name="mod" value="<?=MOD?>" /><input type="hidden" name="act" value="del" />
            <!--<div style="position:absolute; left:5px; top:5px"><input type="submit" value="删除" onclick='return confirm("确定要删除?")'/></div>-->
            <!--<div class="megas512" style=" margin-top:15px;"><?=pageft($total,$pagesize,u(MOD,'list',$page_arr));?></div>-->
            </div>
       </form>
<?php include(ADMINTPL.'/footer.tpl.php');?>