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

if($dopost=='redat')
{
	
	if($bakfiles=='')
	{
		PutInfo('没指定任何要还原的文件!');
		dd_exit();
	}
	$bakfilesTmp = $bakfiles;
	$bakfiles = explode(',',$bakfiles);
	if(empty($structfile))
	{
		$structfile = "";
	}
	if(empty($delfile))
	{
		$delfile = 0;
	}
	if(empty($startgo))
	{
		$startgo = 0;
	}
	if($startgo==0 && $structfile!='')
	{
		/*$tbdata = '';
		$fp = fopen("$bkdir/$structfile",'r');
		while(!feof($fp))
		{
			$tbdata .= str_replace($phpstart,'',fgets($fp,1024));
		}
		fclose($fp);
		$querys = explode(';',$tbdata);
        
		if($keepdb!=1){
		    foreach($querys as $q){
			    mysql_query(trim($q).';');
			}
		}
		else{
		    $sql = "Show Tables";
            $query = mysql_query($sql);
            while ($row = mysql_fetch_array($query)) {
                $sql="TRUNCATE TABLE `".$row[0]."`"; 
				mysql_query($sql);
	        }
		}
		if($delfile==1)
		{
			@unlink("$bkdir/$structfile");
		}*/
		$tmsg = "<font color='red'>完成数据表信息还原，准备还原数据...</font>";
		$doneForm = "<form name='gonext' method='post' action='index.php?mod=data&act=backup&dopost=redat'>
        <input type='hidden' name='startgo' value='1' />
        <input type='hidden' name='delfile' value='$delfile' />
        <input type='hidden' name='bakfiles' value='$bakfilesTmp' />
		<input type='hidden' name='date' value='$date' />
		<input type='hidden' name='keepdb' value='$keepdb' />
		</form>\r\n{$dojs}\r\n";
		PutInfo($tmsg,$doneForm);
	}
	else
	{
		$nowfile = $bakfiles[0];
		$bakfilesTmp = preg_replace('/'.$nowfile."[,]{0,1}/","",$bakfilesTmp);
		$oknum=0;
		$bkdir=DDBACKUPDATA.'/backupdata_'.$date;
		if( filesize("$bkdir/$nowfile") > 0 )
		{
			$a=file_get_contents($bkdir.'/'.$nowfile);
			$a=str_replace($phpstart,'',$a);
			if($keepdb==1){
			    $name_arr=explode('_',$bkdir.'/'.$nowfile);
				if($name_arr[2]==0){
				    $b=explode('/*duoduo table info cup*/;',$a);
					$a=$b[1];
				}
			}
			
            $b=explode(";\r\n",$a);
            foreach($b as $k=>$line){
				$line=trim($line);
				if($line!=''){
				    $rs = mysql_query($line);
				    if($rs){
					    $oknum++;
				    }
				    else{
				        //echo mysql_error();
					    //dd_exit($line);
				    }
				}
            }
		}
		if($delfile==1)
		{
			unlink("$bkdir/$nowfile");
		}
		if($bakfilesTmp=="")
		{
			PutInfo('成功还原所有的文件的数据!');
			if($delfile==1){
		        rmdir($bkdir);//删除目录，可能会不好用，提示权限不足，暂时没有找到解决办法
			}
			dd_exit();
		}
		$tmsg = "成功还原{$nowfile}的{$oknum}条记录<br/><br/>正在准备还原其它数据...";
		$doneForm = "<form name='gonext' method='post' action='index.php?mod=data&act=backup&dopost=redat'>
		<input type='hidden' name='startgo' value='1' />
		<input type='hidden' name='delfile' value='$delfile' />
		<input type='hidden' name='bakfiles' value='$bakfilesTmp' />
		<input type='hidden' name='date' value='$date' />
		<input type='hidden' name='keepdb' value='$keepdb' />
		</form>\r\n{$dojs}\r\n";
		PutInfo($tmsg.$doneForm);
	}
}

$a=glob(DDBACKUPDATA.'/backupdata_*');
$j=0;
if(empty($a)){
	PutInfo("<font color='red'>您还没有创建备份文件</font>","");
	dd_exit();
}
foreach($a as $filename){
	$filename=str_replace(DDBACKUPDATA,'',$filename);
	
	if(!is_dir(DDBACKUPDATA.$filename)){
		PutInfo('备份文件包含垃圾数据<br/>data/bdata'.$filename.'<br/>请及时清理！');
	}
	
    $arr=explode('_',$filename);
	$time=date('Y-m-d',strtotime($arr[1]));
	$b_date=date('Ymd',strtotime($arr[1]));
	
	if($b_date<20000101){
		PutInfo('备份文件包含垃圾数据<br/>data/bdata'.$filename.'<br/>请及时清理！');
	}
	
	if($date==$b_date){$selected='selected="selected"';}else{$selected='';}
	$option_arr[$j]="<option $selected value='$arr[1]'>$time</option>";
	$j++;
}

for($i=$j;$i>=0;$i--){
    $option.=$option_arr[$i];
}

if(!$date){
	$date=$b_date;
}
$bkdir = DDBACKUPDATA."/".'backupdata_'.$date;
$a=glob($bkdir.'/*.php');
$filelists=array();

foreach($a as $filename){
	$filename=str_replace(DDBACKUPDATA."/".'backupdata_'.$date.'/','',$filename);
	if($filename=='ddkey.php'){
	}
	else{
		if(preg_match('/tables_struct/',$filename)){
			$structfile = $filename;
		}
		else if( filesize("$bkdir/$filename") >0 ){
			$filelists[] = $filename;
		}
	}
}
$structfile = "没找到数据结构文件";
?>