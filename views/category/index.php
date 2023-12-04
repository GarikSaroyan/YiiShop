<?php

use app\models\Category;
use kartik\sortable\Sortable;

//use richardfan\sortable\SortableGridView;
use richardfan\sortable\SortableGridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ActiveForm;


/** @var yii\web\View $this */
/** @var app\models\CategorySearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var yii\data\ActiveDataProvider $dataProviderArr */

$this->title = 'Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Category', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <ul id='categoryBody' class="list-group" style="width:70vw">
    </ul>

    <!--    --><?php //=
    //
    //        GridView::widget([
    //            'dataProvider' => $dataProvider,
    //            'filterModel' => $searchModel,
    //            'columns' => [
    //                ['class' => 'yii\grid\SerialColumn'],
    //
    //                'id',
    //    //            'name',
    //                [
    //                    'attribute' => 'name', // replace with your actual attribute
    //                    'label' => 'Name',      // replace with your desired label
    //                    'format' => 'text',             // format as text, you can change as needed
    //    //                'headerOptions' => ['class' => 'text-center'], // add any header options
    //    //                'contentOptions' => ['class' => 'text-center'], // add any content options
    //                    'enableSorting' => true,         // enable sorting for this column
    //                ],
    //                [
    //                    'label' => 'Parent',
    //                    'attribute' => 'parentId',
    //                    'content' => function ($model) {
    //                        if (\app\models\Category::find()->where(['id' => $model->parentId])->one()) {
    //                            return \app\models\Category::find()->where(['id' => $model->parentId])->one()->name;
    //                        }
    //                        return '-';
    //                    }
    //                ],
    //                [
    //                    'class' => ActionColumn::className(),
    //                    'urlCreator' => function ($action, Category $model, $key, $index, $column) {
    //                        return Url::toRoute([$action, 'id' => $model->id]);
    //                    }
    //                ],
    //            ],
    //            'options' => [
    //                'class' => 'table-responsive',
    //            ],
    //            'tableOptions' => [
    //                'class' => 'table table-striped table-bordered table-body',
    //            ],
    //    //        'enableSorting' => true,
    //        ]);
    //
    //    ?>


</div>
