<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/** @var yii\web\View $this */
/** @var app\models\Target $model */
/** @var app\models\Target $storeName */
/** @var yii\widgets\ActiveForm $form */

?>

<div class="target-form">

    <?php $form = ActiveForm::begin(); ?>
    <!--    <pre>-->
    <?php
    $arr = [];
    foreach ($storeName as $item) {
        $arr[$item['name']] = $item['name'];
    }
    ?>

    <?= $form->field($model, 'date')->widget(DatePicker::classname(), [
        //'language' => 'ru',
        'dateFormat' => 'yyyy-MM-dd',
        'clientOptions' => ['class' => 'form-control','autocomplete'=>'off'],
        'options' => [
            'placeholder' => 'Выберите дату...',
            'autocomplete' => 'off',
        ],

    ]) ?>

    <?= $form->field($model, 'storeName')->dropDownList(
        $arr,
        ['prompt' => 'Select a Course']
    );
    ?>

    <?= $form->field($model, 'price')->textInput() ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>


</div>
