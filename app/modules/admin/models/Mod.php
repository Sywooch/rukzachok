<?php

namespace app\modules\admin\models;
use Yii;
use app\components\Translite;
use app\components\resize;
use yii\web\UploadedFile;

class Mod extends \yii\db\ActiveRecord
{
    public $old_image;
    
    public static function tableName()
    {
        return 'mod';
    }
	
	public function rules()
	{
		return [
			[['art'], 'required'],
			[['product_id','cost','old_cost','active','name'], 'safe'],
			[['old_image'], 'safe'],
                        [['image'], 'file', 'extensions'=>'jpg, gif, png', 'skipOnEmpty'=>true],
                    ];
	}	
	
	public function attributeLabels()
	{
		return [
			'art'=>'Артикуль',
                        'name'=>'Название',
			'cost'=>'Цена',
                        'old_cost'=>'Старая цена',
			'sort'=>'Сорт.',
                        'image'=>'Изображения',
            'active'=>'Наличие',
		];
	}
        
	public function beforeSave($insert) {
            
		if($image = UploadedFile::getInstance($this,'image')){			

                        $this->deleteImage($this->old_image);
                        //$this->image = $image;
			$this->image = time() . '_' . rand(1, 1000) . '.' . $image->extension;
                        $image->saveAs('upload/mod/'.$this->image);
			
			$resizeObj = new resize('upload/mod/'.$this->image);
			$resizeObj -> resizeImage(40, 40, 'crop');
                        $resizeObj -> saveImage('upload/mod/ico/'.$this->image, 100);
			//$resizeObj -> resizeImage(400, 400, 'crop');
                        //$resizeObj -> saveImage('upload/news/big/'.$this->image, 100);                        
		}else $this->image = $this->old_image;             
            
		return parent::beforeSave($insert);
	}
        
        public function beforeDelete() {
            $this->deleteImage($this->image); 
            return parent::beforeDelete();
        }
        
        public function deleteImage($file){ 
                        if(!empty($file)){
                            @unlink('upload/mod/'.$file);
                            @unlink('upload/mod/ico/'.$file);
                            //@unlink('upload/news/big/'.$file);
                        }            
        }  
        
        public function getProduct(){
            return $this->hasOne(Products::className(), ['id' => 'product_id']);
        }
                
        
        
        
       
      
	

}
