<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Product $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <!-- $form->field($model, 'img')->textInput(['maxlength' => true]) -->

    <?= $form->field($model, 'img')->fileInput(['maxlength' => true]); ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?php
    $item = \app\models\Category::find()->asArray()->all();
    $arr =[];
    foreach ($item as $it){
        if ($it['parentId']==''){
            $arrIt=[$it['id']=>$it['name']];
            foreach ($item as $x){
                if ($x['parentId']==$it['id']){
                    $arrIt += array($x['id'] => $x['name']);
                }
            }
            $arr += array($it['name'] => $arrIt);
        }
    }
    ?>


    <?= $form->field($model, 'categoryId')->dropDownList(
        $arr,
        ['prompt' => 'Main Category']
    );
    ?>

    <?= $form->field($model, 'cost')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
<!--        --><?php //= Html::submitButton('Update', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
