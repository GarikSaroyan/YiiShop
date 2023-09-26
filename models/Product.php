<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%product}}".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $img
 * @property int $price
 * @property int $categoryId
 * @property int $cost
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%product}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description', 'img', 'price', 'categoryId', 'cost'], 'required'],
            [['price', 'categoryId', 'cost'], 'integer'],
            [['name', 'description', 'img'], 'string', 'max' => 225],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'img' => 'Img',
            'price' => 'Price',
            'categoryId' => 'Category ID',
            'cost' => 'Cost',
        ];
    }
}
