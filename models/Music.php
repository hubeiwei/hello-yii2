<?php

namespace app\models;

use app\models\base\MusicBase;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

class Music extends MusicBase
{
    /**
     * 为一些枚举类型的字段定义好常量和数组是因为我觉得后期用起来挺方便的，
     * 在页面输出时我并不用一个一个值写判断，直接把查出来的数据当作key传到数组里就好了，
     * 如果后期要加多一个项，我只要在这里加就好了
     * 如果后期我不爽想换个名字，我用IDE重构就好了
     *
     * attribute_array用在rules
     * @see rules()
     *
     * attribute_map在一些视图能找到
     *
     * 可能命名有点煞笔，但我也没想到其他的
     */
    const VISIBLE_YES = 'Y';
    const VISIBLE_NO = 'N';
    public static $visible_array = [
        self::VISIBLE_YES,
        self::VISIBLE_NO,
    ];
    public static $visible_map = [
        self::VISIBLE_YES => '显示',
        self::VISIBLE_NO => '隐藏',
    ];

    const STATUS_DISABLE = 'N';
    const STATUS_ENABLE = 'Y';
    public static $status_array = [
        self::STATUS_ENABLE,
        self::STATUS_DISABLE,
    ];
    public static $status_map = [
        self::STATUS_ENABLE => '启用',
        self::STATUS_DISABLE => '禁用',
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
