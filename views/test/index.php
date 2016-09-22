<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
use dosamigos\datepicker\DatePicker;
?>
<?= DatePicker::widget([
    'model' => $model,
    'attribute' => 'email',
    'template' => '{addon}{input}',
        'clientOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
]);?>