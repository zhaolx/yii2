/**
 * [OElove] (C)2010-2099 phpcoo.com Inc.
 * This is not a freeware, use is subject to license terms
 * $ artbox.js LastTime 2015.06.10 Powered by OEdev$
*/
/*-----------------------Index Begin------------------------*/
/**
 * 弹出登录框
 * @param:: int $width 页面宽 px
 * @param:: int $height 页面高 px 
 * @param:: int $hidetitle 是否隐藏标题框
*/
function artbox_loginbox(width, height, hidetitle) {
	if (typeof(width) == 'undefined') {width = 620;}
	if (typeof(height) == 'undefined') {height = 320;}
	if (typeof(hidetitle) == 'undefined') {hidetitle = 1};
	var url =  '/index.php?c=passport&a=jdlogin&r='+get_rndnum(6);
	$.dialog.open(url, {title: '会员登录', width: width, height: height});
	if (hidetitle == 1) {
		$(".aui_title").css("display", "none");
	}
}
/*-----------------------Index End------------------------*/

/*-----------------------User Begin----------------------*/
/**
 * 弹出登录框
 * @param:: int $id ID编号
 * @param:: int $width 页面宽 px
 * @param:: int $height 页面高 px 
 * @param:: int $hidetitle 是否隐藏标题框
*/
function artbox_edit_album(id, width, height, hidetitle) {
	if (typeof(width) == 'undefined') {width = 580;}
	if (typeof(height) == 'undefined') {height = 240;}
	if (typeof(hidetitle) == 'undefined') {hidetitle = 0};
	var url = _ROOT_PATH + 'usercp.php?c=album&a=edit&id='+id+'&halttype=jdbox&r='+get_rndnum(6);
	$.dialog.open(url, {title: '编辑相册', width: width, height: height, drag: false});
	if (hidetitle == 1) {
		$(".aui_title").css("display", "none");
	}
}

/**
 * 弹出登录框 UC
 * @param:: int $id ID编号
 * @param:: int $width 页面宽 px
 * @param:: int $height 页面高 px 
 * @param:: int $hidetitle 是否隐藏标题框
*/
function artbox_dating_user(id, width, height, hidetitle) {
	if (typeof(width) == 'undefined') {width = 800;}
	if (typeof(height) == 'undefined') {height = 300;}
	if (typeof(hidetitle) == 'undefined') {hidetitle = 0};
	var url = _ROOT_PATH + 'usercp.php?c=dating&a=user&did='+id+'&halttype=jdbox&r='+get_rndnum(6);
	$.dialog.open(url, {title: '赴约会员', width: width, height: height, drag: false});
	if (hidetitle == 1) {
		$(".aui_title").css("display", "none");
	}
}

/**
 * 弹出送礼物窗口
 * @param:: int $touid 会员ID
 * @param:: int $width 页面宽 px
 * @param:: int $height 页面高 px 
 * @param:: int $hidetitle 是否隐藏标题框
*/
function artbox_sendgift(touid, width, height, hidetitle) {
	if (typeof(width) == 'undefined') {width = 730;}
	if (typeof(height) == 'undefined') {height = 480;}
	if (typeof(hidetitle) == 'undefined') {hidetitle = 0};
	var url = _ROOT_PATH + 'usercp.php?c=gift&a=send&touid='+touid+'&halttype=jdbox&r='+get_rndnum(6);
	$.dialog.open(url, {title: '赠送礼物', width: width, height: height, drag: false});
	//if (hidetitle == 1) {
		$(".aui_title").css("display", "none");
	//}
}


/**
 * 弹出打招呼窗口
 * @param:: int $touid 会员ID
 * @param:: int $width 页面宽 px
 * @param:: int $height 页面高 px 
 * @param:: int $hidetitle 是否隐藏标题框
*/
function artbox_hi(touid, width, height, hidetitle) {
	if (typeof(width) == 'undefined') {width = 620;}
	if (typeof(height) == 'undefined') {height = 460;}
	if (typeof(hidetitle) == 'undefined') {hidetitle = 0};
	var url = _ROOT_PATH + 'usercp.php?c=hi&a=hi&touid='+touid+'&halttype=jdbox&r='+get_rndnum(6);
	$.dialog.open(url, {title: '打招呼', width: width, height: height, drag: false});
	//if (hidetitle == 1) {
		$(".aui_title").css("display", "none");
	//}
}

