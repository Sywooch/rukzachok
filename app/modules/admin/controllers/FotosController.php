<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use app\modules\admin\models\Fotos;


class FotosController extends Controller
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
		$dataProvider = new ActiveDataProvider([
			'query' => Fotos::find()->where('product_id=:product_id',[':product_id'=>$_GET['productID']])->orderBy('id'),
			'pagination' => [
				'pageSize' => 20,
			],
		]);	
        return $this->render('index',['dataProvider'=>$dataProvider]);
    }
	
    public function actionSave()
    {
		$model = (!empty($_GET['id'])) ? Fotos::findOne($_GET['id']) : new Fotos;

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
		
			return Yii::$app->response->redirect(['/admin/fotos/index','productID'=>$_GET['productID'],'catID'=>$_GET['catID']]);
		}
        return $this->render('save',['model'=>$model]);
    }

	public function actionDelete(){
		$model = Fotos::findOne($_GET['id']);
		$model->delete();
		return Yii::$app->response->redirect(['/admin/fotos/index','productID'=>$_GET['productID'],'catID'=>$_GET['catID']]);
	}	
}

