<?php
$parameter=act_user_jihuo();
extract($parameter);
$css[]=TPLURL.'/inc/css/usercss.css';
include(TPLPATH.'/inc/header.tpl.php');
?>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<div id="maincenter">
  <table border="0" cellpadding="0" cellspacing="0" style="width:800px; margin:auto">
  <tr>
    <td height="50" colspan="3" align="left">&nbsp;</td>
  </tr>
  <tr>
    <td height="50" colspan="3" align="center">
    <div class="steptip">
    <div class="step1">1、注册网站</div>
    <div class="step2">2、收取激活邮件</div>
    <div class="step3">3、登陆网站</div>
    </div>
    <script>
    $(function(){
		var $step=$('.steptip').find('.step<?=$step?>')
	    $step.addClass('current');
		$step.css('background','url(<?=TPLURL?>/inc/images/step<?=$step?>c.gif)')
	})
    </script>
    </td>
  </tr>
  <tr>
    <td colspan="3" height="15">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" style="text-align:center; font-size:14px"><?=$msg?></td>
  </tr>

</table>
</div>
<?php
include(TPLPATH.'/inc/footer.tpl.php');
?>

