<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Catalog;
use yii\web\HttpException;

class CatalogController extends Controller
{

    public function actionIndex()
    {
            
            if(!$catalog = Catalog::find()->where(['translit'=>$_GET['translit']])->with('childs')->one())
                    throw new HttpException(404, 'Данной странице не существует!');
            
            return $this->render('index', [
                    'catalog'=>$catalog,
            ]);
    }
    
    public function actionAll()
    {
           
            $catalogs = Catalog::find()->where(['parent_id'=>0])->orderBy('sort ASC')->all();
            
            return $this->render('all', [
                    'catalogs'=>$catalogs,
            ]);
    }    
    
}