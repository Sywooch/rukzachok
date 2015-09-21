<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\User;


class RegController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                //'only' => ['person'],
                'rules' => [
                    [
                        'actions' => ['person','captcha'],
                        'allow' => true,
                        'roles' => ['?'],
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

    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
            ],
        ];
    }

	private function saveUser($scenario = null){
		$model = new User();
		
		$model = (!empty($_GET['id'])) ? User::findOne($_GET['id']) : new User;
		if(!empty($scenario))$model->scenario = $scenario;

		if ($model->load(Yii::$app->request->post()) && $model->save()) {

			$modelLogin = new LoginForm();
			$modelLogin->username = $model->username;
			$modelLogin->password = $model->password;
			 $modelLogin->login();
				return Yii::$app->response->redirect(['/iam']);
					
			
		}
		
		return $model;
	}	

    public function actionPerson()
    {
            
		$model = $this->saveUser('person');

		
		return $this->render('person', [
                'model' => $model,
            ]);
    }

	
    
}