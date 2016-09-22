<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\User;
class TestController extends Controller{
	public function actionIndex(){
		try{
			Yii::info("params: ".$_SERVER['QUERY_STRING']."", 'Notify');
			$model = new User;
            return $this->render("index", array(
                "model" => $model
            ));
		}catch(Exception $e){
			Yii::info($e, 'Error');
		}
		
	}
}

?>