<?php

namespace app\controllers;

use Yii;
use yii\base\Exception;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionStore()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->actionAbout();
        }


        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goHome();
        }

        $model->password = '';
        return $this->render('store', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionProduct()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('product', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }


//    public function actionCategory()
//    {
//        return $this->render('category');
//    }

    public function actionTarget()
    {
        return $this->render('target');
    }

    /**
     * @throws Exception
     */
    public function actionRegister()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->actionAbout();
        }

        $model = new \app\models\Users();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate() && $_POST['Users']['firstName']) {
                $model->firstName = $_POST['Users']['firstName'];
                $model->lastName = $_POST['Users']['lastName'];
                $model->userName = $_POST['Users']['userName'];
                $hash = Yii::$app->getSecurity()->generatePasswordHash($_POST['Users']['password']);
                $model->password = $hash;
                $model->authKey = Yii::$app->security->generateRandomString();;


                if ($model->save()) {
                    $model->save();
                } else {
                    echo "MODEL NOT SAVED";
                    print_r($model->getAttributes());
                    print_r($model->getErrors());
                    die();
                    exit;
                }

                // form inputs are valid, do something here
                return $this->redirect(array('site/store'));
            }
        }

        return $this->render('register', [
            'model' => $model,
        ]);
    }


}
