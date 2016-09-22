<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$form = ActiveForm::begin([
'id' => 'reg-form',
'method'=>'post',
'action'=>Yii::$app->urlManager->createUrl('/home/user/activeuser').'&id='.$model['id'],
]); 
?>
<style type="text/css">
#birthday-kvdate{width: 300px;}
#btn_search{	
	color:#fff;
	background:#009EDF;
	margin-left:10px;
	display: inline-block;
	height:34px;
	width:100px;
	border: 0px;
	line-height:23px;
	border-radius:5px;
}
</style>
<div class="oe-public-box">

  <div class="oe-public-step">
    <label><i>➊</i> 会员注册</label>
    <span><i>➋</i> 验证邮箱</span>
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
    
		<h2>您的用户名为：<b><?=$model['username']?></b>，注册邮箱为：<b><?=$model['email']?></b>，验证信息已发送至您的邮箱</h2>
		<p style="margin-left:65px;margin-bottom:10px;">为了确保您帐户的安全，请查收邮件并输入收到的验证码</p>
		<dl class="oe_reg_dl">
      <dd><em></em>验 证 码：</dd>
      <dt class="oe_reg_text">
	    <input type="text" name="safecode" id="safecode" class="i-w2" value="">
	     
	  </dt>
	 
      <dt class="oe_reg_tips_0" id="tips_safecode">
	    <label></label>
	    <span></span>
		<font color="#999999">请输入邮箱验证码</font>
	  </dt>
    </dl>
    <dl class="oe_reg_dl">
    	<span style="margin-left:50px;color:#E53333;">如果没有收到邮件，点击按钮可免费重新发送</span><button  id="btn_search" >重新发送</button>
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

$(function(){
	$("#safecode").bind("blur", function(){  //check passpord
		if ($(this).val().length != 6 ) {
			errorBack("tips_safecode", "验证码不正确");
		}else {
			$.ajax({				
				type: "POST",
				url: "<?=Yii::$app->urlManager->createUrl('/api/common/checksafecode')?>",
				cache: false,
				data: {code:$(this).val(),user_id:"<?=$model['id']?>", r:get_rndnum(8)},
				dataType: "json",
				success: function(data) {
					var json = eval(data);
					var response = json.status;
					if (response == 1) {
						okBack("tips_safecode", '通过');
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
	$("#btn_post").bind("click", function(){ //post	 $('input[type="text"]').blur()
		if ($('input[type="text"]').blur()|| true) {
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

$("#btn_search").bind("click", function(){
	$.ajax({				
			type: "POST",
			url: "<?=Yii::$app->urlManager->createUrl('/api/common/resendemail')?>",
			cache: false,
			data: {email:"<?=$model['email']?>", r:get_rndnum(8)},
			dataType: "json",
			success: function(data) {
				var json = eval(data);
				var response = json.status;
				if (response == 1) {
					resend(60);

				}else if (response == 0) {
					errorBack("tips_email", json.msg);
				}else {
					layer.msg(json.msg);
					errorBack("tips_email", "网络错误，请稍后重试");
				}
			},
			error: function() {

			}
		}); 
	return false;
});

function resend(t){
	console.log(t);
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

function errorBack(id, text) {
	$("#"+id).attr("class", "oe_reg_tips_1");
	$("#"+id).find("font").text(text);
}	

function okBack(id, text) {
	$("#"+id).attr("class", "oe_reg_tips_2");
	$("#"+id).find("font").text("");
}

</script>

