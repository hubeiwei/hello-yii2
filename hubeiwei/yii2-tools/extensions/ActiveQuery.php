<?php

namespace hubeiwei\yii2tools\extensions;

use yii\db\ActiveQuery as YiiActiveQuery;

class ActiveQuery extends YiiActiveQuery
{
    use QueryTrait;
}
