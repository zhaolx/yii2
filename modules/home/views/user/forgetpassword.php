<div class="oe-public-box">

  <div class="oe-public-step">
    <span>忘记密码</span>
  </div>
  <!--//oe-public-step End-->

  <div class="oe-public-help">
    <h2>
	  还没有会员帐号？<a href="<?=Yii::$app->urlManager->createUrl('/home/user/reg')?>">点击注册</a> <br />
	</h2>
	<h3>取回密码遇到问题？</h3>
	<div class="oe-help-cont">
	 	 	 <strong><span style="color:#E53333;">已有<?=$data['count']?>人注册</span></strong>
	 	</div>
  </div>
  <!--//oe-public-help End-->
  <input type="hidden" name="userid" value=""/> 
  <div class="oe-passport-puts">
	<h3>第一步 填写邮箱，校验收到的验证码</h3>
	<dl id="puts_email">
      <dd><em>*</em>邮箱：</dd>
      <dt>
	    <input type="text" name="email" id="email" class="w1" />&nbsp;
	    <span id="tips_email">（输入注册时填写的邮箱）</span>
	  </dt>
	  <div class="clear"></div>
    </dl>
    <dl>
      <dd><em>*</em>验证码：</dd>
      <dt>
	    <input type="text" id="validcode" name="validcode" class="w2" />
		<button id="btn_search">获取验证码</button>
		<span id="tips_validcode">（输入邮箱/手机收到的验证码）</span>
	  </dt>
	  <div class="clear"></div>
    </dl>

  </div>
  <!--//oe-passport-puts End-->

  <div class="oe-passport-puts">
	<h3>第二步 重新设置新密码</h3>

	<dl>
      <dd><em>*</em>新密码：</dd>
      <dt>
	    <input type="password" name="password" id="password" class="w1" />&nbsp;
	    <span id="tips_password">（请输入6~16个字符的密码）</span>
	  </dt>
	  <div class="clear"></div>
    </dl>

	<dl>
      <dd><em>*</em>确认密码：</dd>
      <dt>
	    <input type="password" name="confirmpassword" id="confirmpassword" class="w1" />&nbsp;
	    <span id="tips_confirmpassword">（请再输入新密码）</span>
	  </dt>
	  <div class="clear"></div>
    </dl>

  </div>
  <!--//oe-passport-puts End-->


  <div class="oe_reg_but" style="padding-left:160px;">
    <input type="button" name="btn_post" id="btn_post" class="oe_button4_reg" />&nbsp;&nbsp;
	<span id="tips_post"></span>
	
  </div>
  

</div>
<script type="text/javascript">
$(function(){

	$("#btn_search").bind("click", function(){ //获取验证码
		$name = $("#email").val();
		if ($name.length == 0) {
			ToastShow("请输入邮箱地址");
			return false;
		}
		$(this).val("发送中,请稍等...");
		$.ajax({
			type: "POST",
			url: "<?=Yii::$app->urlManager->createUrl('/api/common/resendemail')?>",
			cache: false,
			data: {a:"sendforget", type:1, email:$name, r:get_rndnum(8)},
			dataType: "json",
			success: function(data) {
				$json = eval(data);
				$response = $json.status;
				
				if ($response == "1") {
					ToastShow("验证码已发送到您的邮箱，请查收。");
					$("input[name='userid']").val($json.result.userid);
					resend(60);
				}else {
					ToastShow($json.msg);
				}
				$("#btn_code").val("获取验证码");

			},
			error: function() {
				ToastShow("获取失败，请检查网络！");
				$("#btn_search").val("获取验证码");
			}
		});
		return false;
	});


	$("#btn_post").bind("click", function(){ //提交取回密码
		
		$name = $("#email").val();
		if ($name.length == 0) {
			ToastShow("请输入邮箱地址");
			return false;
		}
		$validcode = $("#validcode").val();
		if ($validcode.length != 6) {
			ToastShow("请输入正确验证码");
			return false;
		}
		$password = $("#password").val();
		$confirmpassword = $("#confirmpassword").val();
		if ($password.length < 6 || $password.length > 16) {
			ToastShow("请输入6~16位的新密码");
			return false;
		}
		if ($confirmpassword != $password) {
			ToastShow("两次密码不一致");
			return false;
		}

		
		$.ajax({
			type: "POST",
			url: "<?=Yii::$app->urlManager->createUrl('/api/common/resetpassword')?>",
			cache: false,
			data: {password:$password, user_id:$("input[name='userid']").val(), code:$validcode,confirmpassword:$confirmpassword, r:get_rndnum(8)},
			dataType: "json",
			success: function(data) {
				$json = eval(data);
				$response = $json.status;
				if ($response == "1") {
					layer.alert('您的账户密码已重置，点击跳转到登录页面', {
					  title :'温馨提示',
					  icon: 6,
					  skin: 'layer-ext-moon' 
					},function(){
						window.location.href = "<?=Yii::$app->urlManager->createUrl('/home/user/login')?>";
					});
					
				}else {
					ToastShow($json.msg);
				}

			},
			error: function() {
				ToastShow("请求失败，请检查网络！");
			}
		});

	});

});
function resend(t){
	if(t>0){
		$("#btn_search").attr('disabled','disabled');
		$("#btn_search").css("background","#e7e7e7");
		$("#btn_search").css("color","#000");
		$("#btn_search").html(t+"s后重新发送");
	}else{
		$("#btn_search").removeAttr('disabled');
		$("#btn_search").css("background","#009EDF");
		$("#btn_search").css("color","#fff");
		$("#btn_search").html("重新发送");
		return false;
	}
	t--;
	setTimeout("resend("+t+")",1000);
}
</script>
