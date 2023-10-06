<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Target $model */

$this->title = 'Update Target: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Targets', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';

?>
<div class="target-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'storeName' => $storeName,

    ]) ?>

</div>
