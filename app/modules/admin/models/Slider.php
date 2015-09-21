<?php

namespace app\modules\admin\models;
use app\components\Translite;
use app\components\resize;
use yii\web\UploadedFile;

class Slider extends \yii\db\ActiveRecord
{
	public $old_image;
        
	public static function tableName()
    {
        return 'slider';
    }
	
	public function rules()
	{
		return [
			[['title'], 'required'],
			[['old_image','url','sort','type'], 'safe'],
                        [['image'], 'file', 'extensions'=>'jpg, gif, png', 'skipOnEmpty'=>true],

                    ];
	}	
	
	public function attributeLabels()
	{
		return [
			'title'=>'Название',
			'body'=>'Описание',
                        'sort'=>'Сорт.',
			'date'=>'Дата',
                        'image'=>'Изображения',
		];
	}
        
	public function beforeSave($insert) {
                
                
		if($image = UploadedFile::getInstance($this,'image')){			

                        $this->deleteImage($this->old_image);
                        //$this->image = $image;
			$this->image = time() . '_' . rand(1, 1000) . '.' . $image->extension;
                        $image->saveAs('upload/slider/'.$this->image);
			
		}else $this->image = $this->old_image;                

		return parent::beforeSave($insert);
	}
        
        public function beforeDelete() {
            $this->deleteImage($this->image); 
            return parent::beforeDelete();
        }
        
        public function deleteImage($file){ 
                        if(!empty($file)){
                            @unlink('upload/slider/'.$file);
                        }            
        }        
	

}

