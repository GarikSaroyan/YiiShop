<?php

use app\models\Store;

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use  yii\bootstrap5\Alert;
use  yii\bootstrap5\Modal;


/** @var yii\web\View $this */
/** @var app\models\Orders $model */
/** @var yii\widgets\ActiveForm $form */


$storeName = Store::find()->asArray()->all();

//var_dump($dataProvider);
foreach ($storeName as $item) {
    $arr[$item['id']] = $item['name'];
}
?>

<div class="orders-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'userForm']]); ?>

    <?= $form->field($model, 'storeId')->dropDownList(
        $arr,
        [
            'prompt' => 'Select a Store',
//            'onchange' => '$("#orders-storeid").val(this.value);'
        ]
    );
    ?>

    <?= $form->field($model, 'addCount')->textInput(['placeholder' => 'Title', 'disabled' => true]) ?>

    <?= $form->field($model, 'totalPrice')->textInput(['placeholder' => 'Title', 'disabled' => true]) ?>


    <?php ActiveForm::end(); ?>


    <div class="orders-index">

        <div class="form-group">
            <?php
            Modal::begin([
                'title' => 'Products',
                'toggleButton' => ['label' => 'Add', 'class' => 'btn btn-primary'],
                'size' => 'modal-lg',
            ]);

            echo $this->render('alert');

            Modal::end();
            ?>
        </div>


        <!--        --><?php //= GridView::widget([
        //            'dataProvider' => $dataProvider,
        //            'filterModel' => $searchModel,
        //            'columns' => [
        //                ['class' => 'yii\grid\SerialColumn'],
        //
        //                'id',
        //                'orderId',
        //                'addCount',
        //                'price',
        //                'productId',
        //                'revenue',
        //                'cost',
        //            ],
        //        ]); ?>

        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Price</th>
                <th scope="col">Total</th>
                <th scope="col">Count</th>
                <th scope="col">Cost</th>
            </tr>
            </thead>


            <tbody id="ordersBody"></tbody>
        </table>


        <div class="form-group">
            <Button id="btn-success-order" class='btn btn-success'>Save</Button>
        </div>

    </div>

</div>
