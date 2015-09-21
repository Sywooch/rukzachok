<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Text;
use yii\web\HttpException;

class TextController extends Controller
{

    public function actionIndex()
    {
            
            if(!$modelText = Text::find()->where(['translit'=>$_GET['translit']])->one())
                    throw new HttpException(404, 'Данной странице не существует!');
            
            return $this->render('index', [
                    'text'=>$modelText,
            ]);
    }    
    
}