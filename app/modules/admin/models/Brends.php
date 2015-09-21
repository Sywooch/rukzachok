<?php

namespace app\modules\admin\models;
use Yii;
use app\components\Translite;
use app\components\resize;
use yii\web\UploadedFile;

class Brends extends \yii\db\ActiveRecord
{
    public $old_image;
    public static function tableName()
    {
        return 'catalog_brends';
    }
	
	public function rules()
	{
		return [
			[['name'], 'required'],
			[['body','sort','translit','old_image'], 'safe'],
                        [['image'], 'file', 'extensions'=>'jpg, gif, png', 'skipOnEmpty'=>true],
                    ];
	}	
	
	public function attributeLabels()
	{
		return [
			'name'=>'Название',
			'body'=>'Описание',
			'sort'=>'Сорт.',
                        'image'=>'Изображения',
		];
	}
        
	public function beforeSave($insert) {
            
                if (!$this->translit)
			$this->translit = Translite::rusencode($this->name);
                
                
		if($image = UploadedFile::getInstance($this,'image')){			
			
                        $this->deleteImage($this->old_image);
                        //$this->image = $image;
			$this->image = time() . '_' . rand(1, 1000) . '.' . $image->extension;
                        $image->saveAs('upload/brends/'.$this->image);

		}else $this->image = $this->old_image; 
                
                
		return parent::beforeSave($insert);
	}
        
        public function beforeDelete() {
            $this->deleteImage($this->image); 
            return parent::beforeDelete();
        }
        
        public function deleteImage($file){ 
                        if(!empty($file)){
                            @unlink('upload/brends/'.$file);
                        }            
        } 
        
        
        
       
      
	

}
