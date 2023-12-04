<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Orders;

/**
 * OrdersSearch represents the model behind the search form of `app\models\Orders`.
 */
class OrderItemsSearch extends OrderItems
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id','orderId', 'addCount', 'price', 'productId','revenue','cost'], 'required'],
            [['id','orderId', 'addCount', 'price','productId','cost'], 'integer'],
//            [['revenue'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = OrderItems::find();
        if ($params && $params['id']){
            $query->where(['orderId' => $params['id']]) ;
        }
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

//        if (!$this->validate()) {
//            // uncomment the following line if you do not want to return any records when validation fails
//            // $query->where('0=1');
//            return $dataProvider;
//        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'orderId' => $this->orderId,
            'addCount' => $this->addCount,
            'price' => $this->price,
            'productId' => $this->productId,
            'revenue' => $this->revenue,
            'cost' => $this->cost,
        ]);
        return $dataProvider;
    }
}
