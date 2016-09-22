/**
 * [OElove] (C)2010-2099 PHPCOO.COM Inc.
 * This is NOT a freeware, use is subject to license terms
 * Email: service@phpcoo.com  phpcoo@qq.com
 * $Id: oe_varpop.js 2016-06-07 OEdev $
*/

/*
var OE_WIN_WIDTH = $(window).width();
if ($.browser.mozilla) {
	OE_WIN_WIDTH = window.screen.width; //兼容Mozilla
}
*/
var OE_WIN_WIDTH = $("html").width();
var OE_BODY_WIDTH = $("body").width();
var OE_WIN_HEIGHT = $(window).height();
if ($.browser.mozilla) {
	OE_WIN_WIDTH = window.screen.width; //兼容Mozilla
}
var Toast = function(config){
	this.context = config.context == null ? $('body'):config.context;//上下文
	this.message = config.message;//显示内容
	this.time = config.time == null ? 3000 : config.time;//持续时间
	this.left = config.left;//距容器左边的距离
	this.top = config.top;//距容器上方的距离
	this.init();
}
var msgEntity;
Toast.prototype = {
	//初始化显示的位置内容等
	init : function(){
		$("#ToastBox").remove();
		//设置消息体
		var msgDIV = new Array();
		msgDIV.push('<div id="ToastBox" class="oe-toast">');
		msgDIV.push('<span id="ToastText">'+this.message+'</span>');
		msgDIV.push('</div>');

		msgEntity = $(msgDIV.join('')).appendTo(this.context);

		$span_width = msgEntity.width();
		$left_width = (OE_WIN_WIDTH-$span_width)/2;
		//设置消息样式
		//var left = this.left == null ? this.context.width()/2-msgEntity.find('span').width()/2 : this.left;
		//var top = this.top == null ? '20px' : this.top;
		msgEntity.css({left:$left_width});
		msgEntity.hide();
	},
	//显示动画
	show :function(){
		//msgEntity.fadeIn(this.time/2);
		msgEntity.fadeIn(600);
		setTimeout(function(){
			msgEntity.fadeOut(2000);
		}, 2000);
	}	
}
function ToastShow(text, focus, callback) {
	if (typeof(focus) == "undefined") {focus = "";}
	if (typeof(callback) == "undefined") {callback = "";}
	new Toast({context:$('body'), message:text}).show();
	if (focus.length > 0) {
		$("#"+focus).focus();
	}
	if (typeof(callback) == "function") {
		callback.call(this);
	}
}

function ToastTips(msg, focus, callback) {
	if (typeof(msg) == 'undefined') {
		msg = "";
	}
	if (typeof(focus) == "undefined") {focus = "";}
	if (typeof(callback) == "undefined") {callback = "";}
	$obj_id = "ToastTips";
	$("#"+$obj_id).remove();
	$append_html = "<div id='"+$obj_id+"' class='oe_toasttips'><span>"+msg+"</span></div>";
	$($append_html).appendTo("body");

	$height =  ($(window).height()-$("#"+$obj_id).height())/3;
	$("#"+$obj_id).css("left", Math.max(0, (($(window).width() - $("#"+$obj_id).outerWidth()) / 2) + $(window).scrollLeft()) + "px");
	$("#"+$obj_id).css("bottom", $height+"px");
	
	$("#"+$obj_id).fadeIn(800);
	setTimeout(function(){
		$("#"+$obj_id).fadeOut(2000);
	}, 2000);
	if (focus.length > 0) {
		$("#"+focus).focus();
	}
	if (typeof(callback) == "function") {
		callback.call(this);
	}
}

//自适应居中
function varPopMarginAuto(tabid){
	$('#'+tabid).css("position","fixed");
	$height =  ($(window).height()-$("#"+tabid).height())/2;
	$('#'+tabid).css("top", $height+"px");
	$('#'+tabid).css("left", Math.max(0, (($(window).width() - $('#'+tabid).outerWidth()) / 2) + $(window).scrollLeft()) + "px");
}

//弹出窗口
function varPopShow(tabid) {
	$(".varpop-shade").fadeIn(200);
	varPopMarginAuto(tabid);
	$("#"+tabid).fadeIn(200);
}

//关闭弹窗
function varPopClose(tabid) {
	if(typeof(tabid) == 'undefined') {
		tabid = "";
	}
	$("#"+tabid).fadeOut(200);
	$(".varpop-shade").fadeOut(200);
}


/*-------------------- 以下2015.09.10加 ----------------------*/

