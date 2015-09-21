<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\rbac\DbManager;
use yii\web\Response;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['about','contact'],
                'rules' => [
                    [
                        'actions' => ['about'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'actions' => ['contact'],
                        'allow' => true,
                        'roles' => ['admin1'],
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
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        
//$userRole = Yii::$app->authManager->getRole('admin');
//Yii::$app->authManager->assign($userRole, 1);
/*
$auth = new DbManager;
$auth->init();
$role = $auth->createRole('admin');
$auth->add($role);

$auth->assign($role, 1);
*/

		$model = new LoginForm();
		return $this->render('index', [
                'model' => $model,
            ]);
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
	
    public function actionTerm()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'http://places.aviasales.ru/?term='.$_GET['term'].'&locale=ru');
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		$result = curl_exec($ch);
		$obj = json_decode($result);
		//print_r($obj);
		$r = [];
		foreach($obj as $o)
		{ //print_r($o);
			//foreach($o->airport_name as $airport_name)
			//{
				$r[] = ((!empty($o->airport_name)) ? $o->airport_name . ', ' : '') . $o->name . '(' . $o->iata . ')';
			//}
			
		}
		//print_r($r);
		//$r = ($obj[0]->index_strings); airport_name
		curl_close($ch);		
		return $r;
    }
	
}
