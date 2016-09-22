<?php
    use yii\helpers\Html;
    use app\assets\AppAsset;
    AppAsset::register($this);
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<html lang="<?= Yii::$app->language ?>">
<title><?= Html::encode($this->title) ?></title>
<meta name="description" content="">
<meta name="keywords" content="">
<meta name="author" content="zhaolx">
<?php $this->head() ?>
<?=Html::cssFile('@resource/home/css/oe_varpop.css')?>
<?=Html::cssFile('@resource/home/css/public.css')?>
<?=Html::jsFile('@resource/home/js/jquery.min.js')?>
<?=Html::jsFile('@resource/home/js/layer.js')?>
<?=Html::jsFile('@resource/home/js/main.js')?>
<?=Html::jsFile('@resource/home/js/oe_varpop.js')?>
<?=Html::cssFile('@resource/home/css/default.css')?>

</head>
<?php $this->beginBody() ?>
<body>
<div class="oe_passport_top">
  <div class="oe_passport_topcon">
    <div class="oe_passport_top_logo">
      <a href="http://s.phpcoo.com/"><img src="./会员注册-OElove标准版_files/e5cece3df762f1e7.png"></a>
    </div>
    <div class="oe_passport_top_menu">
      <a href="http://s.phpcoo.com/">首页</a>
      <i>|</i>
      <a href="http://s.phpcoo.com/index.php?c=user&amp;a=list">搜索</a>
      <i>|</i>
      <a href="http://s.phpcoo.com/index.php?c=dating">约会</a>
      <i>|</i>
      <a href="http://s.phpcoo.com/index.php?c=party">活动</a>
      <i>|</i>
      <a href="http://s.phpcoo.com/index.php?c=diary">日记</a>
    </div>
    <div class="oe_passport_top_smenu">
      <a href="http://s.phpcoo.com/index.php?c=album">照片墙</a>
      <a href="http://s.phpcoo.com/index.php?c=story">晒幸福</a>
        <?php if(Yii::$app->session->get('userid')):?>
          <span>欢迎您：<?=Yii::$app->session->get('username')?></span>
          <a href="<?php echo Yii::$app->urlManager->createUrl('/home/user/loggout');?>"<i>退出登录</i></a>
          <?php else: ?>
          <a href="###"  login-url="<?php echo Yii::$app->urlManager->createUrl('/home/user/login').'&is_ajax=1';?>" onclick="loginbox($(this).attr('login-url'));"><i>登录</i></a>
          <i></i>
          
          <a href="<?php echo Yii::$app->urlManager->createUrl('/home/user/reg');?>"<i>免费注册</i></a>
          <?php endif;?>
        </div>
  </div>
</div>
<?= $content ?>

<div class="oe-public-footer">
  <div class="footer-nav">
     
     
    <a href="http://s.phpcoo.com/index.php?c=about&amp;a=detail&amp;id=1">网站介绍</a> - 
     
    <a href="http://s.phpcoo.com/index.php?c=about&amp;a=detail&amp;id=4">联系我们</a> - 
     
    <a href="http://s.phpcoo.com/index.php?c=about&amp;a=detail&amp;id=5">免责申明</a> - 
     
    <a href="http://s.phpcoo.com/index.php?c=about&amp;a=detail&amp;id=6">交友须知</a> - 
     
    <a href="http://s.phpcoo.com/index.php?c=about&amp;a=detail&amp;id=7">隐私保护</a> - 
     
    <a href="http://s.phpcoo.com/index.php?c=about&amp;a=detail&amp;id=14">媒体节目合作</a> - 
     
    <a href="http://s.phpcoo.com/">返回首页</a> 
  </div>
  <div class="footer-copy">
    <p>
    <br>
</p>
<p>
    在线客服　　Email：630104898@qq.com
    </p><p>
        Zhaolx版权所有 © 2015-<span id="footer-copyright-year"><?=date('Y')?> </span> 
    </p>
    <div>
        <br>
    </div>
    <p>

    </p> 
     
    &nbsp;&nbsp;粤ICP备10217863号-16 
     
     
  </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>