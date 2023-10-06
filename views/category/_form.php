<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Category $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
<!--<pre>-->
    <!--    --><?php //= $form->field($model, 'parentId')->textInput() ?>
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
    <?= $form->field($model, 'parentId')->dropDownList(
        $arr,
        ['prompt' => 'Main Category']
    );
    ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
