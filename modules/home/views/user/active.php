<?php use yii\helpers\Html; ?>
<style type="text/css">
</style>
<div class="oe-public-box">

  <div class="oe-public-step">
    <label><i>➊</i> 会员注册</label>
    <label><i>➋</i> 验证邮箱</label>
    <span><i>➌</i> 注册成功</span>
  </div>
  <!--//oe-public-step End-->

  <div class="oe-public-help">
    <h2>已有会员帐号？<a href="<?=Yii::$app->urlManager->createUrl('/home/user/login')?>">点击这里登录</a></h2>
	<h3>注册遇到问题？</h3>
	<div class="oe-help-cont">
	 	 	 <strong><span style="color:#E53333;">已有<?=$data['count']?>人注册</span></strong>
	 	</div>
  </div>
  <!--//oe-public-help End-->
   
  
<div class="oe_reg_suss_1">
    恭喜你，注册成功！
    <span onclick="javascript:window.location.href='<?=Yii::$app->urlManager->createUrl('/home/user/login')?>';">点击这里登录</span>
  </div>
<div class="oe_reg_zhaohu">
	  
      <h6 style="margin-left:48px;padding-bottom:10px;">请牢记您以下注册信息：</h6>
      
    </div>
  <div class="clear"></div>
  <div class="oe_reg_content">
  	<h2 style="padding-left:45px;">您的用户名为：<b><?=$user['username']?></b>，注册邮箱为：<b><?=$user['email']?></b></h2>
  </div>
</div>

