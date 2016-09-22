<?php    
namespace app\modules\home\controllers;    
use Yii;    
use yii\web\Controller;    
use yii\helpers\Html;    
use app\models\User;
use app\models\SafeCode; 
use  yii\web\Session;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;   
class UserController extends Controller {       
	public $title = '会员中心';       
	/**
	 * @用户授权规则
	 */
	public function behaviors(){
	    return [
	           'access' => [
	                'class' => AccessControl::className(),
	                'only' => ['logout', 'signup','login','Reg'],//这里一定要加
	                'rules' => [
	                    [
	                        'actions' => ['login','captcha'],
	                        'allow' => true,
	                        'roles' => ['?'],
	                    ]
	                ],
	            ],
	            'verbs' => [
	                'class' => VerbFilter::className(),
	                'actions' => [
	                    'logout' => ['post'],
	                ],
	            ],
	        ];
    }
    /**
     * @验证码独立操作  下面这个actions注意一点，验证码调试出来的样式也许你并不满意，这里就可以需修改，这些个参数对应的类是@app\vendor\yiisoft\yii2\captcha\CaptchaAction.php,
     *可以参照这个类里的参数去修改，也可以直接修改这个类的默认参数，这样这里就不需要改了
     */
    public function actions()
    {		
        return  [	
            'captcha' => [
                        'class' => 'yii\captcha\CaptchaAction',
                        'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                        //'backColor'=>0x000000,//背景颜色
                        'maxLength' => 6, //最大显示个数
                        'minLength' => 6,//最少显示个数
                        'padding' => 1,//间距
                        'height'=>25,//高度
                        'width' => 110,  //宽度  
                       // 'foreColor'=>0xffffff,     //字体颜色
                        'offset'=>4,        //设置字符偏移量 有效果
                        //'controller'=>'reg',        //拥有这个动作的controller
                ],
		];
	}
	public function init(){           
		$this->enableCsrfValidation = true; 
		Yii::$app->session->set('VerifyCode',md5(strtolower($this->createAction('captcha')->getVerifyCode())));
	}
	public function actionIndex() {          
		try{          
			Yii::info("params:".http_build_query($_REQUEST)."", 'Notify');          
			echo  Yii::$app->homeUrl; 
			//var_dump( new User());          
		}catch(Exception $e){
		Yii::info($e, 'Error'); 
		}       
	}

    public function actionReg(){          
      	try{            
      	 //Yii::info("params: ".http_build_query($_REQUEST)."",'Notify');          
      	 $user = new User;
      	 if($_POST['User'] && md5(strtolower($_POST['safecode'])) == Yii::$app->session->get('VerifyCode')){
      	 	$user->attributes = $_POST['User'];
      	 	$user->password = md5($user->password);
      	 	$user->create_time = time();
      	 	$user->status = 0;
      	 	$user->ip = Yii::$app->request->userIP;
      	 	if($user->save()){
      	 		$this->redirect( array('/home/user/checkemail','id'=>$user->attributes['id']) );
      	 	}else{
      	 		$this->redirect( array('/home/user/reg') );
      	 	}
      	 }else{
      	 	$count = User::find()->count();
			$data['count'] = intval((time()-strtotime('2016-8-6'))/3600)*30 +$count;
      	 	return $this->render("reg", array(                 
	      	 	"model" => $user,
	      	 	'data' =>$data
				)); 
      	 }             
      	          
		}catch(Exception $e){             
			Yii::info($e, 'Error');          
		}       
	} 

	public function actionCheckemail($id){
		try{
			//Yii::info("params: ".http_build_query($_REQUEST)."",'Notify');
			$user = User::findOne($id);
			$count = User::find()->count();
			$data['count'] = intval((time()-strtotime('2016-8-6'))/3600)*30 +$count;
			if(!$user){
				$this->redirect( array('/home/user/reg') );
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
	        }
			return $this->render("checkemail", array(                 
	      	 	"model" => $user,
	      	 	'data' =>$data
				));
		}catch(Exception $e){
			Yii::info($e, 'Error'); 
		}
	}  

	public function actionActiveuser($id){
		try{
			//Yii::info("params: ".http_build_query($_REQUEST)."",'Notify');
			$user = User::findOne($id);
			$count = User::find()->count();
			$data['count'] = intval((time()-strtotime('2016-8-6'))/3600)*30 +$count;
			$verifyCode = $_POST['safecode'];
			if(!$user || !$verifyCode){
				$this->redirect( array('/home/index') );
			}
			//清除过期验证码
		    Yii::$app->db->createCommand("delete from safe_code where status = 0 and create_time < ".(time()-30*60))->execute();   
		    $safecode = SafeCode::find()->where(['user_id' => $user->id,'status'=>0])->orderBy('id desc')->one();
		    if(!$verifyCode || $safecode->code != $verifyCode){
		    	 //验证码错误
		         $this->redirect( array('/home/index') );
		    }else{
		        if($safecode->create_time+30*60 < time()){
		        	//验证码过期
		            $this->redirect( array('/home/index') );
		        }else{
		           	$user->status = 1;
		        }
		    }
		    $user->save();
		    return $this->render("active", array(                 
	      	 	"user" => $user,
	      	 	'data' =>$data
				));
		}catch(Exception $e){
			Yii::info($e, 'Error');
		}
	} 

	public function actionLogin(){
		try{
			$is_ajax = $_REQUEST['is_ajax'];
			if($is_ajax){
	            return $this->renderPartial('ajax_login');
	         }else{
	         	$count = User::find()->count();
				$data['count'] = intval((time()-strtotime('2016-8-6'))/3600)*30 +$count;
	         	return $this->render('login',array(                 
	      	 	'data' =>$data
				));
	         }
		}catch(Exception $e){
			Yii::info($e, 'Error');
		}
	}

	public function actionLogout(){
		//$this->enableCsrfValidation = false;
		try{
			//清除所有session
			//Yii::$app->session->destroy();
			//unset($_COOKIE);
			$this->redirect(array('/home/index'));
		}catch(Exception $e){
			Yii::info($e, 'Error');
		}
	}
} 
?>
