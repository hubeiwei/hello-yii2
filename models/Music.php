<?php

namespace app\models;

use app\models\base\MusicBase;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * Class Music
 * @package app\models
 *
 * 为什么要建一个BaseClass再写多一个Class来继承呢？
 *
 * 当然只用一个Class也行，我是用gii生成Model的，
 * 万一要改字段，要对比新旧代码把新字段相关的东西一点一点复制过来，
 * 很麻烦，直接覆盖的话你自己写的代码就没了
 *
 * 所以我的解决办法是建一个Class来继承gii生成的Class
 *
 * 如果你是用PHPStorm最新版的话，你应该可以很直观的看到我覆写了几个function，有些还加了内容
 */
class Music extends MusicBase
{
    /**
     * 定义这些常量和数组是因为我觉得后期用起来挺方便的，
     * 前端单纯的显示的时候我并不用写判断，直接把查出来的数据当作key传到数组里就好了，
     * 后期万一要加多一个项，我只要在这里改改就好了
     * 后期万一我想改个名字，我用IDE的重构就好了
     *
     * attribute_array用在rules
     * attribute_map在一些视图能找到
     *
     * 可能命名有点煞笔，但我也没想到其他的
     */
    const visible_yes = 'Y';
    const visible_no = 'N';
    public static $visible_array = [
        self::visible_yes,
        self::visible_no,
    ];
    public static $visible_map = [
        self::visible_yes => '显示',
        self::visible_no => '隐藏',
    ];

    const status_disable = 'N';
    const status_enable = 'Y';
    public static $status_array = [
        self::status_enable,
        self::status_disable,
    ];
    public static $status_map = [
        self::status_enable => '启用',
        self::status_disable => '禁用',
    ];

    /**
     * 给Model设置了自动填充一些字段的行为，以后添加和修改就不用顾及这些字段了
     *
     * @return array
     */
    public function behaviors()
    {
        return [
            //添加时自动将当前登录用户的id填充到user_id字段
            [
                'class' => BlameableBehavior::className(),

                /**
                 * @see BlameableBehavior::$createdByAttribute 字段默认值在这，下面时间戳的同理
                 */
                'createdByAttribute' => 'user_id',

                /**
                 * @see yii\behaviors\AttributeBehavior::$attributes 详情看这里
                 * @see BlameableBehavior::init() 默认配置在这里，只要你字段跟这个配置对上了，配一个class就可以了，比如下面的时间戳
                 *
                 * 这是有bug的，$model->save()的时候先检查规则，再插入这个字段，所以这个字段不能有非空的规则
                 */
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => ['user_id'],
                ],
            ],
            /**
             * 添加修改时自动填充时间戳
             *
             * 如果没有什么要配置的话，不用像上面那样弄个数组写class了，
             * 直接这样写className，具体自己看文档吧
             */
            TimestampBehavior::className(),
        ];
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            ['visible', 'in', 'range' => Music::$visible_array],
            ['status', 'in', 'range' => Music::$status_array],
        ]);
    }

    public function attributes()
    {
        return array_merge(parent::attributes(), [
            'user.username',
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'user.username' => '创建者',
        ]);
    }

    public function getUser()
    {
        /**
         * 第一个参数是字符串，填写带完整命名空间的类名，如果想方便重构，直接调用Model的className()方法
         * @see Object::className()
         *
         * 第二个参数，生成的SQL是on user.user_id = music.user_id，注意左右顺序
         */
        return $this->hasOne(User::className(), ['user_id' => 'user_id']);
    }
}
