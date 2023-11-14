<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Orders $model */
/** @var app\models\OrderItems $dataItems */


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

    <?php foreach ($dataItems as $item) {
        echo DetailView::widget([
            'model' => $item,
            'attributes' => [
                'id',
                'orderId',
                'productId',
                'addCount',
                'price',
                'revenue',
                'cost',
                'storeId',

            ]
        ]);

        echo '<br><hr><br>';
    }
    ?>


</div>
