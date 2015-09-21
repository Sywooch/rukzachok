<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Mod;
use app\models\Order;
use app\models\User;
use app\models\OrdersProducts;
use yii\web\HttpException;

class BasketController extends Controller
{

    public function actionIndex(){ 
            $modelMod = new Mod;
            $modelOrder = new Order;

            if(!empty($_GET['deleteID'])){
                $modelMod->deleteBasketMod($_GET['deleteID']);
                return Yii::$app->response->redirect(['basket/index']);
            }
            
            if(isset($_POST['update'])){
                foreach ($_POST['Mod'] as $index=>$row) {
                  $modelMod->updateBasket($row);  
                }
            }elseif(isset($_POST['Mod'])){
                $body = '';
                foreach ($_POST['Mod'] as $index=>$row) {
                  $body .= $row['product_name'].' '.$row['name'].' Кол:'.$row['count'].' Цена:'.$row['sum_cost'];
                  $body .= "\n\r";
                }
                $body .= "\n\r";
  
                    if ($modelOrder->load(Yii::$app->request->post()) && $modelOrder->save() && $modelOrder->contact('borisenko.pavel@gmail.com',$body)) {
                        foreach ($_POST['Mod'] as $index=>$row) {
                          $modelOrdersProducts = new OrdersProducts;
                            $mod_id = $row['id'];
                            unset($row['id']);
                          $data['OrdersProducts'] = $row;
                            $data['OrdersProducts']['mod_id'] = $mod_id;
                          $data['OrdersProducts']['order_id'] = $modelOrder->id;

                          $modelOrdersProducts->load($data);
                          $modelOrdersProducts->save();
                        }
                        if(!Yii::$app->user->id){
                        $modelUser = new User;
                        $modelUser->role = 'person';
                        $modelUser->username = $modelOrder->email;
                        $modelUser->name = $modelOrder->name;
                        $modelUser->phone = $modelOrder->phone;
                        $modelUser->password = Yii::$app->getSecurity()->generateRandomString(10);
                        $modelUser->group_id = 2;
                        $modelUser->save();
                        }
                        $modelMod->clearBasket();
                        return Yii::$app->response->redirect(['basket/success']);      
                    }
                }            
            
            $basket_mods = $modelMod->getBasketMods();

            if(!empty(Yii::$app->user->id)){
                $user = User::findOne(Yii::$app->user->id);
                $modelOrder->email = $user->username;
                $modelOrder->phone = $user->phone;
                $modelOrder->name = $user->name;
                $modelOrder->surname = $user->surname;
            }
           
            return $this->render('index', [
                    'modelMod'=>$modelMod,
                    'basket_mods'=>$basket_mods,
                    'modelOrder'=>$modelOrder,
            ]);        
    }

    public function actionItems(){
        $modelMod = new Mod;
        if(!empty($_GET['deleteID'])){
            $modelMod->deleteBasketMod($_GET['deleteID']);
        }

        if(isset($_POST['Mod'])){
            foreach ($_POST['Mod'] as $index=>$row) {
                $modelMod->updateBasket($row);
            }
        }
        $basket_mods = $modelMod->getBasketMods();
        return $this->renderAjax('ajax_items', [
            'modelMod'=>$modelMod,
            'basket_mods'=>$basket_mods,
        ]);
    }
    
    public function actionInfo()
    {
            $modelMod = new Mod;
            $info = $modelMod->rowBasket();
            return $this->renderAjax('ajax_info', [
                    'info'=>$info,
            ]);
    } 
    
        public function actionAdd(){
		$modelMod = new Mod;
                if(isset($_GET['mod_id'],$_GET['count']) && $_GET['mod_id']>0 && $_GET['count']>0){
			$modelMod->addBasket($_GET['mod_id'],$_GET['count']);
		}
                
                Yii::$app->end();
        }
        
        
        public function actionSuccess(){
            return $this->render('success');            
        }
        
        
    
}