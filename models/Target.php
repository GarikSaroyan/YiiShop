<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "target".
 *
 * @property int $id
 * @property int $date
 * @property int $storId
 */
class Target extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'target';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'storId'], 'required'],
            [['date', 'storId'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'storId' => 'Stor ID',
        ];
    }
}
