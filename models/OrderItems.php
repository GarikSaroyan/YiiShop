<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property int $id
 * @property int $orderId
 * @property int $addCount
 * @property int $price
 * @property string $productId
 * @property string $revenue
 * @property string $cost
 */
class OrderItems extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orderItems';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['orderId', 'addCount', 'price', 'productId','revenue','cost'], 'required'],
            [['orderId', 'addCount', 'price','productId','cost'], 'integer'],
//            [['revenue'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'orderId' => 'Order ID',
            'addCount' => 'Add Count',
            'price' => 'Price',
            'productId' => 'Product Id',
            'revenue'=>'Revenue',
            'cost'=>'Cost'
        ];
    }
}
