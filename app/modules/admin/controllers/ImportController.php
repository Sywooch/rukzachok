<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\modules\admin\models\Import;


class ImportController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                //'only' => ['logout','index'],
                'rules' => [
                    [
                        'actions' => ['index','save','delete','success'],
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
        $model = new Import;
        //$model->go();
		if ($model->load(Yii::$app->request->post()) && $model->uploadfile()) {
		
			return Yii::$app->response->redirect(['/admin/import/success']);
		}        
        return $this->render('index',['model'=>$model]);
    }
    
    public function actionSuccess(){
        return $this->render('success');
    }
	


	
}
