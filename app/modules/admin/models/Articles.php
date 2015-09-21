<?php

namespace app\modules\admin\models;
use app\components\Translite;
use app\components\resize;
use yii\web\UploadedFile;

class Articles extends \yii\db\ActiveRecord
{
	public $old_image;
        
	public static function tableName()
    {
        return 'articles';
    }
	
	public function rules()
	{
		return [
			[['title'], 'required'],
			[['old_image','date','body','translit','meta_title','meta_keywords','meta_description'], 'safe'],
                        [['image'], 'file', 'extensions'=>'jpg, gif, png', 'skipOnEmpty'=>true],

                    ];
	}	
	
	public function attributeLabels()
	{
		return [
			'title'=>'Название',
			'body'=>'Описание',
			'date'=>'Дата',
                        'image'=>'Изображения',
		];
	}
        
	public function beforeSave($insert) {
		if (!$this->translit)
			$this->translit = Translite::rusencode($this->title);
                
                
		if($image = UploadedFile::getInstance($this,'image')){			

                        $this->deleteImage($this->old_image);
                        //$this->image = $image;
			$this->image = time() . '_' . rand(1, 1000) . '.' . $image->extension;
                        $image->saveAs('upload/articles/'.$this->image);
			
			$resizeObj = new resize('upload/articles/'.$this->image);
			$resizeObj -> resizeImage(100, 100, 'crop');
                        $resizeObj -> saveImage('upload/articles/ico/'.$this->image, 100);
			$resizeObj -> resizeImage(400, 400, 'crop');
                        $resizeObj -> saveImage('upload/articles/big/'.$this->image, 100);                        
		}else $this->image = $this->old_image;                

		return parent::beforeSave($insert);
	}
        
        public function beforeDelete() {
            $this->deleteImage($this->image); 
            return parent::beforeDelete();
        }
        
        public function deleteImage($file){ 
                        if(!empty($file)){
                            @unlink('upload/articles/'.$file);
                            @unlink('upload/articles/ico/'.$file);
                        }            
        }        
	

}

