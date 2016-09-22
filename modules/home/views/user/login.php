<style type="text/css">
  #tips_post{color: red;}
</style>
<?php 
use yii\helpers\Html;
use yii\captcha\Captcha; 
?>
<div class="oe-public-box">

  <div class="oe-public-step">
    <span>会员登录</span>
  </div>
  <!--//oe-public-step End-->

  <div class="oe-public-help">
    <h2>
    还没有会员帐号？<a href="<?=Yii::$app->urlManager->createUrl('/home/user/reg')?>">点击注册</a> <br />
    忘记了密码？<a href="<?=Yii::$app->urlManager->createUrl('/home/user/forgetpassword')?>">点击取回密码</a>
  </h2>
  <h3>登录遇到问题？</h3>
  <div class="oe-help-cont">
       <strong><span style="color:#E53333;">已有<?=$data['count']?>人注册</span></strong>
    </div>
  </div>
  <!--//oe-public-help End-->

  <div class="oe-passport-puts">
  <dl id="puts_name">
      <dd><em>*</em>邮箱/用户名：</dd>
      <dt>
      <input type="text" name="loginname" id="loginname" class="w1" />&nbsp;
      <span id="tips_name">（输入注册时填写的邮箱或者用户名）</span>
    </dt>
    <div class="clear"></div>
    </dl>

  <dl id="puts_mobile" style="display:none;">
      <dd><em>*</em>手机号码：</dd>
      <dt>
      <input type="text" name="loginmobile" id="loginmobile" class="w1" />&nbsp;
      <span id="tips_mobile">（输入注册时填写的手机号码）</span>
    </dt>
    <div class="clear"></div>
    </dl>

    <dl>
      <dd><em>*</em>登录密码：</dd>
      <dt>
      <input type="password" name="loginpassword" id="loginpassword" class="w1" />&nbsp;
      <span id="tips_password">（输入6-16位的密码）</span>
    </dt>
    <div class="clear"></div>
    </dl>

      <dl>
      <dd><em>*</em>验证码：</dd>
      <dt>
      <input type="text" id="logincode" name="logincode" class="w2" />
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
    <span id="tips_logincode">（输入左边的验证码）</span>
    </dt>
    <div class="clear"></div>
    </dl>
    
  </div>
  <!--//oe-passport-puts End-->

  <div class="oe_reg_but" style="padding-left:160px;">
    <input type="button" name="btn_post" id="btn_post" class="oe_button3_reg">&nbsp;&nbsp;
  <span id="tips_post"></span>
  
  </div>
  
      <div class="oe-passport-oauth">
    <h2>您还可以使用合作网站帐号登录</h2>
    <a href="javascript:void(0);" target="_top"><img src="<?=Yii::$app->getUrlManager()->getBaseUrl() ?>/images/login_qq.gif" /></a>&nbsp;
      <a href="javascript:void(0);" target="_top"><img src="<?=Yii::$app->getUrlManager()->getBaseUrl() ?>/images/login_sina.gif" /></a>&nbsp;
    </div>
  
</div>
<script type="text/javascript">
$(function(){
    $("#img_logincode").bind("click", function(){ //更换验证码
    $(this).attr("src", "/source/include/imagecode.php?act=verifycode&"+Math.random());
  });
  
  $("#btn_post").bind("click", function(){ //提交

    var loginname = "";
    var mobile = "";
    var password = "";
    var logincode = "";

    loginname = $("#loginname").val();
    if (loginname.length == 0) {
      $("#tips_name").html("<font color='red'>请输入邮箱或者用户名</font>");
      return false;
    }
   
    password = $("#loginpassword").val();
    if (password.length == 0) {
      $("#tips_password").html("<font color='red'>请输入登录密码</font>");
      return false;
    }
    
        logincode = $("#logincode").val();
    if (logincode.length != 6) {
      $("#tips_logincode").html("<font color='red'>请输入验证码</font>");
      return false;
    }
        
    $tips_post = $("#tips_post");
    $tips_post.html("登录中，请稍等...");
    
    $.ajax({
      type: "POST",
      url: "<?=Yii::$app->urlManager->createUrl('/api/common/ajaxlogin')?>",
      cache: false,
      data: {a:"loginpost", loginname:loginname, password:password, checkcode:logincode, r:get_rndnum(8)},
      dataType: "json",
      success: function(data) {
        $json = eval(data);
        $response = $json.status;
        if ($response == "1") { //成功，返回页面
          layer.msg('登录成功')
          window.location.href = $json.result.url;          
        }else {
           $tips_post.html($json.msg);
          if($json.errcode == '315'){
            window.top.location.href ="<?=Yii::$app->urlManager->createUrl('/home/user/checkemail')?>&id="+$json.attr.userid;
          }else{
            $("#captchaimg").click();
          }
        }
      },
      error: function() {
        $tips_post.html("<font color='red'>登录失败，请检查网络。</font>");
      }
    });

  });

});
</script>
