<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property int $id
 * @property int $storeId
 * @property int $addCount
 * @property int $totalPrice
 * @property string $date
 */
class Orders extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['storeId', 'addCount', 'totalPrice', 'date'], 'required'],
            [['storeId', 'addCount', 'totalPrice'], 'integer'],
            [['date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'storeId' => 'Store ID',
            'addCount' => 'Add Count',
            'totalPrice' => 'Total Price',
            'date' => 'Date',
        ];
    }
}
