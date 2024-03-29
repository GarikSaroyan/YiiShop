<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "target".
 *
 * @property int $id
 * @property int $date
 * @property string $storeName
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
            [['date', 'storeName','price'], 'required'],
            [['storeName'], 'string', 'max' => 225],
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
            'storeName' => 'Store Name',
            'price'=>'Price'
        ];
    }
}
