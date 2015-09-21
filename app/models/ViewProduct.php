<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\Session;

/**
 * LoginForm is the model behind the login form.
 */
class ViewProduct extends Model
{
    
	public function add($product_id){
		$session=new Session;
                $session->open();
                $data = $session['view'];
                $i = 0; 
		if(isset($session['view'])){
		foreach($session['view'] as $key=>$view){
			if($product_id == $view){$i++;}
		}}
                if($i == 0){$data[] = $product_id;$session['view'] = $data;}
		//print_r($_SESSION['basket']);
	}
        
        public function listView(){
		$session=new Session;
                $session->open();
                return (!empty($session['view']))?$session['view']:[];            
        }
    
}
