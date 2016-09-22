<?php 
use yii\helpers\Html;
use yii\captcha\Captcha; 
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
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
<?=Html::cssFile('@resource/home/css/default.css')?>
</head>
<?php $this->beginBody() ?>
<body>
<div class="oe_public_login_dialog_main">
  <div class="oe_public_login_dialog_left">
    <h2>会员登录</h2>

    <div class="oe_public_login_dialog_form">
    <dl id="puts_name">
      <dt>邮箱/用户名：</dt>
    <dd><input type="text" name="loginname" id="loginname" class="txt-input" /></dd>
    </dl>
    <dl id="puts_password">
      <dt>登录密码：</dt>
    <dd><input type="password" name="loginpassword" id="loginpassword" class="txt-input" /></dd>
    </dl>
        <dl id="puts_checkcode">
      <dt>验 证 码：</dt>
    <dd>
      <input type="text" class="txt-input" id="logincode" name="logincode" value="" style="width:80px;" maxlength="6" />
      <i class="oe_dialog_code_but">
        <?php echo Captcha::widget([
          'name'=>'captchaimg',
          'captchaAction'=>'user/captcha',
          'imageOptions'=>[
            'id'=>'captchaimg', 
            'title'=>'换一个', 
            'alt'=>'换一个', 
            //'style'=>'cursor:pointer;margin-left:10px;'
          ],
          'template'=>'{image}'
          ]);
        ?>
      </i>
    </dd>
    </dl>
    
    <dl style="margin-top:10px;">
      <dt>&nbsp;</dt>
    <dd><i class="oe_dialog_login_but" id="btn_login">立刻登录</i></dd>
    </dl>
    <dl>
      <dt>&nbsp;</dt>
    <dd id="login_tips" style="color:red;"></dd>
    </dl>
    </div>

  </div>

  <div class="oe_public_login_dialog_right">
    <h2>新会员注册</h2>
    <div class="oe_public_login_dialog_tips">
    <ul style="margin-top:20px;">
      <li>
     还没有注册会员？<a href="<?=Yii::$app->urlManager->createUrl('/home/user/reg')?>" class="oe_dialog_reg_but" target="_top">马上注册</a> 
    </li>
    <li>
      忘记了密码？<a href="/index.php?c=passport&a=forget" target="_top">点击这里找回</a>
    </li>
    </ul>
    <div class="clear"></div>
              <ul style="margin-top:30px;">
      <li><b>您还可以使用合作网站帐号登录</b></li>
    <li>
          <a href="javascript:void(0);" target="_top"><img src="<?=Yii::$app->getUrlManager()->getBaseUrl() ?>/images/login_qq.gif" /></a>&nbsp;
        <a href="javascript:void(0);" target="_top"><img src="<?=Yii::$app->getUrlManager()->getBaseUrl() ?>/images/login_sina.gif" /></a>&nbsp;
        </li>
    </ul>
    <div class="clear"></div>
      </div>
  </div>
  <!--//login_dialog_right End-->
</div>
<?php $this->endBody() ?>
</body>
</html>
<script type="text/javascript">
$(function(){
  $("#btn_login").bind("click", function(){ //提交

    $type = $('input[name="logintype"]:checked').val();
    if ($type == "" || typeof($type) == 'undefined') {
      $type = 1;
    }
    
    $loginname = "";
    $mobile = "";
    $password = "";
    $logincode = "";
    $csrfToken = $('meta[name="csrf-token"]').attr("content");
    if ($type == 1) { //邮箱
      $loginname = $("#loginname").val();
      if ($loginname.length == 0) {
        showError("请输入邮箱或者用户名");
        return false;
      }
    }
    $password = $("#loginpassword").val();
    if ($password.length == 0) {
      showError("请输入登录密码");
      return false;
    }
    
        $logincode = $("#logincode").val();
    if ($logincode.length == 0) {
      showError("请输入验证码");
      return false;
    }else if($logincode.length != 6){
      showError("验证码错误");
      return false;
    }
        
    $(this).html("登录中...");
    $.ajax({
      type: "POST",
      url: "<?=Yii::$app->urlManager->createUrl('/api/common/ajaxlogin')?>",
      cache: false,
      data: {a:"loginpost", type:$type, loginname:$loginname, password:$password, checkcode:$logincode, r:get_rndnum(8)},
      dataType: "json",
      success: function(data) {
        $json = eval(data);
        if ($json.status == "1") { //成功，返回页面
          window.top.location.href ="<?=Yii::$app->urlManager->createUrl('/home/user/index')?>";
          
         // parent.location.reload();
        }else{
          showError($json.msg);
          if($json.errcode == '315'){
            window.top.location.href ="<?=Yii::$app->urlManager->createUrl('/home/user/checkemail')?>&id="+$json.attr.userid;
          }
          $("#btn_login").html("立即登录");
        }
        
      },
      error: function() {
        showError("登录失败，请检查网络！");
        $("#btn_login").html("立即登录");
      }
    });

  });

});

function showError(msg) {
  $("#login_tips").html(msg);
  setTimeout(function(){
    $("#login_tips").html("");
  }, 3000);
}
</script>
<?php $this->endPage() ?>