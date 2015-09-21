<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Subscribe;
use yii\web\HttpException;
use yii\data\Pagination;

class SubscribeController extends Controller
{

    public function actionIndex()
    {
		$model = new Subscribe;

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
		
                    Yii::$app->getSession()->setFlash('success', 'Вы успешно подписались на рассылку!');
                    return $this->refresh();
		}
        return $this->render('index',['model'=>$model]);        
    }
    
}    