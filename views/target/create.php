<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Target $model */

$this->title = 'Create Target';
$this->params['breadcrumbs'][] = ['label' => 'Targets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="target-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
