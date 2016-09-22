<?php

namespace app\modules\api\controllers;
use Yii;
use yii\web\Controller;
use app\models\User;
use app\models\SafeCode;
use  yii\web\Session;

/**
 * Default controller for the `api` module
 */
class CommonController extends Controller{
    /**
     * Renders the index view for the module
     * @return string
     */
    public $enableCsrfValidation = false; 

    public function actionCheckusername(){
    	$username = isset($_REQUEST['username'])?$_REQUEST['username']:null;
    	if(!Yii::$app->request->isAjax){
    		$this->renderErrorMsg(400);
    	 }
    	if(!$username){
    		$this->renderErrorMsg(300);
    	}
    	$user = User::find()->where(['username' => $username])->one();
        if($user){
        	$this->renderErrorMsg(310);
        }else{
        	$this->renderSuccessMsg('可以注册');
        }
    }

     public function actionCheckemail(){
        $email = isset($_REQUEST['email'])?$_REQUEST['email']:null;
        if(!Yii::$app->request->isAjax){
            $this->renderErrorMsg(400);
         }
        if(!$email){
            $this->renderErrorMsg(300);
        }
        $user = User::find()->where(['email' => $email])->one();
        if($user){
            $this->renderErrorMsg(311);
        }else{
            $this->renderSuccessMsg('可以注册');
        }
    }

    public function actionCheckcode(){
    	$verifyCode = isset($_REQUEST['code'])?$_REQUEST['code']:null;
    	if(!Yii::$app->request->isAjax){
    		$this->renderErrorMsg(400);
    	 }
    	if(!$verifyCode){
    		$this->renderErrorMsg(300);
    	}
        if(Yii::$app->session->get('VerifyCode') != md5(strtolower($verifyCode))){
        	$this->renderErrorMsg(320);
        }else{
        	$this->renderSuccessMsg('验证码正确');
        }
    }

    public function actionResendemail(){
        $email = isset($_REQUEST['email'])?$_REQUEST['email']:null;
        if(!Yii::$app->request->isAjax){
            $this->renderErrorMsg(400);
         }
        if(!$email){
            $this->renderErrorMsg(301);
        }
        $user = User::find()->where(['email' => $email])->one();
        if(!$user){
             $this->renderErrorMsg(300);
        }
        $CheckCode= rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);
        $body = "您此次激活账户的验证码为：".$CheckCode."，请在30分钟内完成验证，逾期无效！！！";
        $mail= Yii::$app->mailer->compose();  
        $mail->setTo($user->email);    
        $mail->setSubject("激活账户");      
        $mail->setHtmlBody($body);
        if($mail->send()){
            $model = new SafeCode;
            $model->user_id = $user->id;
            $model->code = $CheckCode;
            $model->type = 1;
            $model->create_time = time();
            $model->save();
            $this->renderSuccessMsg('发送成功');
        }else{
            $this->renderErrorMsg(330);
        } 

    }

   public function actionChecksafecode(){
        $user_id = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:null;
        $code = isset($_REQUEST['code'])?$_REQUEST['code']:null;
        if(!Yii::$app->request->isAjax){
            $this->renderErrorMsg(400);
         }
        if(!$user_id || !$code){
            $this->renderErrorMsg(301);
        }
        //清除过期验证码
        Yii::$app->db->createCommand("delete from safe_code where status = 0 and create_time < ".(time()-30*60))->execute();   
        $safecode = SafeCode::find()->where(['user_id' => $user_id,'status'=>0])->orderBy('id desc')->one();
        if(!$safecode || $safecode->code != $code){
             $this->renderErrorMsg(320);
        }else{
            if($safecode->create_time+30*60 < time()){
                $this->renderErrorMsg(321);
            }else{
                $this->renderSuccessMsg('验证通过');
            }
        }
    }

    public function actionAjaxlogin(){
        $loginname = isset($_REQUEST['loginname'])?$_REQUEST['loginname']:null;
        $password = isset($_REQUEST['password'])?$_REQUEST['password']:null;
        $verifyCode = isset($_REQUEST['checkcode'])?$_REQUEST['checkcode']:null;
        if(!Yii::$app->request->isAjax){
            $this->renderErrorMsg(400);
         }
        if(!$loginname || !$password || !$verifyCode){
            $this->renderErrorMsg(301);
        }
        if(Yii::$app->session->get('VerifyCode') != md5(strtolower($verifyCode))){
            $this->renderErrorMsg(320);
        }
        if(preg_match('/^([\S]+)@([\S]+)/',$loginname)){
             $user = User::find()->where(['email' => $loginname,'password'=>md5($password)])->one();
        }else{
            $user = User::find()->where(['username' => $loginname,'password'=>md5($password)])->one();
        }
        if(!$user){
            $this->renderErrorMsg(313);
        }
        if($user[status] =='-1'){
            $this->renderErrorMsg(314);
        }elseif($user[status] =='0'){
            $this->renderErrorMsg(315,array('userid'=>$user->id));
        }
        $user->last_login_time = time();
        $user->last_login_ip = Yii::$app->request->userIP;
        if($user->save()){
            Yii::$app->session->set('userid',$user->id);
            Yii::$app->session->set('username',$user->username);
            $this->renderSuccessMsg('登录成功');
        }else{
            $this->renderErrorMsg(500);
        }
    }

    private function renderSuccessMsg($msg){
		header('Content-Type: application/json;charset=UTF-8');
		$result = array('status' => 1, 'result'=>$msg);
		echo json_encode($result);
		Yii::$app->end();
       
    }

    private function renderErrorMsg($errCode,$attr = array()){
		header('Content-Type: application/json;charset=UTF-8');
		$errMsg = Yii::$app->params['errorMsg'][$errCode];
		$result = array('status' => 0, 'errcode'=>$errCode,'msg' => $errMsg,'attr'=>$attr);
		echo json_encode($result);
		Yii::$app->end();
    }
}
