/**
 * Email：630104898@qq.com
 * This is NOT a freeware, use is subject to license terms
 * $ Last update 2016-07-10 by zhaolx $
*/

/**
 * 弹出登录框
 * @param:: string $url 页面url
 * @param:: int $width 页面宽 px
 * @param:: int $height 页面高 px 
 * @param:: int $hidetitle 是否隐藏标题框
*/
function loginbox(url,width, height, hidetitle) {
	if (typeof(url) == 'undefined') {return false;}
	if (typeof(width) == 'undefined') {width = 620;}
	if (typeof(height) == 'undefined') {height = 320;}
	if (typeof(hidetitle) == 'undefined') {hidetitle = 1};
	layer.open({
	  type: 2,
	  title: '会员登录',
	  shadeClose: true,
	  shade: 0.5,
	  area: [width+'px', height+'px'],
	  content: [url,'no'] 
	}); 
	
	if (hidetitle == 1) {
		$(".aui_title").css("display", "none");
	}
}
/**
 * 添加收藏夹
 * @param:: string $url URL地址
 * @param:: string $title 标题
*/
function addfavorite(url, title) {
    try {
        window.external.addFavorite(url, title);
    }
    catch (e) {
        try {
            window.sidebar.addPanel(title, url, "");
        }
        catch (e) {
            alert("抱歉，您所使用的浏览器无法完成此操作。\n\n加入收藏失败，请使用Ctrl+D进行添加");
        }
    }
}

/**
 * 设置主页
 * @param:: string obj
 * @param:: string vrl
*/
function sethomepage(obj, vrl){
	try{
		obj.style.behavior='url(#default#homepage)';obj.setHomePage(vrl);
	}
	catch(e){
		if(window.netscape) {
			try { 
				netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");  
			}  
			catch (e){ 
				alert("此操作被浏览器拒绝！\n请在浏览器地址栏输入“about:config”并回车\n然后将 [signed.applets.codebase_principal_support]的值设置为'true',双击即可。");
			}
			var prefs = Components.classes['@mozilla.org/preferences-service;1'].getService(Components.interfaces.nsIPrefBranch);
			prefs.setCharPref('browser.startup.homepage',vrl);
		}
	}
}

/**
 * 复制URL地址
 * @param:: string id
*/
function copy_url(id){
	document.getElementById(id).select();
	build_copycode(id);
}
function build_copycode(id){
	var testCode = document.getElementById(id).value;
	if (build_copy2clipboard(testCode) != false) {
		alert("复制成功，您可以使用Ctrl+V 贴到需要的地方去！");
	}
}
build_copy2clipboard = function(txt) {
	if (window.clipboardData) {
		window.clipboardData.clearData();
		window.clipboardData.setData("Text",txt);
	}
	else if (navigator.userAgent.indexOf("Opera") != -1) {
		window.location=txt;
	}
	else if (window.netscape) 
	{
		try{
			netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
		}
		catch(e){
			alert("您的firefox安全限制限制您进行剪贴板操作，请打开’about:config’将signed.applets.codebase_principal_support’设置为true’之后重试，相对路径为firefox根目录/greprefs/all.js");
			return false;
		}
		var clip = Components.classes['@mozilla.org/widget/clipboard;1'].createInstance(Components.interfaces.nsIClipboard);
		if (!clip) return;
		var trans = Components.classes['@mozilla.org/widget/transferable;1'].createInstance(Components.interfaces.nsITransferable);
		if (!trans) return;
		trans.addDataFlavor('text/unicode');
		var str = new Object();
		var len = new Object();
		var str = Components.classes["@mozilla.org/supports-string;1"].createInstance(Components.interfaces.nsISupportsString);
		var copytext = txt;str.data = copytext;
		trans.setTransferData("text/unicode",str,copytext.length*2);
		var clipid = Components.interfaces.nsIClipboard;
		if (!clip) return false;
		clip.setData(trans,null,clipid.kGlobalClipboard);
	}
}

/* 关闭层 */
function close_div(id){
	$('#'+id).hide();
	//document.getElementById(id).style.display = 'none';
}


/**
 * document tips
*/
function dc() {
  var elements = new Array();
  for (var i = 0; i < arguments.length; i++) {
    var element = arguments[i];
    if (typeof element == 'string') element = document.getElementById(element);
    if (arguments.length == 1) return element;
    elements.push(element);
  }
  return elements;
}

