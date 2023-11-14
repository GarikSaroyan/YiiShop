<?php

namespace app\controllers;

use app\models\OrderItems;
use app\models\Orders;
use app\models\OrderItemsSearch;
use app\models\OrdersSearch;
use app\models\Product;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use function React\Promise\all;

/**
 * OrdersController implements the CRUD actions for Orders model.
 */
class OrdersController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Orders models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new OrdersSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Orders model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $dataItems = OrderItems::find()->where(['orderId' => $id])->asArray()->all();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'dataItems' => $dataItems
        ]);
    }

    /**
     * Creates a new Orders model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Orders();
        $searchModel = new OrderItemsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreateOrder()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isGet) {

            $storeName = \app\models\Product::find()->asArray()->all();
            return json_encode($storeName);
        }

        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            $model = new Orders();
            $model->storeId = $_POST['storeId'];
            $model->totalPrice = $_POST['totalPrice'];
            $model->addCount = $_POST['addCount'];
            $model->date = date('Y-m-d H-i-s', time() + 60 * 60);
            $model->save();

            $insert_id = $model->getDb()->getLastInsertId();

            foreach ($_POST['newData'] as $item) {

                $modelItem = new OrderItems();
                $modelItem->orderId = $insert_id;
                $modelItem->productId = $item['id'];
                $modelItem->addCount = $item['count'];
                $modelItem->price = $item['price'];
                $modelItem->revenue = ($item['price'] - $item['cost']) * $item['count'];
                $modelItem->cost = $item['cost'];
                $modelItem->storeId = $_POST['storeId'];
                $modelItem->save();

            }
        }


    }

    /**
     * Updates an existing Orders model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {


        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionUpdateItem(){

        Yii::$app->db->createCommand()
            ->update('orders',
                ['storeId' =>  $_POST['storeId'],'addCount' =>  $_POST['addCount'],'totalPrice' =>  $_POST['totalPrice']],
                ['id' => $_POST['id']],
            )
            ->execute();

        Yii::$app
            ->db
            ->createCommand()
            ->delete('orderItems', ['orderId' => $_POST['id']])
            ->execute();

        foreach ($_POST['newData'] as $item) {

            $modelItem = new OrderItems();
            $modelItem->orderId = $_POST['id'];
            $modelItem->productId = $item['id'];
            $modelItem->addCount = $item['count'];
            $modelItem->price = $item['price'];
            $modelItem->revenue = ($item['price'] - $item['cost']) * $item['count'];
            $modelItem->cost = $item['cost'];
            $modelItem->storeId = $_POST['storeId'];
            $modelItem->save();

        }

            return json_encode($_POST);

    }

    /**
     * Deletes an existing Orders model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    public function actionGetOrderItems()
    {
            $storeName = OrderItems::find()->where(['orderId' => $_POST['id']])->asArray()->all();
            return json_encode($storeName);
    }


    public function actionGetProductDb()
    {
        $arr = ArrayHelper::toArray(Product::findAll($_POST['id']));
        return json_encode($arr);
    }

    /**
     * Finds the Orders model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Orders the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Orders::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
