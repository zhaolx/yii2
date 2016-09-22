<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $name
 * @property integer $sex
 * @property string $birthday
 * @property string $email
 * @property string $password
 * @property string $mobile
 * @property string $qq
 * @property string $address
 * @property string $avatar
 * @property integer $point
 * @property string $moeny
 * @property string $sign
 * @property string $person_info
 * @property integer $last_login_time
 * @property string $last_login_ip
 * @property string $ip
 * @property integer $create_time
 * @property integer $status
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'birthday', 'email', 'password', 'mobile', 'create_time'], 'required'],
            [['sex', 'point', 'last_login_time', 'create_time', 'status'], 'integer'],
            [['birthday'], 'safe'],
            [['moeny'], 'number'],
            [['person_info'], 'string'],
            [['username', 'mobile', 'qq', 'last_login_ip', 'ip'], 'string', 'max' => 20],
            [['name'], 'string', 'max' => 30],
            [['email'], 'string', 'max' => 100],
            [['password'], 'string', 'max' => 32],
            [['address', 'avatar', 'sign'], 'string', 'max' => 200],
            [['username'], 'unique'],
            [['email'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'name' => 'Name',
            'sex' => 'Sex',
            'birthday' => 'Birthday',
            'email' => 'Email',
            'password' => 'Password',
            'mobile' => 'Mobile',
            'qq' => 'Qq',
            'address' => 'Address',
            'avatar' => 'Avatar',
            'point' => 'Point',
            'moeny' => 'Moeny',
            'sign' => 'Sign',
            'person_info' => 'Person Info',
            'last_login_time' => 'Last Login Time',
            'last_login_ip' => 'Last Login Ip',
            'ip' => 'Ip',
            'create_time' => 'Create Time',
            'status' => 'Status',
        ];
    }
}
