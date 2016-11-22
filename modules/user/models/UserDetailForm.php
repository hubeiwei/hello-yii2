<?php
/**
 * Created by PhpStorm.
 * User: HBW
 * Date: 2016/5/14
 * Time: 12:24
 * To change this template use File | Settings | File Templates.
 */

namespace app\modules\user\models;

use app\common\captcha\CaptchaValidator;
use app\models\UserDetail;
use yii\base\Model;

class UserDetailForm extends Model
{
    public $gender;
    public $birthday;
    public $phone;
    public $resume;
    public $verifyCode;

    public function rules()
    {
        return [
            ['gender', 'in', 'range' => UserDetail::$gender_list],
            ['birthday', 'date', 'format' => 'php:Y-m-d'],
            ['phone', 'number'],
            ['phone', 'string', 'length' => 11],
            ['phone', 'match', 'pattern' => '/^1[34578]\d{9}$/'],
            ['resume', 'safe'],
            ['verifyCode', 'required'],
            ['verifyCode', 'string', 'length' => 4],
            ['verifyCode', CaptchaValidator::className()],
        ];
    }

    public function attributeLabels()
    {
        return [
            'gender' => '性别',
            'birthday' => '生日',
            'phone' => '电话',
            'resume' => '简介',
            'verifyCode' => '验证码',
        ];
    }
}
