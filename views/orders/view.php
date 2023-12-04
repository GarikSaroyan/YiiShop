<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Orders $model */
/** @var app\models\OrderItems $dataItems */
/** @var app\models\OrderItems $searchModel */


$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="orders-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'storeId',
            'addCount',
            'totalPrice',
            'date',
        ],
    ]) ?>
    <br>
    <h3>Orders Item</h3>

    <?= GridView::widget([
        'dataProvider' => $dataItems,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'orderId',
            [
                'label' => 'Product',
                'attribute' => 'productId',
                'content' => function ($model) {
                    if (\app\models\Product::find()->where(['id' => $model->productId])->one()) {
                        return \app\models\Product::find()->where(['id' => $model->productId])->one()->name;
                    }
                    return $model->productId;
                }
            ],
            'addCount',
            'price',
            'revenue',
            'cost',
            [
                'label' => 'Store',
                'attribute' => 'storeId',
                'content' => function ($model) {
                    return \app\models\Store::find()->where(['id' => $model->storeId])->one()->name;
                }
            ],

        ],
    ]); ?>


</div>
