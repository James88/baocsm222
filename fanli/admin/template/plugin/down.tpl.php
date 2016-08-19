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

include(ADMINTPL.'/header.tpl.php');
if($update==1){
	$do='update';
	$word='补丁下载成功';
}
else{
	$do='install';
	$word='插件已经下载成功，选确认将开始安装，选取消不进行操作';
}
?>

<table cellspacing="0" width="100%" style="border:1px  solid #DCEAF7; border-bottom:0px; background:#E9F2FB;">
  <tr>
    <?php if($do=='update'){?>
    <td align="left" style="padding-bottom:3px; padding-top:3px">&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit"  class="myself" value="完成更新" onclick="anzhuang()"/></td>
    <?php }else{?>
    <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit"  class="myself" value="安装插件" onclick="anzhuang()"/></td>
    <?php }?>
    <td width="150px" align="right">共改动了 <b><?=$total?> </b> 个文件&nbsp;&nbsp;</td>
  </tr>
</table>
<table id="listtable"  style="text-align:left"  border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="100%" style="padding-top:3px; padding-bottom:3px">
    <div>
    <ol id="errorshow" style="text-align:left; line-height:20px">
    
    </ol>
    </div>
    <div align="left">&nbsp;&nbsp;&nbsp;&nbsp;改动文件：</div>
    </td>
  </tr>
  <tr>
    <td>
    <div align="left"><?php echo $file_content;?></div>
    
    </td>
  </tr>
  	<?php foreach ($file_list as $r){
		$tip='';
		if($r!='说明.txt'){
			$data=array('code'=>$code,'file'=>$r);
			$plugin_file_id=(int)$duoduo->select('plugin_file','id','code="'.$code.'" and file="'.$r.'"');
			if($plugin_file_id==0){
				if(!preg_match('#^/#',$r)){
					$path='/'.$r;
				}
				$update_tag=(int)$duoduo->select('file','id','`path`="'.$path.'"');
				$update_tag=$update_tag>0?1:0;
				$data['update_tag']=$update_tag;
				$duoduo->insert('plugin_file',$data);
			}
			if(!file_exists(DDROOT.'/'.$r)){
				$tip='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style=" color:red">文件覆盖失败，请人工上传（如果是说明性的txt文件，可忽略）</span>';
				?>
                <script>
                $('#errorshow').append('<li><?=$r.$tip?></li>');
                </script>
			<?php }
		}
	?>
  <tr>
    <td><div align="left">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $r.$tip;?></div></td>
  </tr>
  <?php }?>
</table>
<script language="javascript" type="text/javascript">
function anzhuang(){
	if(confirm("<?=$word?>")){
		location.href="<?=u('plugin','update',array('code'=>$code,'do'=>$do,'over'=>1))?>";
	}
}
</script>
<?php include(ADMINTPL.'/footer.tpl.php');?>