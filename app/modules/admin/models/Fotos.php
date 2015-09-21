<?php

namespace app\modules\admin\models;
use Yii;
use app\components\Translite;
use app\components\resize;
use yii\web\UploadedFile;

class Fotos extends \yii\db\ActiveRecord
{
    public $old_image;
    
    public static function tableName()
    {
        return 'products_fotos';
    }
	
	public function rules()
	{
		return [
			[['name'], 'required'],
			[['product_id','old_image'], 'safe'],
                        [['image'], 'file', 'extensions'=>'jpg, gif, png', 'skipOnEmpty'=>true],
                    ];
	}	
	
	public function attributeLabels()
	{
		return [
			'name'=>'Название',
			'cost'=>'Цена',
			'sort'=>'Сорт.',
                        'image'=>'Изображения',
		];
	}
        
	public function beforeSave($insert) {
		if($image = UploadedFile::getInstance($this,'image')){			
			
                        $this->deleteImage($this->old_image);
                        //$this->image = $image;
			$this->image = time() . '_' . rand(1, 1000) . '.' . $image->extension;
                        $image->saveAs('upload/fotos/'.$this->image);
			
			$resizeObj = new resize('upload/fotos/'.$this->image);
			$resizeObj -> resizeImage(100, 100, 'crop');
                        $resizeObj -> saveImage('upload/fotos/ico/'.$this->image, 100);
			$resizeObj -> resizeImage(400, 400, 'crop');
                        $resizeObj -> saveImage('upload/fotos/big/'.$this->image, 100);
                    }else $this->image = $this->old_image;
                
		return parent::beforeSave($insert);
	}
        
        public function beforeDelete() {
            $this->deleteImage($this->image); 
            return parent::beforeDelete();
        }
        
        public function deleteImage($file){ 
                        if(!empty($file)){
                            @unlink('upload/fotos/'.$file);
                            @unlink('upload/fotos/ico/'.$file);
                            @unlink('upload/fotos/big/'.$file);
                        }            
        }
        
        
        
       
      
	

}
