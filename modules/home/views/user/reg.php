<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\captcha\Captcha;
$form = ActiveForm::begin([
'id' => 'reg-form',
'method'=>'post',
]); 
?>
<style type="text/css">#birthday-kvdate{width: 255px;}.kv-date-remove{display: none;}</style>
<div class="oe-public-box">

  <div class="oe-public-step">
    <span><i>➊</i> 会员注册</span>
    <label><i>➋</i> 验证邮箱</label>
    <label><i>➌</i> 注册成功</label>
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
   
  
  <div class="oe_reg_content" style="margin-top:20px;">
    <dl class="oe_reg_dl">
      <dd><em></em>用 户 名：</dd>
      <dt class="oe_reg_text">
	    <input type="text" name="User[username]" id="username" maxlength="16" class="i-w1">
        &nbsp;
	  </dt>
      <dt class="oe_reg_tips_0" id="tips_username">
	    <label></label>
	    <span></span>
	    <font color="#999999">3-16个字符，由字母、数字组成</font>
	  </dt>
    </dl>
	<dl class="oe_reg_dl" style="height:35px;">
      <dd><em></em>登录密码：</dd>
      <dt class="oe_reg_text">
        <input type="password" name="User[password]" id="password" class="i-w1" maxlength="16">
        &nbsp;
	  </dt>
      <dt class="oe_reg_tips_0" id="tips_password">
	    <label></label>
	    <span></span>
		<font color="#999999">长度6-16个字符</font>
	  </dt>
    </dl>
    <div class="oe_reg_dl reg_pw" style="height:15px;background-color:#FFD099;width:210px;margin-bottom:10px;margin-left:160px;position: absolute;">
    	
                <div class="reg_pw_bar">
   
                </div>
                    	
    	     	<span>弱</span><span>中</span><span>强</span>
    	   
    </div>
    <div class="clear" style="height:15px;"></div>
	<dl class="oe_reg_dl">
      <dd><em></em>确认密码：</dd>
      <dt class="oe_reg_text">
        <input type="password" name="confirm_password" id="confirm_password" class="i-w1" maxlength="16">
        &nbsp;
	  </dt>
      <dt class="oe_reg_tips_0" id="tips_password_2">
	    <label></label>
	    <span></span>
		<font color="#999999">两次密码必须一致</font>
	  </dt>
    </dl>
	<dl class="oe_reg_dl">
      <dd><em></em>性　　别：</dd>
      <dt class="oe_reg_text">
        <input type="radio" name="User[sex]" id="gender" value="1" onclick="checkGender();">
        <label for="radio">男</label>
        <input type="radio" name="User[sex]" id="gender" value="2" onclick="checkGender();">
        <label for="radio2">女</label>
	  </dt>
	  <dt class="oe_reg_tips_0" id="tips_gender">
	    <label></label>
	    <span></span>
		<font color="#999999">一旦选择不能更改</font>
	  </dt>
    </dl>
	<dl id="reg_email" class="oe_reg_dl">
      <dd><em></em>注册邮箱：</dd>
      <dt class="oe_reg_text"><input type="text" name="User[email]" id="email" class="i-w1">&nbsp;</dt>
      <dt class="oe_reg_tips_0" id="tips_email">
        <label></label>
        <span></span>
		<font color="#999999">请输入正确、有效的邮箱</font>
	  </dt>
    </dl>
    
	
	<dl id="reg_mobile" class="oe_reg_dl" >
      <dd><em></em>手机号码：</dd>
      <dt class="oe_reg_text"><input type="text" name="User[mobile]" id="mobile" class="i-w1">&nbsp;</dt>
      <dt class="oe_reg_tips_0" id="tips_mobile">
        <label></label>
        <span></span>
		<font color="#999999">请输入正确、有效的手机号码</font>
	  </dt>
    </dl>

    <dl class="oe_reg_dl">
      <dd><em></em>出生日期：</dd>
	  <dt class="oe_reg_text">
	  	<?php echo DatePicker::widget([ 
			 'name' => 'User[birthday]',
			 'id'=>'birthday', 
			 'options' => ['placeholder' => '请选择出生日期'], 
			 'language' => 'cn',
			 'pluginOptions' => [ 
			  'autoclose' => true, 
			  'format' => 'yyyy-mm-dd', 
			  'language'=>'cn'
			 ] 
			]); 
		?>

	  </dt>
      <dt class="oe_reg_tips_0" id="tips_birthday">
	    <label></label>
	    <span></span>
		<font color="#999999">一旦选择不能更改</font>
	  </dt>
    </dl>

		<dl class="oe_reg_dl">
      <dd><em></em>验 证 码：</dd>
      <dt class="oe_reg_text">
	    <input type="text" name="safecode" id="safecode" class="i-w2" value="">
	     <?php echo Captcha::widget(
		  [
		  'name'=>'captchaimg',
		  'captchaAction'=>'user/captcha',
		  'imageOptions'=>[
			  'id'=>'captchaimg', 
			  'title'=>'换一个', 
			  'alt'=>'换一个', 
			  'style'=>'cursor:pointer;margin-left:10px;'
		  ],
		  'template'=>'{image}'
		  ]);
	  ?>
	  </dt>
	 
      <dt class="oe_reg_tips_0" id="tips_safecode">
	    <label></label>
	    <span></span>
		<font color="#999999">请输入验证码</font>
	  </dt>
    </dl>
		
	
	<div class="clear"></div>

  </div>

  <div class="oe_reg_but">
    <input type="button" name="btn_post" id="btn_post" class="oe_button0_reg">
  </div>
  <div class="clear"></div>