//确认窗口
var oeVarPopConfirm = function(config){
	this.text = config.text;//提示消息
	this.callback = config.callback;//回调信息 func或者url或者form
	this.type = config.type; //回调类型 func/url/form/null
	this.init();
	this.bindEvent();
}
oeVarPopConfirm.prototype = {

	init : function(){ //初始化DIV
		if ($("#oe_varpop_confirm_shade").length == 0) { //阴影框
			$("body").append("<div id='oe_varpop_confirm_shade' class='varpop-shade'></div>");
		}
		if ($("#oe_varpop_confirm_cont").length == 0) { //内容框
			$varpop_html = "<div class='oevar_confirm_layout' id='oe_varpop_confirm_cont' style='width:300px;display:none;'>"+
							"  <h2>确认提示</h2>"+
							"  <p id='oe_varpop_confirm_msg'>"+this.text+"</p>"+
							"  <div class='oevar_confirm_list'>"+
							"    <div class='oevar_confirm_lt' id='btn_varpop_confirm'>确定</div>"+
							"	 <div class='oevar_confirm_rt' id='btn_varpop_cancel'>取消</div>"+
							"    <div class='clear'></div>"+
							"  </div>"+
							"</div>";
			$("body").append($varpop_html);
		}
	},
	
	show :function() { //显示
		$("#oe_varpop_confirm_shade").show();
		$("#oe_varpop_confirm_msg").html(this.text);
		varPopMarginAuto("oe_varpop_confirm_cont");
		$("#oe_varpop_confirm_cont").fadeIn(200); //显示
	},

	hide :function() { //隐藏
		$("#oe_varpop_confirm_shade").hide();
		$("#oe_varpop_confirm_cont").fadeOut(20); 
	},
	

	bindEvent:function(){ //绑定事件
		var $var_callback = this.callback; //回调信息
		var $var_type = this.type; //回调类型

		$("#btn_varpop_cancel").bind("click", function(){ //取消
			$("#oe_varpop_confirm_shade").remove();
			$("#oe_varpop_confirm_cont").remove(); 
		});

		$("#btn_varpop_confirm").bind("click", function(){ //确定

			if ($var_callback.length > 0) { //回调

				if ($var_type == "func") { //函数

					$fun = eval($var_callback);
					if (typeof($fun) == "function") {
						$fun.call();
					}

				}
				else if ($var_type == "url") { //URL

					window.location.href = $var_callback;

				}
				else if ($var_type == "form") { //form表单

					$("#"+$var_callback).submit();

				}
			}

			$("#oe_varpop_confirm_shade").remove();
			$("#oe_varpop_confirm_cont").remove(); 
		});
	}
}
/**
 * 确认对话框
 * @param:: string text 信息提示
 * @param:: string callback 回调信息
 * @param:: string type 回调类型 func, url, form
*/
function oePopConfirm(text, callback, type) {
	if (typeof(callback) == "undefined") {callback = "";}
	if (typeof(type) == "undefined") {type = "func";}
	new oeVarPopConfirm({text:text, callback:callback, type:type}).show();
}


/**
 * 公共弹出窗口 支持 iframe,ajax last 16.01.14
 * @param:: string $var_tabid 元素ID
 * @param:: string $var_title 标题
 * @param:: string $var_type 页面类型 iframe, ajax
 * @param:: int $var_width 页面宽度
 * @param:: int $var_height 页面高度
 * @param:: string $var_text 文本
 * @return:: string ...
*/
function oePopDialog(var_tabid, var_title, var_url, var_type, var_width, var_height, var_text) {
	if (typeof(var_text) == "undefined") {
		var_text = "";
	}
	$varpop_html = "<div class='oevar_m_body' style='display:none;' id='"+var_tabid+"'>"+
					"  <div class='oevar_m_layout' id='"+var_tabid+"_lay'>"+
					"    <div class='oevar_m_box' style='width:"+var_width+"px;'>"+
					"      <div class='oevar_m_title'>"+
					"        <h3>"+var_title+" <a href='javascript:;' onclick=\"$('#"+var_tabid+"').remove();\"></a></h3>"+
					"      </div>"+
					"      <div class='oevar_m_cont' id='"+var_tabid+"_m_data'>"+
					"      </div>"+
					"    </div><!--//oevar_m_box End-->"+
					"  </div><!--//oevar_m_layout End-->"+
					"</div><!--//oevar_m_body End-->";
	$("body").append($varpop_html);
	$_var_content = "";

	if (var_type == "iframe") { //iframe页面
		$_var_content = "<iframe frameborder='0' allowtransparency='true' style='width:100%;height:"+var_height+"px;border:0px none;' src='"+var_url+"'></iframe>";
		
		$("#"+var_tabid+"_m_data").html($_var_content);
		$("#"+var_tabid).show();
		varPopMarginAuto(var_tabid+"_lay");
	}
	else if (var_type == "ajax") { //ajax请求出页面
		$.ajax({
			type: "POST",
			url: var_url,
			cache: false,
			data: {r:get_rndnum(8)},
			dataType: "json",
			success: function($data) {
				$json = eval($data);
				$response = $json.response;
				$result = $json.result;
				if ($response == "1") {
					$_var_content = $result;
				}
				else {
					if ($result.length > 0) {
						$_var_content = $result;
					}
					else {
						$_var_content = "页面请求出错啦！~";
					}
				}
				$("#"+var_tabid+"_m_data").html($_var_content);
				$("#"+var_tabid).show();
				varPopMarginAuto(var_tabid+"_lay");

			},
			error: function() {
				$_var_content = "页面请求出错啦！~";
				$("#"+var_tabid+"_m_data").html($_var_content);
				$("#"+var_tabid).show();
				varPopMarginAuto(var_tabid+"_lay");
			}
		});
	}
	else if (var_type == "text") { //文本2016.01.13
		$("#"+var_tabid+"_m_data").html(var_text);
		$(".oevar_m_box").css("height", var_height);
		$("#"+var_tabid).show();
		varPopMarginAuto(var_tabid+"_lay");
	}
}
