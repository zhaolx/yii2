<?php

namespace app\modules\home\controllers;

use yii\web\Controller;

/**
 * Default controller for the `home` module
 */
class IndexController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
    	echo 'Wecome to index';
        //return $this->render('index');
    }
}
