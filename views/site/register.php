<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Users $model */
/** @var ActiveForm $form */


$this->title = 'Register';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-register">
    <h1><?= Html::encode($this->title) ?></h1>


    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'firstName')->textInput(['autofocus' => true]) ?>
        <?= $form->field($model, 'lastName')->textInput() ?>
        <?= $form->field($model, 'userName')->textInput() ?>
        <?= $form->field($model, 'password')->passwordInput() ?>

        <div class="form-group">
            <?= Html::submitButton('Registration', ['class' => 'btn btn-primary','name' => 'register-button']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- site-register -->
