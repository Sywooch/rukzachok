<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Text;
use app\models\News;
use app\models\Catalog;
use app\models\Products;

class SiteController extends Controller
{


    public function actionIndex()
    {
            
            $catalogs = Catalog::find()->where(['parent_id'=>'0'])->all();
            $modelText = Text::find()->where(['translit'=>'home'])->one();
            $news = News::find()->orderBy('id DESC')->limit(4)->all();
            $products_new = Products::find()->where(['new'=>'1'])->orderBy('id DESC')->innerJoinWith(['cost'])->groupBy('id')->limit(4)->all();
            //print_r($products_new);
            $products_top = Products::find()->where(['top'=>'1'])->orderBy('id DESC')->innerJoinWith(['cost'])->groupBy('id')->limit(4)->all();
            //print_r($products_top);
            //$products_sale = Products::find()->where(['sale'=>'1'])->innerJoinWith(['cost'])->orderBy('id DESC')->limit(4)->all();
            $products_akciya = Products::find()->where(['akciya'=>'1'])->innerJoinWith(['cost'])->orderBy('id DESC')->limit(4)->all();
            return $this->render('index', [
                    'text'=>$modelText,
                    'catalogs'=>$catalogs,
                    'news'=>$news,
                    'products_new'=>$products_new,
                    'products_top'=>$products_top,
                    'products_akciya'=>$products_akciya,
            ]);
    }
    
    public function actionError(){
   
        return $this->render('error', [
            'code'=>Yii::$app->errorHandler->exception->statusCode,        
            'message'=>Yii::$app->errorHandler->exception->getMessage(),
            ]);        
    }
    
}