/**
 * 弹出写信窗口
 * @param:: int $touid 会员ID
 * @param:: string $fromtype 来源类型
 * @param:: int $width 页面宽 px
 * @param:: int $height 页面高 px 
 * @param:: int $hidetitle 是否隐藏标题框
*/
function artbox_writemsg(touid, fromtype, width, height, hidetitle) {
	if (typeof(fromtype) == 'undefined') {fromtype = '';}
	if (typeof(width) == 'undefined') {width = 620;}
	if (typeof(height) == 'undefined') {height = 430;}
	if (typeof(hidetitle) == 'undefined') {hidetitle = 0};
	var url = _ROOT_PATH + 'usercp.php?c=writemsg&a=write&touid='+touid+'&fromtype='+fromtype+'&halttype=jdbox&r='+get_rndnum(6);
	$.dialog.open(url, {title: '给会员写信件', width: width, height: height, drag: false});
	//if (hidetitle == 1) {
		$(".aui_title").css("display", "none");
	//}
}

/**
 * 弹出举报会员
 * @param:: int $touid 会员ID
 * @param:: int $width 页面宽 px
 * @param:: int $height 页面高 px 
 * @param:: int $hidetitle 是否隐藏标题框
*/
function artbox_complaint(uid, width, height, hidetitle) {
	if (typeof(width) == 'undefined') {width = 620;}
	if (typeof(height) == 'undefined') {height = 430;}
	if (typeof(hidetitle) == 'undefined') {hidetitle = 0};
	var url = _ROOT_PATH + 'usercp.php?c=complaint&uid='+uid+'&halttype=jdbox&r='+get_rndnum(6);
	$.dialog.open(url, {title: '投诉/举报会员', width: width, height: height, drag: false});
	//if (hidetitle == 1) {
		$(".aui_title").css("display", "none");
	//}
}

/**
 * 弹出发手机短信
 * @param:: int $uid 会员ID
 * @param:: int $width 页面宽 px
 * @param:: int $height 页面高 px 
 * @param:: int $hidetitle 是否隐藏标题框
*/
function artbox_sendsms(uid, width, height, hidetitle) {
	if (typeof(width) == 'undefined') {width = 620;}
	if (typeof(height) == 'undefined') {height = 370;}
	if (typeof(hidetitle) == 'undefined') {hidetitle = 0};
	var url = _ROOT_PATH + 'usercp.php?c=sms&a=write&uid='+uid+'&halttype=jdbox&r='+get_rndnum(6);
	$.dialog.open(url, {title: '给会员发手机短信', width: width, height: height, drag: false});
	if (hidetitle == 1) {
		$(".aui_title").css("display", "none");
	}
}

/**
 * 弹出查看联系方式
 * @param:: int $uid 会员ID
 * @param:: int $width 页面宽 px
 * @param:: int $height 页面高 px 
 * @param:: int $hidetitle 是否隐藏标题框
*/
function artbox_viewcontact(uid, width, height, hidetitle) {
	if (typeof(width) == 'undefined') {width = 620;}
	if (typeof(height) == 'undefined') {height = 280;}
	if (typeof(hidetitle) == 'undefined') {hidetitle = 0};
	var url = _ROOT_PATH + 'usercp.php?c=home&a=viewcontact&uid='+uid+'&halttype=jdbox&r='+get_rndnum(6);
	$.dialog.open(url, {title: '查看会员联系方式', width: width, height: height, drag: false});
	//if (hidetitle == 1) {
		$(".aui_title").css("display", "none");
	//}
}


/**
 * 发起约会邀请
 * @param:: int $uid 会员ID
 * @param:: int $width 页面宽 px
 * @param:: int $height 页面高 px 
 * @param:: int $hidetitle 是否隐藏标题框
*/
function artbox_invite(uid, width, height, hidetitle) {
	if (typeof(width) == 'undefined') {width = 640;}
	if (typeof(height) == 'undefined') {height = 485;}
	if (typeof(hidetitle) == 'undefined') {hidetitle = 0};
	var url = _ROOT_PATH + 'usercp.php?c=invite&a=invite&touid='+uid+'&halttype=jdbox&r='+get_rndnum(6);
	$.dialog.open(url, {title: '邀请会员参加约会', width: width, height: height, drag: false});
	//if (hidetitle == 1) {
		$(".aui_title").css("display", "none");
	//}
}

/**
 * 弹出看信提示框
 * @param:: int $id 信件ID
 * @param:: int $hid HASHID
 * @param:: int $width 页面宽 px
 * @param:: int $height 页面高 px 
 * @param:: int $hidetitle 是否隐藏标题框
*/
function artbox_msgalertbox(id, hid, width, height, hidetitle) {
	if (typeof(width) == 'undefined') {width = 700;}
	if (typeof(height) == 'undefined') {height = 390;}
	if (typeof(hidetitle) == 'undefined') {hidetitle = 1};
	var url = _ROOT_PATH + 'usercp.php?c=message&a=alertbox&id='+id+'&hid='+hid+'&r='+get_rndnum(6);
	$.dialog.open(url, {title: '选择看信方式', width: width, height: height});
	if (hidetitle == 1) {
		$(".aui_title").css("display", "none");
	}
}

/*-----------------------User End------------------------*/