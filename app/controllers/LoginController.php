<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\LoginForm;
use app\models\User;

class LoginController extends Controller
{
	//public $layout='layout';
    public function actionIndex()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('index', [
                'model' => $model,
            ]);
        }
    }
	
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
    
    public function actionForgot(){
        
            $model = new User;
            if(!empty($_POST['User']['username'])){
                if($user = User::find()->where(['username'=>$_POST['User']['username']])->one())
                    $user->sendMsg();
                Yii::$app->getSession()->setFlash('success', 'На указанный Вами эмейл отправленно письмо с паролем!');
                return $this->refresh();
            }
        
            return $this->render('forgot', [
                'model' => $model,
            ]);        
    }
}