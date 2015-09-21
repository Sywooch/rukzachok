<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Brends;
use app\models\Products;
use yii\web\HttpException;
use yii\data\Pagination;

class BrendsController extends Controller
{

    public function actionShow()
    {
            
            if(!$brend = Brends::find()->where(['translit'=>$_GET['translit']])->one())
                    throw new HttpException(404, 'Данной странице не существует!');
            
                $query = Products::find()->where('brend_id=:brend_id',[':brend_id' => $brend->id])->with(['catalog'])->innerJoinWith(['cost']);
                $countQuery = clone $query;
                $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize'=>18]);
                $pages->forcePageParam = false;
                $pages->pageSizeParam = false;
                $products = $query->offset($pages->offset)
                    ->limit($pages->limit)
                    ->all();
            
            return $this->render('show', [
                    'brend'=>$brend,
                    'products'=>$products,
                    'pages'=>$pages,
            ]);
    }
    
    public function actionIndex()
    {
           
            $brends = Brends::find()->orderBy('sort ASC')->all();
            
            return $this->render('index', [
                    'brends'=>$brends,
            ]);
    }    
    
}