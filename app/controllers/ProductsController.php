<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use yii\data\Pagination;
use yii\web\Session;
use app\models\Catalog;
use app\models\Products;
use app\models\Mod;
use app\models\Filters;
use app\models\ProductsFilters;
use app\models\ProductsType;
use app\models\ProductsBrends;
use app\models\ViewProduct;

class ProductsController extends Controller
{

    public function actionIndex()
    {
            $modelProducts = new Products;
            
            $modelProducts->load($_POST);
            
            
            if(!$catalog = Catalog::find()->where(['translit'=>$_GET['translit']])->with('parent')->one())
                    throw new HttpException(404, 'Данной странице не существует!');
            
            
                $query = Products::find()->where('catalog_id=:catalog_id OR catalog_parent_id=:catalog_parent_id',[':catalog_id' => $catalog->id,':catalog_parent_id'=>$catalog->id])->with(['catalog'])->innerJoinWith(['cost']) ;

                if(!empty($_POST['Products']['minCost']) && !empty($_POST['Products']['maxCost']))$query->andWhere('(cost>=:minCost and cost<=:maxCost)',[':minCost'=>$_POST['Products']['minCost'],':maxCost'=>$_POST['Products']['maxCost']]);
                if(!empty($_GET['brends'])){ 
                    $b = explode(';',$_GET['brends']);
                    $query->andWhere(['brend_id'=>$b]);
                }    
                if(!empty($_GET['filters'])){ 
                    $l = explode(';',$_GET['filters']);
                    $items = Filters::find()->where(['parent_id'=>0])->all();
                    foreach($items as $key=>$it){
                    $f = [];
                    foreach($it->childs as $c){
                        
                        if(in_array($c['id'], $l))$f[] = $c['id'];
                    }
                    if(count($f)>0)
                        $query->innerJoin('productsFilters as filter_'.$key,'filter_'.$key.'.product_id=products.id')->andWhere(['filter_'.$key.'.filter_id'=>$f]);
                       // $childs->leftJoin('productsFilters as pf_'.$key, 'pf_'.$key.'.product_id = productsFilters.product_id')->andWhere(['pf_'.$key.'.filter_id'=>$f]);                          
                    }               
                }
                if(!empty($modelProducts->fasovka)){
                   $query->innerJoinWith(['fasovka'])->andWhere([ProductsFasovka::tableName().'.fasovka_id'=>$modelProducts->fasovka]); 
                }
                if(!empty($modelProducts->type)){
                   $query->innerJoinWith(['type'])->andWhere([ProductsType::tableName().'.type_id'=>$modelProducts->type]); 
                }
                if(!empty($modelProducts->brends)){
                   $query->innerJoinWith(['brends'])->andWhere([ProductsBrends::tableName().'.brend_id'=>$modelProducts->brends]); 
                }                
                $query->groupBy(['id']);
                $countQuery = clone $query;
                $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize'=>15]);
                $pages->forcePageParam = false;
                $pages->pageSizeParam = false;
                $products = $query->offset($pages->offset)
                    ->limit($pages->limit)
                    ->all();

            return $this->render('index', [
                'modelProducts'=>$modelProducts,    
                'catalog'=>$catalog,
                'pages'=>$pages,
                'products'=>$products,
            ]);
    }
    
    public function actionSearch(){
                $query = Products::find()->innerJoinWith(['catalog'])->innerJoinWith(['cost'])->innerJoinWith(['brend']) ;
                if (!empty($_GET['search_str'])) {
                    $query->andWhere(['like', 'products.name', $_GET['search_str']]);
                    $query->orWhere(['like', 'catalog.name', $_GET['search_str']]);
                    $query->orWhere(['like', 'catalog_brends.name', $_GET['search_str']]);
                    $query->orWhere(['like', 'mod.art', $_GET['search_str']]);
                }
                $query->groupBy(['id']);
                $countQuery = clone $query;
                $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize'=>20]);
                $pages->forcePageParam = false;
                $pages->pageSizeParam = false;
                $products = $query->offset($pages->offset)
                    ->limit($pages->limit)
                    ->all();

            return $this->render('search', [
                'pages'=>$pages,
                'products'=>$products,
            ]);        
    }
    
    public function actionShow(){

        if(!$catalog = Catalog::find()->where(['translit'=>$_GET['translit_rubric']])->with('parent')->one())
                    throw new HttpException(404, 'Данной странице не существует!');
          
        
        if(!$product = Products::find()->where(['id'=>$_GET['id']])->one())
                    throw new HttpException(404, 'Данной странице не существует!');        
           
        ViewProduct::add($product->id);            
        return $this->render('show', [
                'catalog'=>$catalog,
                'product'=>$product,
            ]);
    }
    
    public function actionCompare(){ 
		$session=new Session;
                $session->open();
                
                if(!empty($_GET['id'])){
                $i = 0;
		if(isset($session['compare'])){
		foreach($session['compare'] as $key=>$compare){
			if($_GET['id'] == $compare){$i++;}
		}} 
                if($i == 0){$data[] = $_GET['id'];$session['compare'] = $data;}
                Yii::$app->getSession()->setFlash('success', 'Этот товар добавлен к сравнению!');
                return $this->redirect(Yii::$app->request->referrer);
                }
                else{
                    //print_r($session['compare']);
                   $products = Products::find()->where(['id'=>$session['compare']])->all();
                    return $this->render('compare', [
                            'products'=>$products,
                        ]);                  
                }
    }
    
    
  
    
}