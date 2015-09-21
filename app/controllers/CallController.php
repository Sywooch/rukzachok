<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Call;
use yii\web\HttpException;

class CallController extends Controller
{

    public function actionIndex()
    {
            
            $model = new Call;
            
            if ($model->load(Yii::$app->request->post()) && $model->contact('borisenko.pavel@gmail.com')) {
                     
                return Yii::$app->response->redirect(['call/success']);      
            }            
            
            return $this->render('index', [
                    'model'=>$model,
            ]);
    }
    
    
    public function actionSuccess(){
            return $this->render('success');        
    }
    
}