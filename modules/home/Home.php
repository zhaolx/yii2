<?php

namespace app\modules\home;

/**
 * home module definition class
 */
class Home extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\home\controllers';
    public $layout = '@app/views/layouts/home/main.php';
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        
        // custom initialization code goes here
    }
}