/* 随机数 */
function get_rndnum(n) {
	var chars = ['0','1','2','3','4','5','6','7','8','9','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
	var res = "";
	for(var i = 0; i < n ; i ++) {
		var id = Math.ceil(Math.random()*35);
		res += chars[id];
	}
	return res;
}

/* menu */
function Menuon(ID) {
	try{dc('Tab'+ID).className='tab_on';}catch(e){}
}

/* close msg */
function closemsg() {
	try{dc('msgbox').innerHTML = '';dc('msgbox').style.display = 'none';}catch(e){}
}

/* dmsg */
function dmsg(str, id, s, t) {
	var t = t ? t : 5000;
	var s = s ? true : false;
	try{if(s){window.scrollTo(0,0);}dc('d'+id).innerHTML = '<img src="'+_ROOT_PATH+'tpl/static/images/check_error.gif" width="12" height="12" align="absmiddle"/> '+str+sound('tip');$(id).focus();}catch(e){}
	window.setTimeout(function(){dc('d'+id).innerHTML = '';}, t);
}

/* sound */
function sound(file) {
	return '<div style="float:left;"><embed src="'+_ROOT_PATH+'tpl/static/images/'+file+'.swf" quality="high" type="application/x-shockwave-flash" height="0" width="0" hidden="true"/></div>';
}

/* 信息全选控制 */
function checkAll(e, itemName){
  var aa = document.getElementsByName(itemName);
  for (var i=0; i<aa.length; i++)
   aa[i].checked = e.checked;
}

function checkItem(e, allName){
  var all = document.getElementsByName(allName)[0];
  if(!e.checked) all.checked = false;
  else{
    var aa = document.getElementsByName(e.name);
    for (var i=0; i<aa.length; i++)
     if(!aa[i].checked) return;
    all.checked = true;
  }
}

/* CSS背景控制 鼠标经过效果 */
function overColor(Obj) {
	var elements=Obj.childNodes;
	for(var i=0;i<elements.length;i++){
		elements[i].className="hback_o"
		Obj.bgColor="";
	}
	
}

/* 鼠标离开效果 */
function outColor(Obj){
	var elements=Obj.childNodes;
	for(var i=0;i<elements.length;i++){
		elements[i].className="hback";
		Obj.bgColor="";
	}
}

function isDigit(){
    return ((event.keyCode >= 48) && (event.keyCode <= 57));
}
function isDigit2(){
    return ((event.keyCode >= 48) && (event.keyCode <= 57) || (event.keyCode = 46));
}

/* 只能由汉字，字母，数字和下横线组合 */
function check_userstring(str){  
    var re1 = new RegExp("^([\u4E00-\uFA29]|[\uE7C7-\uE7F3]|_|[a-zA-Z0-9])*$");
	if(!re1.test(str)){
		return false;
	}else{
		return true;
	}
}

/* 判断字符长度，一个汉字为2个字符 */
function strlen(s){
	var l = 0;
	var a = s.split("");
	for (var i=0;i<a.length;i++){
		if (a[i].charCodeAt(0)<299){
			l++;
		}else{
			l+=2;
		}
	}
	return l;
}


/* 判断字数个数 */
function strQuantity(s){
	var l = 0;
	var a = s.split("");
	for (var i=0;i<a.length;i++){
		if (a[i].charCodeAt(0)<299){
			l++;
		}else{
			l++;
		}
	}
	return l;
}

/* 判断所选择数量 */
function check_maxnum(id, my , num){
	var oEvent = document.getElementById('em_' + id + '_edit');
	var chks = oEvent.getElementsByTagName("INPUT");
	var count = 0;
	for(var i=0; i<chks.length; i++){
		if(chks[i].type=="checkbox"){
			if(chks[i].checked == true){
				count ++;
			}
			if(count > num){
				my.checked = false;
				alert('最多只能选择' + num + '项');
				return false;
			}
		}
	}
}


/**
  $Id: 检查Email是否合法
  retrun true,false
*/
function isEmail(str) {
	var re = /^([a-zA-Z0-9]+[_|\-|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\-|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
	return re.test(str);
}


/**
 * 获取当前文件名
*/
function get_curl() {
	var curl = document.URL;
	var filename = curl.split("?")[0];
	return filename;
}


/**
 * 统计输入字数
 * @param:: string name input/textarea名称
 * @param:: string tipsid 提示框名
 * @return int
*/
function count_char(name, tipsid) {
	document.getElementById(tipsid).innerHTML = document.getElementById(name).value.length;
}

/**
 * 只允许输入整数
 * @return:: 
*/
function validIntval() { 
    var keyCode = event.keyCode;  
    if ((keyCode >= 48 && keyCode <= 57)) {  
		event.returnValue = true;  
    } 
	else {  
		event.returnValue = false;  
    }  
}

/**
 * 允许输入整数或者浮点数
 * @return::
*/
function validFloat() {
    var keyCode = event.keyCode;  
    if ((keyCode >= 48 && keyCode <= 57) || (keyCode == 46)) {  
		event.returnValue = true;  
    } 
	else {  
		event.returnValue = false;  
    }
}


/**
 * 检测上传图片后缀是否符合
 * @param:: string $fileurl 图片地址
 * @return:: bool true/false
*/
function validImageType(fileurl) {
	var result = false;
	var right_type = new Array(".jpg", ".jpeg", ".png", ".gif");
	var right_typeLen = right_type.length;
	var imgUrl = fileurl.toLowerCase();
	var postfixLen = imgUrl.length;
	var len4 = imgUrl.substring(postfixLen-4, postfixLen);
	var len5 = imgUrl.substring(postfixLen-5, postfixLen);
	for (i = 0; i<right_typeLen; i++){
		if((len4 == right_type[i]) || (len5==right_type[i])) {
			result = true;
		}
	}
	return result;
}

/**
 * 检测是否合法的11位手机号码
 * @param:: string $mobile 手机号码
 * @return:: bool true/false
*/
function validMobile(mobile) {
	var partten = /^1[3,4,5,8]\d{9}$/;
	if (partten.test(mobile)) {
		return true;
	}
	else {
		return false;
	}
}

/**
 * 刷新验证码
 * @param:: string $id
 * @return:: string
*/
function refresh_code(id) {
	if (typeof(id) == 'undefined') {id = 'checkCodeImg';}
	var ccImg = document.getElementById(id);
	if (ccImg) {
		ccImg.src= ccImg.src + '&' +Math.random();
	}
}

/**
 * 限制输入字符个数
 * 函数，3个参数，表单名字，表单域元素名，限制字符；  
*/
function textCounter(field, countfield, maxlimit) {  
	var contentvalue = $.trim($('#'+field).val());
	if (contentvalue.length > maxlimit) {
		$('#'+field).val(contentvalue.substring(0, maxlimit)); 
	}
	else  
		{  
		var cannum = (maxlimit - contentvalue.length);
		$('#'+countfield).html(cannum); 
	}
}

/**
 * 会员中心鼠标经过样式
*/
function msgoutColor(Obj,css){
	var elements=Obj.childNodes;
	for(var i=0;i<elements.length;i++){
		elements[i].className=css;
		Obj.bgColor="";
	}
}

/**
 * 判断是否为合法中国手机号码
 * @param:: string mobile 手机号码
 * @return:: bool true/false
*/
function isMobile(mobile) {
	if (mobile.length != 11) {
		return false;
	}
	else {
		var is = false;
		var reg0 = /^13\d{5,9}$/; //13段号 至少7位
		var reg1 = /^15\d{5,9}$/; //15段号
		var reg2 = /^18\d{5,9}$/; //18段号
		var reg3 = /^14\d{5,9}$/; //14段号
		var reg4 = /^17\d{5,9}$/; //17段号
		

		if (reg0.test(mobile))is = true;
		if (reg1.test(mobile))is = true;
		if (reg2.test(mobile))is = true;
		if (reg3.test(mobile))is = true;
		if (reg4.test(mobile))is = true;

		if (!is) {
			return false;
		}
		else {
			return true;
		}
	}
}

/**
* 判断是否为合法QQ号码 
* @param:: string qq QQ号码 5-11位数字
* @return:: bool true/false
*/
function isQQ(qq){
	if (qq.length < 5 || qq.length > 11) {
		return false;
	}
	else {
		var is = false;
		var reg = /^[0-9]\d{4,12}$/;
		if (reg.test(qq))is = true;

		if (!is) {
			return false;
		}
		else {
			return true;
		}
	}
}

/*----------------- 倒计时 start ----------------*/
var init_down_time = 60;
var init_intervalDownTimeObj;

/**
 * 倒计时
 * @param:: string mbinput 
*/
function initGetDownTime(mbinput, btnobj) {
	var mb = $("#"+mbinput).val();
	if (isMobile(mb)) {
		init_intervalDownTimeObj = setInterval("countDownTime('"+btnobj+"')", 1000);
	}
}
function countDownTime(btn) {
	$('#'+btn).attr("disabled", "true");
	$('#'+btn).val(""+init_down_time+"秒后没收到短信重新发送");
	init_down_time--;
	if (init_down_time == 0){
		clearInterval(init_intervalDownTimeObj); //停止时间
		$('#'+btn).removeAttr("disabled");
		$('#'+btn).val("重新发送");
		init_down_time = 60;
	}
}
/*----------------- 倒计时 end ----------------*/
