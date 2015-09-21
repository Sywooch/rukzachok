<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use app\modules\admin\models\Mod;


class ModController extends Controller
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

        $searchModel = new Mod;
        $searchModel->load(Yii::$app->request->queryParams);
        $query = Mod::find()->where('product_id=:product_id',[':product_id'=>$_GET['productID']]);
        if(!empty($searchModel->art))$query->andWhere((['like', 'art', $searchModel->art]));
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
		$model = (!empty($_GET['id'])) ? Mod::findOne($_GET['id']) : new Mod;

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
		
			return Yii::$app->response->redirect(['/admin/mod/index','productID'=>$_GET['productID'],'catID'=>$_GET['catID'],'catParentID'=>$_GET['catParentID']]);
		}
        return $this->render('save',['model'=>$model]);
    }

	public function actionDelete(){
		$model = Mod::findOne($_GET['id']);
		$model->delete();
		return Yii::$app->response->redirect(['/admin/mod/index','productID'=>$_GET['productID'],'catID'=>$_GET['catID'],'catParentID'=>$_GET['catParentID']]);
	}	
}
