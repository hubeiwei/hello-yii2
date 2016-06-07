<?php
/**
 * Created by PhpStorm.
 * User: HBW
 * Date: 2016/5/14
 * Time: 12:24
 * To change this template use File | Settings | File Templates.
 */

namespace app\modules\user\models;

use app\models\UserDetail;
use app\modules\core\extensions\HuCaptchaValidator;
use yii\base\Model;

class UserDetailForm extends Model
{
    public $gender;
    public $birthday;
    public $email;
    public $phone;
    public $resume;
    public $verifyCode;

    public function rules()
    {
        return [
            ['gender', 'in', 'range' => UserDetail::$gender_array],
            ['birthday', 'date', 'format' => 'php:Y-m-d'],//我觉得其实只要是日期能转成时间戳就好了，居然还要特定一个格式，但这样也没有什么不好的
            ['email', 'email'],
            ['email', 'string', 'max' => 100],
            ['phone', 'number'],
            ['phone', 'string', 'length' => 11],
            ['phone', 'match', 'pattern' => '/^1[34578]\d{9}$/'],
            ['resume', 'safe'],//其实这个没啥验证应该不用写的，但我发现不写的话load不到数据，就学那些SearchModel写个safe好了
            ['verifyCode', 'required'],
            ['verifyCode', 'string', 'length' => 4],
            ['verifyCode', HuCaptchaValidator::className()],
        ];
    }

    public function attributeLabels()
    {
        return [
            'gender' => '性别',
            'birthday' => '生日',
            'email' => '邮箱',
            'phone' => '电话',
            'resume' => '简介',
            'verifyCode' => '验证码',
        ];
    }
}