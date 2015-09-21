<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use app\modules\admin\models\Subscribe;


class SubscribeController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                //'only' => ['logout','index'],
                'rules' => [
                    [
                        'actions' => ['index','save','delete'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],					
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
	
    public function actionIndex()
    {
		$dataProvider = new ActiveDataProvider([
			'query' => Subscribe::find(),
			'pagination' => [
				'pageSize' => 20,
			],
		]);	
        return $this->render('index',['dataProvider'=>$dataProvider]);
    }
	
    public function actionSave()
    {
		$model = (!empty($_GET['id'])) ? Bg::findOne($_GET['id']) : new Bg;

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
		
			return Yii::$app->response->redirect(['/admin/bg/index']);
		}
        return $this->render('save',['model'=>$model]);
    }

	public function actionDelete(){
		$model = Subscribe::findOne($_GET['id']);
		$model->delete();
		return Yii::$app->response->redirect(['/admin/subscribe/index']);
	}	
}

