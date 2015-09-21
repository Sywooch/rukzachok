<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use app\modules\admin\models\Brends;


class BrendsController extends Controller
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
			'query' => Brends::find()->orderBy('id'),
			'pagination' => [
				'pageSize' => 20,
			],
		]);	
        return $this->render('index',['dataProvider'=>$dataProvider]);
    }
	
    public function actionSave()
    {
		$model = (!empty($_GET['id'])) ? Brends::findOne($_GET['id']) : new Brends;

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
		
			return Yii::$app->response->redirect(['/admin/brends/index']);
		}
        return $this->render('save',['model'=>$model]);
    }

	public function actionDelete(){
		$model = Brends::findOne($_GET['id']);
		$model->delete();
		return Yii::$app->response->redirect(['/admin/brends/index']);
	}	
}
