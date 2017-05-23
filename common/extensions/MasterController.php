<?php

namespace app\common\extensions;

use app\common\helpers\UserHelper;
use Yii;
use yii\web\Controller;

class MasterController extends Controller
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        /**
         * 每次请求都检查用户状态和 auth_key
         * 亲测有效，即时把人踢掉了
         * 但我不确定这是最好的方法
         */
        $user = Yii::$app->user;
        if (!$user->isGuest) {
            $userIdentity = UserHelper::getUserInstance();

            $identityCookieName = $user->identityCookie['name'];
            $identityCookieData = Yii::$app->response->cookies->getValue($identityCookieName);
            list ($id, $authKey, $duration) = json_decode($identityCookieData, true);

            if (
                !$userIdentity->validateAuthKey($authKey) // auth_key 验证
                || $userIdentity->status != $userIdentity::STATUS_ACTIVE // 状态验证
            ) {
                $user->logout();
            }
        }
    }
}
