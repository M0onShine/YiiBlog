<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%relationships}}".
 *
 * @property integer $cid
 * @property integer $mid
 */
class Relationship extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%relationships}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cid', 'mid'], 'required'],
            [['cid', 'mid'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cid' => 'Cid',
            'mid' => 'Mid',
        ];
    }
}
