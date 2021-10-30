<?php

namespace bb\models;

use yii\db\ActiveRecord;
use bb\helpers\HyiiHelper;

class PostModel extends ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%posts}}';
    }

}