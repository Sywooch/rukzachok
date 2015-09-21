<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use app\modules\admin\models\Products;


class ProductsController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                //'only' => ['logout','index'],
                'rules' => [
                    [
                        'actions' => ['index','save','delete'],
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
        $searchModel = new Products;
        $searchModel->load(Yii::$app->request->queryParams);
        $query = Products::find()->where('products.catalog_id=:catalog_id',[':catalog_id'=>$_GET['catID']]);
        if(!empty($searchModel->name)){
            $query->andWhere(['like', 'products.name', $searchModel->name]);
            $query->innerJoinWith(['mods'])->orWhere(['like', 'mod.art', $searchModel->name]);
        }
		$dataProvider = new ActiveDataProvider([
			'query' => $query->orderBy('id'),
			'pagination' => [
				'pageSize' => 20,
			],
		]);	
        return $this->render('index',['dataProvider'=>$dataProvider,'searchModel'=>$searchModel]);
    }
	
    public function actionSave()
    {
		$model = (!empty($_GET['id'])) ? Products::findOne($_GET['id']) : new Products;

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
		
			return Yii::$app->response->redirect(['/admin/products/index','catID'=>$_GET['catID'],'catParentID'=>$_GET['catParentID']]);
		}
        return $this->render('save',['model'=>$model]);
    }

	public function actionDelete(){
		$model = Products::findOne($_GET['id']);
		$model->delete();
		return Yii::$app->response->redirect(['/admin/products/index','catID'=>$_GET['catID'],'catParentID'=>$_GET['catParentID']]);
	}	
}