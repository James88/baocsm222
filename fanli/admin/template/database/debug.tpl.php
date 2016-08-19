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
include(ADMINROOT.'/mod/public/part_set.act.php');
include(ADMINTPL.'/header.tpl.php');
?>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" style="font-size:12px" method="post" name="form1">
<table id="addeditable"  align="center" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
						<tr>
                        <td align="right">敏感词替换策略：</td>
                        <td>&nbsp;
                        <?=select(array('0'=>'模式0','1'=>'模式1','2'=>'模式2','3'=>'模式3'),REPLACE,'REPLACE')?>
                           <span class="zhushi"><a href="<?=u('noword','list')?>">敏感词管理</a>&nbsp;模式0为不替换，模式1为替换敏感词，模式2为停止网页，模式3模糊匹配拆分词组，并停止网页</span>
                         </td>
                      </tr>
                      <tr>
                        <td width="125" align="right">url传递：</td>
                        <td>&nbsp;
                        	<?=html_radio(array('0'=>'关闭','1'=>'开启'),$webset['url_cookie'],'url_cookie');?>
                           <span class="zhushi">跳转到淘宝的url不作为网址参数传递（跳转有问题的网站才开启，正常网站要关闭）</span>
                        </td>
                      </tr>
                      
                      <tr>
                        <td width="125" align="right">搜索淘宝网址：</td>
                        <td>&nbsp;
                        	<?=html_radio(array('0'=>'关闭','1'=>'开启'),TAO_SEARCH_URL,'TAO_SEARCH_URL');?>
                           <span class="zhushi">搜允许索淘宝网址，技术人员调试使用，站长不要开启，属于违规操作！</span>
                        </td>
                      </tr>
                      <tr>
                        <td align="right">sql日志：</td>
                        <td>&nbsp;
                        <?=html_radio(array('0'=>'关闭','1'=>'开启'),$webset['sql_log'],'sql_log');?>
                           <span class="zhushi">储存路径 data/temp/sql</span>
                       </td>
                      </tr>
                      <tr>
                        <td align="right">sql错误日志：</td>
                        <td>&nbsp;
                        <?=html_radio(array('0'=>'关闭','1'=>'开启'),$webset['sql_debug'],'sql_debug');?>
                          <span class="zhushi">储存路径 data/temp/error_sql</span></td>
                      </tr>
                      <tr>
                        <td align="right">淘宝错误日志：</td>
                        <td>&nbsp;
                           <?=html_radio(array('0'=>'关闭','1'=>'开启'),$webset['errorlog'],'errorlog');?>
                           <span class="zhushi"> 储存路径 data/temp/taoapi_error_log</span></td>
                      </tr>
                      <tr>
                        <td align="right">拍拍错误日志：</td>
                        <td>&nbsp; <?=html_radio(array(0=>'关闭',1=>'开启'),$webset['paipai']['errorlog'],'paipai[errorlog]')?>&nbsp;<span class="zhushi">储存路径 data/temp/paipai_error_log</span></td>
                      </tr>
                      <tr>
                        <td height="32" align="right">&nbsp;</td>
                  <td>&nbsp;
                          <input type="submit" class="myself" name="sub" value=" 保 存 设 置 " /> 
                          </td>
                      </tr>
                      <tr>
                        <td align="right">&nbsp;注意：</td>
                  <td>&nbsp;<span class="zhushi">以上设置为网站技术操作，其他人不要操作。</span></td>
                      </tr>
                    </table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>