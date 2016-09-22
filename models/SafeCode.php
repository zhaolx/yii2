<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "safe_code".
 *
 * @property string $id
 * @property integer $user_id
 * @property string $code
 * @property integer $update_time
 * @property integer $create_time
 * @property integer $type
 * @property integer $status
 */
class SafeCode extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'safe_code';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'update_time', 'create_time', 'type', 'status'], 'integer'],
            [['code', 'create_time'], 'required'],
            [['code'], 'string', 'max' => 6],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'code' => 'Code',
            'update_time' => 'Update Time',
            'create_time' => 'Create Time',
            'type' => 'Type',
            'status' => 'Status',
        ];
    }
}
