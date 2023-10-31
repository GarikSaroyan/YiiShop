<?php

namespace app\controllers;

use app\models\Product;
use app\models\ProductSearch;
use yii\helpers\Console;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
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
     * Lists all Product models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Product();

        if ($this->request->ispost) {
            $img = $model->img;
            $imageName = $model->img;
            $model->img = UploadedFile::getInstance($model,'img');
            $model->img->saveAs('image/'.$imageName.$model->img->extension);
            $model->img = $imageName.$model->img->extension;
            $model->name = $_POST['Product']['name'];
            $model->description = $_POST['Product']['description'];
            $model->price =  $_POST['Product']['price'];
            $model->categoryId = $_POST['Product']['categoryId'];
            $model->cost = $_POST['Product']['cost'];
//            echo '<pre>';
//            var_dump($_POST);
//            $model->save();
            return $this->goHome();


        } else {
            $model->loadDefaultValues();
        }
        return $this->render('create', [
           'model' => $model,
        ]);
  }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */

     public function actionUpdate(int $id){
         $model = $this->findModel($id);
         if ($this->request->ispost) {
             $model->name = $_POST['Product']['name'];
             $model->description = $_POST['Product']['description'];
             $model->price =  $_POST['Product']['price'];
             $model->categoryId = $_POST['Product']['categoryId'];
             $model->cost = $_POST['Product']['cost'];
             \Yii::$app->getSession()->setFlash('message','Post Update Successfully');
             $model->save();
         } else {
             $model->loadDefaultValues();
         }
         return $this->render('Update', [
             'model' => $model,
         ]);
     }
    /**
     * Deletes an existing Product model.
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

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
