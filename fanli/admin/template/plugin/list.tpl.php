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
if(!empty($row)){
	foreach($row as $k=>$vo){
		$codes[]=$vo['code'];
		$dir=DDROOT.'/plugin/'.$vo['code'].'/set.php';
		if(file_exists($dir)){
			$a=include($dir);
			if(isset($a['banben'])){
				$row[$k]['banben']=$a['banben'];
			}
			if(isset($a['version'])){
				$row[$k]['version']=$a['version'];
			}
		}
	}
	$code_str=implode(",",$codes);
	$result=dd_get(DD_YUN_URL."/?m=Bbx&a=update&code=".urlencode($code_str));
	$code_arr=json_decode($result,true);
	foreach($row as $key=>$vo){
		if((float)$code_arr[$vo['code']]>(float)$vo['version']){
			$row[$key]['update']=true;
		}else{
			$row[$key]['update']=false;
		}
	}
}

$plugin_level=array(1=>'标准版',2=>'高级版',3=>'旗舰版');
?>
<script>
$(function(){
	$('#updateplugin').jumpBox({  
	    title: '输入平台密码获取百宝箱信息',
		titlebg:1,
		height:150,
		width:450,
		contain:'<form action="" method="get"><input type="hidden" name="mod" value="<?=MOD?>" /><input type="hidden" name="act" value="<?=ACT?>" />平台登陆密码：<input type="password" name="ddyunpwd" value="" /> <input type="submit" name="save_session" value="获取信息" /></form><br/><div><a href="<?=DD_YUN_URL?>/index.php?m=user&a=reg&url=<?=urlencode(URL)?>">未注册？立即注册</a></div>',
		LightBox:'show'
    });
	
	$('#<?=$_GET['code']?>').jumpBox({  
		title: '您还未购买<?=($_GET['code']=='phone_app')?'手机客户端':'手机wap站'?>！',
		titlebg:1,
		height:120,
		width:370,
		contain:'<div><a href="<?=DD_YUN_URL?>/index.php?m=bbx&a=view&code=<?=$_GET['code']?>" style="font-size:16px;color:red;">点击马上去购买</a></div>',
		LightBox:'show'
    });
	
	<?php if(isset($_GET['get'])){?>
	$('#updateplugin').click();
	<?php }?>
	
	<?php if(isset($_GET['code'])){?>
	$('#<?=$_GET['code']?>').click();
	<?php }?>
})
</script>
<?php if(isset($_GET['code'])){?>
<a id="<?=$_GET['code']?>"/></a>
<?php }?>	
<form name="form1" action="" method="get">
<table cellspacing="0" width="100%" style="border:1px  solid #DCEAF7; border-bottom:0px; background:#E9F2FB">
        <tr>
              <td width="40%">&nbsp;<img src="images/arrow.gif" width="16" height="22" align="absmiddle" /> <a href="<?=u('plugin','bbx')?>" class="link3">[返回百宝箱]</a> <a class="link3" id="updateplugin" style="cursor:pointer; color:#F00; font-weight:bold; text-decoration:underline">[点击获取我的订单]</a></td>
              <td width="" align="right">插件名称：<input type="text" name="q" value="<?=$q?>" />&nbsp;<input type="submit" value="搜索" /></td>
              <td width="150px" align="right">共有 <b><?=$total?></b> 条记录&nbsp;&nbsp;</td>
            </tr>
      </table>
      <input type="hidden" name="mod" value="<?=MOD?>" />
      <input type="hidden" name="act" value="<?=ACT?>" />
      </form>
      <form name="form2" method="get" action="" style="margin:0px; padding:0px">
      <table id="listtable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
                    <tr>
                      <td width="3%"><input type="checkbox" onClick="checkAll(this,'ids[]')" /></td>
                      <td width="" >名称</td>
                      <td width="80px" >适用版本</td>
                      <td width="80px">应用版本</td>
                      <td width="5%" >级别</td>
                      <td width="5%" >状态</td>
                      <td width="5%">标识码</td>
                      <td width="10%">开发者</td>
                      <td width="130px">开始时间</td>
                      <td width="130px">过期时间</td>
                      <td width="20%">操作</td>
                    </tr>
					<?php foreach ($row as $r){?>
					  <tr>
                        <td><input <?php if($r['install']==1){?> title="卸载后才能删除" disabled="disabled"<?php }?> type='checkbox' name='ids[]' value='<?=$r["id"]?>' id='content_<?=$r["id"]?>' /></td>
                        <td><a href="<?=DD_YUN_URL?>/index.php?m=bbx&a=view&code=<?=urlencode($r['code'])?>"><?=$r["title"]?></a></td>
                        <td><?=$r["banben"]?></td>
                        <td><?=$r["version"]?>
                        <?php if($r["update"] && $r['install']==1 && $r['banben']>=PLUGIN_2){?>
                        <a href="<?=u(MOD,'update',array('code'=>$r['code'],'do'=>'update'))?>" class=link4><b style="color:#F00" title="最新应用版本号：<?php echo (float)$code_arr[$r['code']];?>">更新</b></a>
                        <?php }?>
                        </td>
                        <td><?=$plugin_level[$r["level"]]?></td>
                        <td><a href="<?=p($r['code'],'index')?>" target="_blank"><?=$zhuangtai_arr[$r["status"]]?></a></td>
                        <td><?=$r["code"]?></td>
                        <td><?=$r["toper_name"]?> <?php if($r['toper_qq']!=1234){?><?=qq($r['toper_qq'],2)?><?php }?></td>
						<td><?=date('Y-m-d H:i:s',$r["addtime"])?></td>
                        <td><?=$r["endtime"]?></td>
						<td>
                        <?php if($r['banben']>=PLUGIN_2){?>
                        	<?php if($r['install']==1){?><a href="<?=u(MOD,'admin',array('plugin_id'=>$r['id']))?>" class=link4>管理</a><?php }?>
                        <?php }else{?>
                            <a href="<?=u(MOD,'addedi',array('id'=>$r['id']))?>" class=link4>信息</a>
                            <?php if($r['admin_set']==1){?><a href="<?=u($r['mod'],$r['act'])?>" class=link4>查看</a><?php }?>
                        <?php }?> 
                        <?php if($r['install']==0){?>
                        <a href="<?=u(MOD,'update',array('code'=>$r['code'],'do'=>'install'))?>" class=link4>安装</a>
                        <?php }else{?>
                        <a href="<?=u(MOD,'update',array('code'=>$r['code'],'do'=>'uninstall'))?>" onclick="return confirm('卸载同时会删除插件相关数据和文件，确定要卸载？')" class=link4>卸载</a>
                        <?php }?>
                        <a href="<?=DD_YUN_URL?>/index.php?m=bbx&a=view&code=<?=urlencode($r['code'])?>">查安装包</a>
                        <a href="<?=$r['jiaocheng']?>" target="_blank" class=link4>教程</a>
                        </td>
					  </tr>
					<?php }?>
		</table>
        <div style="position:relative; padding-bottom:10px">
          <input type="hidden" name="mod" value="<?=MOD?>" /><input type="hidden" name="act" value="del" />
            <div style="position:absolute; left:5px; top:5px"><input type="submit" value="删除" class="myself" onclick='return confirm("确定要删除?")'/></div>
            <div class="megas512" style=" margin-top:5px;"><?=pageft($total,$pagesize,u(MOD,'list'));?></div>
            </div>
       </form>
<?php include(ADMINTPL.'/footer.tpl.php');?>