</div>
<?php ActiveForm::end(); ?>
<script type="text/javascript">
//性别
function checkGender() {
	var gender = $('input[name="User[sex]"]:checked').val();
	if (gender == "" || typeof(gender) == 'undefined') {
		errorBack("tips_gender", "请选择性别");
	}
	else {
		okBack("tips_gender", "通过");
	}
}
//密码强度
function showPassLevel(pwdinput) {
    var maths, smalls, bigs, corps, cat, num;
    var str = $('#'+pwdinput).val();
    var len = str.length;

    var cat = /.{16}/g
    if (len == 0) return 1;
    if (len > 16) { $('#'+pwdinput).value = str.match(cat)[0]; }
    cat = /.*[\u4e00-\u9fa5]+.*$$/
    if (cat.test(str)) {
    	errorBack("tips_password", "密码请勿包含中文");
        //showErr('password', '密码请勿包含中文');
        return false;
    }
    cat = /\d/;
    var maths = cat.test(str);
    cat = /[a-z]/;
    var smalls = cat.test(str);
    cat = /[A-Z]/;
    var bigs = cat.test(str);
    var corps = corpses(pwdinput);
    var num = maths + smalls + bigs + corps;

    if (len < 6) { return 1; }

    if (len >= 6 && len <= 8) {
        if (num == 1) return 1;
        if (num == 2 || num == 3) return 2;
        if (num == 4) return 3;
    }

    if (len > 8 && len <= 11) {
        if (num == 1) return 2;
        if (num == 2) return 3;
        if (num == 3) return 4;
        if (num == 4) return 5;
    }

    if (len > 11) {
        if (num == 1) return 3;
        if (num == 2) return 4;
        if (num > 2) return 5;
    }
}
function corpses(pwdinput) {
    var cat = /./g
    var str = $('#'+pwdinput).val();
    var sz = str.match(cat)
    for (var i = 0; i < sz.length; i++) {
        cat = /\d/;
        maths_01 = cat.test(sz[i]);
        cat = /[a-z]/;
        smalls_01 = cat.test(sz[i]);
        cat = /[A-Z]/;
        bigs_01 = cat.test(sz[i]);
        if (!maths_01 && !smalls_01 && !bigs_01) { return true; }
    }
    return false;
}
$(function(){
	
	$("#email").bind("blur", function(){ //check email
		if ($(this).val() == "") {
			errorBack("tips_email", "请填写正确的邮箱");
		}else {
			 var emailreg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
             if(!emailreg.test($(this).val())){
             	errorBack("tips_email", "请填写正确的邮箱");
             }else{
             	$.ajax({				
					type: "POST",
					url: "<?=Yii::$app->urlManager->createUrl('/api/common/checkemail')?>",
					cache: false,
					data: {email:$(this).val(), r:get_rndnum(8)},
					dataType: "json",
					success: function(data) {
						var json = eval(data);
						var response = json.status;
						if (response == 1) {
							okBack("tips_email", "通过");
						}else if (response == 0) {
							errorBack("tips_email", json.msg);
						}else {
							errorBack("tips_email", "网络错误，请稍后重试");
						}
					},
					error: function() {

					}
				});
             }
		}
	});

	
	$("#mobile").bind("blur", function(){ //check mobile
		if ($(this).val() == "") {
			errorBack("tips_mobile", "请填写正确的手机号码");
		}else {
			var mobilereg = /^(1[0-9]{10})$/;
			if(!mobilereg.test($(this).val())){
				errorBack("tips_mobile", "请填写正确的手机号码");
				return false;
			}else{
				okBack("tips_mobile", "通过");
			}
		
		}
	});
	
	$("#password").bind("keyup", function(){  //check passpord
		if ($(this).val().length < 6 || $(this).val().length > 16) {
			errorBack("tips_password", "请设置正确密码");
			$(".reg_pw_bar").css("width", "0");
		}else {
			var lvl = showPassLevel('password');
			if (lvl <= 2) {	        
		        $(".reg_pw_bar").css("width", "70px");
		    }else if (lvl == 3) {
		    	$(".reg_pw_bar").css("width", "140px");
		    }else if (lvl > 3) {
		       $(".reg_pw_bar").css("width", "210px");
		    }
			okBack("tips_password", "正确");
		}
	});
	
	
	$("#safecode").bind("blur", function(){  //check passpord
		if ($(this).val().length != 6 ) {
			errorBack("tips_safecode", "验证码不正确");
		}else {
			$.ajax({				
				type: "POST",
				url: "<?=Yii::$app->urlManager->createUrl('/api/common/checkcode')?>",
				cache: false,
				data: {code:$(this).val(), r:get_rndnum(8)},
				dataType: "json",
				success: function(data) {
					var json = eval(data);
					var response = json.status;
					if (response == 1) {
						okBack("tips_safecode", "通过");
					}else if (response == 0) {
						errorBack("tips_safecode", json.msg);
					}else {
						errorBack("tips_username", "网络错误，请稍后重试");
					}
				},
				error: function() {

				}
			});
		}
	});
	$("#confirm_password").bind("blur", function(){  //check passpord
		if ($(this).val().length <1) {
			errorBack("tips_password_2", "不能为空");
		}else if ($(this).val() != $("#password").val()) {
			errorBack("tips_password_2", "两次密码不一致");
		}
		else {
			okBack("tips_password_2", "正确");
		}
	});

	$("#username").bind("blur", function(){ //check username
		if ($(this).val() == "") {
			errorBack("tips_username", "请填写用户名");
		}else {
			var userreg = /^([a-zA-Z0-9]){3,16}$/;
			if(!userreg.test($(this).val())){
				errorBack("tips_username", "请填写正确的用户名");
				return false;
			}

			$.ajax({				
				type: "POST",
				url: "<?=Yii::$app->urlManager->createUrl('/api/common/checkusername')?>",
				cache: false,
				data: {username:$(this).val(), r:get_rndnum(8)},
				dataType: "json",
				success: function(data) {
					var json = eval(data);
					var response = json.status;
					if (response == 1) {
						okBack("tips_username", "通过");
					}else if (response == 0) {
						errorBack("tips_username", json.msg);
					}else {
						errorBack("tips_username", "网络错误，请稍后重试");
					}
				},
				error: function() {

				}
			});
		}
	});
	
/*
	//check birthday
	$("#birthday").bind("blur", function(){
		//console.log($(this).val());
		//if($(this).val().length==10){			
			//okBack("tips_birthday", "通过");
		//}else{
			//errorBack("tips_birthday", "出生日期不正确");
		//}
		okBack("tips_birthday", "通过");
	});

*/
	$('#birthday').change(function(){
	    if($(this).val().length==10){			
			okBack("tips_birthday", "通过");
		}else{
			errorBack("tips_birthday", "出生日期不正确");
		}

	});
	$("#btn_post").bind("click", function(){ //post	 $('input[type="text"]').blur()
		if ($('input[type="text"]').blur() && $('input[type="password"]').blur() && $('select').change() && checkGender() || true) {
			//判断是否可以提交
			$bool = $("form").find(".oe_reg_tips_1").not($(".oe_reg_tips_1:hidden"));
			if ($bool.html() == undefined){
				$("form").submit();
			}
			else{
				$top = $bool.scrollTop();
				$("html, body").animate({'scrollTop':$top}, 200);
			}
		}

	});

});

function errorBack(id, text) {
	$("#"+id).attr("class", "oe_reg_tips_1");
	$("#"+id).find("font").text(text);
}	

function okBack(id, text) {
	$("#"+id).attr("class", "oe_reg_tips_2");
	$("#"+id).find("font").text("");
}

</script>

