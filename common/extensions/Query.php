<?php

namespace app\common\extensions;

use yii\db\Query as YiiQuery;

class Query extends YiiQuery
{
    use QueryTrait;
}
