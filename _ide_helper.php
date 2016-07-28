<?php
/**
 * Created by PhpStorm.
 * User: hubeiwei
 * Date: 2016/7/28
 * Time: 18:17
 * To change this template use File | Settings | File Templates.
 */

/**
 * Used for enhanced IDE code auto-completion.
 */
class Yii extends \yii\BaseYii
{
    /**
     * @var \yii\console\Application|\yii\web\Application|MyWebApplication
     */
    public static $app;
}

/**
 * @property User $user
 */
abstract class MyWebApplication extends yii\web\Application
{
}

/**
 * @property \app\models\User|\yii\web\IdentityInterface|null $identity
 */
class User extends \yii\web\User
{
}
