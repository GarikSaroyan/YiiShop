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

    <!--    --><?php //= $form->field($model, '')->textInput() ?>

    <?= $form->field($model, 'storeId')->dropDownList(
        $arr,
        ['prompt' => 'Select a Store']
    );
    ?>

    <?= $form->field($model, 'addCount')->textInput(['placeholder' => 'Title', 'disabled' => true]) ?>
    <!---->
    <?= $form->field($model, 'totalPrice')->textInput(['placeholder' => 'Title', 'disabled' => true]) ?>

<!---->
<!--    <div class="form-group">-->
<!--        --><?php //= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
<!--    </div>-->


    <?php ActiveForm::end(); ?>


    <div class="orders-index">

        <div class="form-group">
            <?php
            Modal::begin([
                'title' => 'Products',
                'toggleButton' => ['label' => 'Add','class'=>'btn btn-primary'],
                'size'=>'modal-lg',
            ]);

            echo $this->render('alert');

            Modal::end();
            ?>
        </div>




        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'orderId',
                'addCount',
                'price',
                'productId',
                'revenue',
                'cost',
//                [
//                    'class' => ActionColumn::className(),
//                    'urlCreator' => function ($action, Orders $model, $key, $index, $column) {
//                        return Url::toRoute([$action, 'id' => $model->id]);
//                    }
//                ],
            ],
        ]); ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

    </div>

</div>
