<?php

namespace app\common\extensions;

use yii\db\ActiveQuery as YiiActiveQuery;

class ActiveQuery extends YiiActiveQuery
{
    use QueryTrait;
}
