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

    <?= $form->field($model, 'date')->widget(DatePicker::classname(), [
        //'language' => 'ru',
        'dateFormat' => 'yyyy-MM-dd',
        'clientOptions' => ['class' => 'form-control']

    ]) ?>

    <?= $form->field($model, 'storeName')->dropDownList(
        ['sas' => 'sas', 'city' => 'city'],
        ['prompt' => 'Select a Course']
    );
    ?>



    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>



</div>
