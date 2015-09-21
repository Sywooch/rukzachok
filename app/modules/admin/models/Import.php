<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use app\components\resize;
use app\components\Translite;
use app\modules\admin\models\Catalog;
use app\modules\admin\models\Products;
use app\modules\admin\models\Mod;
use app\modules\admin\models\Fotos;
use app\modules\admin\models\Type;
use app\modules\admin\models\Filters;
use app\modules\admin\models\Brends;
use app\modules\admin\models\ProductsParams;
use app\modules\admin\models\Fasovka;
use app\modules\admin\models\ProductsFasovka;
/**
 * ContactForm is the model behind the contact form.
 */
class Import extends Model
{
    public $file;
    public $type;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
                 [['type'], 'required'],
                [['type'], 'only_type'],
               [['file'], 'file', 'extensions'=>'csv', 'skipOnEmpty'=>true],

        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'file' => 'Файл .csv',
        ];
    }

    public function only_type($attribute){
        if($file = UploadedFile::getInstance($this,'file')) {
            if ($this->type == 'products.csv' && $file->name == 'file_1.csv')
                $this->addError('type', 'Не правильный "Загразка товаров" только не file_1.csv');
            elseif ($this->type == 'file_1.csv' && $file->name != 'file_1.csv')
                $this->addError('type', 'Не правильный "Обновление цен" только можно file_1.csv');
        }else $this->addError('file', 'Не загружен файл!');
    }

    public function uploadfile(){
        if ($this->validate()) {
            if ($file = UploadedFile::getInstance($this, 'file')) {
                $file->saveAs('upload/'.$this->type);
            }

            return true;
        } else {
            return false;
        }
    }


    public function go()
    { 
            $dir = '/var/www/rukzachok/data/www/rukzachok.com.ua/';
            $db = Yii::$app->db;
            $this->file = $dir . 'upload/products.csv';//UploadedFile::getInstance($this, 'file');
          //->tempName
        if (($handle = fopen($this->file, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 10000, ";")) !== FALSE) {
//print"<pre>";print_r($data);exit;
                $catalogParent = $data[0];
                $brend = $data[1];
               // $catalogParent_image = $data[1];
              //  $catalog = $data[2];
              //  $catalog_image = $data[3];  
                $product = $data[2];
                $product_image = explode('=',$data[18]);
                $product_image = $product_image[3];
               // $product_char = $data[6];
                $product_body_uk = $data[3];
                $product_body_ru = $data[4];
                
               // $mods = explode('|',$data[8]);
               // $fotos = explode('|',$data[9]);
                $filters = explode(',',$data[5]);
                $filters2 = explode(',',$data[6]);
                $sex = explode(',',$data[7]);
                $years = explode(',',$data[8]);
                
                $product_cost_old = $data[9];
                $produc_cost = $data[10];
                
                $product_akciya = $data[11];
                
                $similar = explode(',',$data[12]);
                
                $product_new = $data[13];
                $product_top = $data[14];
                
                $params = explode('=',$data[15]);
                
                $product_video = $data[16];
                
                $fotos = explode(',',$data[17]);
               // $brends = explode('|',$data[11]);
               // $fasovkas = explode('|',$data[12]);
               // $product_new = $data[13];
               // $product_top = $data[14];
               // $product_akciya = $data[15];
                //*********catalogParent*********//
                $modelCatalog = Catalog::find()->where('name=:name and parent_id=0',[':name'=>$catalogParent])->one();
                            
                        if(empty($modelCatalog->id)){    
                            $db->createCommand()->insert('catalog', [
                               'name' => $catalogParent,
                               //'image' => $catalogParent_image,
                               'translit' => Translite::rusencode($catalogParent),
                           ])->execute();
                           $catalogParent_id = Yii::$app->db->lastInsertID;
                        }else{
                            
                            $db ->createCommand()
                            ->update('catalog', [ 
                                'name' => $catalogParent,
                                //'image' => $catalogParent_image,
                                'translit' => Translite::rusencode($catalogParent),
                                ], 'id = '.$modelCatalog->id)
                            ->execute();
                            $catalogParent_id = $modelCatalog->id;
                           
                        }
                       // if(is_file('upload/catalog/'.$catalogParent_image)){
			//$resizeObj = new resize('upload/catalog/'.$catalogParent_image);
			//$resizeObj -> resizeImage(195, 186, 'crop');
                       // $resizeObj -> saveImage('upload/catalog/ico/'.$catalogParent_image, 100);
                        //}
                        //*********END catalogParent*********//
                        
                //*********catalog*********//
               /** $modelCatalog = Catalog::find()->where('name=:name and parent_id='.$catalogParent_id,[':name'=>$catalog])->one();
                            
                        if(empty($modelCatalog->id)){    
                            $db->createCommand()->insert('catalog', [
                               'parent_id'=>$catalogParent_id,
                                'name' => $catalog,
                               'image' => $catalog_image,
                               'translit' => Translite::rusencode($catalog),
                           ])->execute();
                           $catalog_id = Yii::$app->db->lastInsertID;
                        }else{
                            
                            $db ->createCommand()
                            ->update('catalog', [ 
                                'parent_id'=>$catalogParent_id,
                                'name' => $catalog,
                                'image' => $catalog_image,
                                'translit' => Translite::rusencode($catalog),
                                ], 'id = '.$modelCatalog->id)
                            ->execute();
                            $catalog_id = $modelCatalog->id;
                           
                        }
			if(is_file('upload/catalog/'.$catalog_image)){
                        $resizeObj = new resize('upload/catalog/'.$catalog_image);
			$resizeObj -> resizeImage(195, 186, 'crop');
                        $resizeObj -> saveImage('upload/catalog/ico/'.$catalog_image, 100);
                        }**/
                        //*********END catalog*********// 
                        
                        
                        
                            $modelBrends = Brends::find()->where('name=:name',[':name'=>$brend])->one();
                            $fields = [
                                'name'=>$brend,
                                'translit' => Translite::rusencode($brend),
                            ];
                            if(empty($modelBrends->id)){    
                                $db->createCommand()->insert('catalog_brends', $fields)->execute();
                                $brend_id = Yii::$app->db->lastInsertID;
                            }else{
                                $db->createCommand()->update('catalog_brends', $fields, 'id = '.$modelBrends->id)->execute();                                
                                $brend_id = $modelBrends->id;
                                
                            }                        
                        
                //*********product*********//
                $modelProducts = Products::find()->where('name=:name',[':name'=>$product])->one();
                            
                        if(empty($modelProducts->id)){    
                            $db->createCommand()->insert('products', [
                               'catalog_id'=>$catalogParent_id,
                                'brend_id'=>$brend_id,
                                'name' => $product,
                               'image' => $product_image,
                               'translit' => Translite::rusencode($product),
                                'body_uk'=>$product_body_uk,
                                'body_ru'=>$product_body_ru,
                                'new'=>$product_new,
                                'top'=>$product_top,
                                'akciya'=>$product_akciya,
                                'video'=>$product_video,
                           ])->execute();
                           $product_id = Yii::$app->db->lastInsertID;
                        }else{
                            
                            $db ->createCommand()
                            ->update('products', [ 
                               'catalog_id'=>$catalogParent_id,
                                'name' => $product,
                               'image' => $product_image,
                               'translit' => Translite::rusencode($product),
                                'body_uk'=>$product_body_uk,
                                'body_ru'=>$product_body_ru,
                                'new'=>$product_new,
                                'top'=>$product_top,
                                'akciya'=>$product_akciya,
                                'video'=>$product_video,
                                ], 'id = '.$modelProducts->id)
                            ->execute();
                            $product_id = $modelProducts->id;
                           
                        }
			if(is_file($dir . 'upload/mod/'.$product_image)){
                        $resizeObj = new resize($dir . 'upload/mod/'.$product_image);
			$resizeObj -> resizeImage(135, 200, 'auto');
                        $resizeObj -> saveImage($dir . 'upload/products/ico/'.$product_image, 100);
			$resizeObj -> resizeImage(370, 370, 'auto');
                        $resizeObj -> saveImage($dir . 'upload/products/big/'.$product_image, 100);                        
                        
                        }
                        //*********END product*********//                         
                        
                        //*********mods*********// 
                        for($i=18;$i<count($data);$i++){
                            if(!empty($data[$i])){
                            $mod_arr = explode('=',$data[$i]);
                           //print_r($mod_arr);exit;
                            $mod_art = $mod_arr[0];
                            $mod_size = $mod_arr[1];
                            $mod_color = $mod_arr[2];
                            $mod_image = $mod_arr[3];
                            $mod_cost = $produc_cost;
                            $mod_old_cost = $product_cost_old;
                            $fields = [
                                'product_id'=>$product_id,
                                'art'=>$mod_art,
                                'size'=>$mod_size,
                                'color'=>$mod_color,
                                'image'=>$mod_image,
                                'cost'=>$mod_cost,
                                'old_cost'=>$mod_old_cost,
                            ];
                            $modelMod = Mod::find()->where('art=:art',[':art'=>$mod_art])->one();
                            if(empty($modelMod->id)){    
                                $db->createCommand()->insert('mod', $fields)->execute();
                            }else{
                                $db->createCommand()->update('mod', $fields, 'id = '.$modelMod->id)->execute();                                
                            }
                            
			if(is_file($dir . 'upload/mod/'.$mod_image)){
                        $resizeObj = new resize($dir . 'upload/mod/'.$mod_image);
			$resizeObj -> resizeImage(40, 40, 'crop');
                        $resizeObj -> saveImage($dir .  'upload/mod/ico/'.$mod_image, 100);
			$resizeObj -> resizeImage(370, 370, 'auto');
                        $resizeObj -> saveImage($dir . 'upload/mod/big/'.$mod_image, 100);                        
                        
                        }                            
                        }}
                        //*********END mods*********//
                        // 
                        //*********fotos*********// 
                        foreach($fotos as $foto){
                            $fields = [
                                'product_id'=>$product_id,
                                'image'=>$foto,
                            ];                            
                            $modelFotos = Fotos::find()->where('image=:image',[':image'=>$foto])->one(); 
                            if(empty($modelFotos->id)){    
                                $db->createCommand()->insert('products_fotos', $fields)->execute();
                            }else{
                                $db->createCommand()->update('products_fotos', $fields, 'id = '.$modelFotos->id)->execute();                                
                            }
                            if(is_file($dir . 'upload/fotos/'.$foto)){
                            $resizeObj = new resize($dir . 'upload/fotos/'.$foto);
                            $resizeObj -> resizeImage(100, 100, 'crop');
                            $resizeObj -> saveImage($dir . 'upload/fotos/ico/'.$foto, 100);
                            $resizeObj -> resizeImage(400, 400, 'crop');
                            $resizeObj -> saveImage($dir . 'upload/fotos/big/'.$foto, 100);
                            }                            
                        }                        
                        //*********END fotos*********//
                        
                        //*********types*********//
                        ProductsFilters::deleteAll(['product_id' => $product_id]);
                        //print_r( $filters);exit;
                        foreach($filters as $filter){
                            $fields = [
                                'parent_id'=>23,
                                'catalog_id'=>$catalogParent_id,
                                'name'=>$filter,
                            ];
                            
                            $modelFilters = Filters::find()->where('name=:name and catalog_id=:catalog_id',[':name'=>$filter,':catalog_id'=>$catalogParent_id])->one();
                            if(empty($modelFilters->id)){    
                                $db->createCommand()->insert('catalog_filters', $fields)->execute();
                                $filter_id = Yii::$app->db->lastInsertID;
                            }else{
                                $db->createCommand()->update('catalog_filters', $fields, 'id = '.$modelFilters->id)->execute();                                
                                $filter_id = $modelFilters->id;
                                
                            }
                            $db->createCommand()->insert('productsFilters', ['filter_id'=>$filter_id,'product_id'=>$product_id])->execute();
                            
                            
                        }
                        
                        foreach($filters2 as $filter){
                            $fields = [
                                'parent_id'=>27,
                                'catalog_id'=>$catalogParent_id,
                                'name'=>$filter,
                            ];
                            $modelFilters = Filters::find()->where('name=:name and catalog_id=:catalog_id',[':name'=>$filter,':catalog_id'=>$catalogParent_id])->one();
                            if(empty($modelFilters->id)){    
                                $db->createCommand()->insert('catalog_filters', $fields)->execute();
                                $filter_id = Yii::$app->db->lastInsertID;
                            }else{
                                $db->createCommand()->update('catalog_filters', $fields, 'id = '.$modelFilters->id)->execute();                                
                                $filter_id = $modelFilters->id;
                                
                            }
                            $db->createCommand()->insert('productsFilters', ['filter_id'=>$filter_id,'product_id'=>$product_id])->execute();
                            
                            
                        } 
                        
                        foreach($years as $filter){
                            $fields = [
                                'parent_id'=>34,
                                'catalog_id'=>$catalogParent_id,
                                'name'=>$filter,
                            ];
                            $modelFilters = Filters::find()->where('name=:name and catalog_id=:catalog_id',[':name'=>$filter,':catalog_id'=>$catalogParent_id])->one();
                            if(empty($modelFilters->id)){    
                                $db->createCommand()->insert('catalog_filters', $fields)->execute();
                                $filter_id = Yii::$app->db->lastInsertID;
                            }else{
                                $db->createCommand()->update('catalog_filters', $fields, 'id = '.$modelFilters->id)->execute();                                
                                $filter_id = $modelFilters->id;
                                
                            }
                            $db->createCommand()->insert('productsFilters', ['filter_id'=>$filter_id,'product_id'=>$product_id])->execute();
                            
                            
                        } 
                        
                        foreach($sex as $filter){
                            $fields = [
                                'parent_id'=>35,
                                'catalog_id'=>$catalogParent_id,
                                'name'=>$filter,
                            ];
                            $modelFilters = Filters::find()->where('name=:name and catalog_id=:catalog_id',[':name'=>$filter,':catalog_id'=>$catalogParent_id])->one();
                            if(empty($modelFilters->id)){    
                                $db->createCommand()->insert('catalog_filters', $fields)->execute();
                                $filter_id = Yii::$app->db->lastInsertID;
                            }else{
                                $db->createCommand()->update('catalog_filters', $fields, 'id = '.$modelFilters->id)->execute();                                
                                $filter_id = $modelFilters->id;
                                
                            }
                            $db->createCommand()->insert('productsFilters', ['filter_id'=>$filter_id,'product_id'=>$product_id])->execute();
                            
                            
                        }                        
                        //*********END types*********//
                        ProductsParams::deleteAll(['product_id' => $product_id]);
                        foreach($params as $param){
                            if(!empty($param)){
                                $arr = explode('*',$param);
                                $fields = [
                                    'product_id'=>$product_id,
                                    'name'=>$arr[0],
                                    'size'=>$arr[1],
                                    'metka'=>$arr[2],
                                ];
                                $db->createCommand()->insert('products_params', $fields)->execute();
                            }
                        }
                         
                        
               // print"<pre>";print_r($data);	

            }
            fclose($handle);
        }            
            
            
            
            
            
            

            return true;

    }
}