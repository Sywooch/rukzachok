<?php

namespace app\modules\admin\models;
use Yii;
use app\components\Translite;
use app\components\resize;
use yii\web\UploadedFile;

class Fasovka extends \yii\db\ActiveRecord
{
    
    public static function tableName()
    {
        return 'catalog_fasovka';
    }
	
	public function rules()
	{
		return [
			[['name'], 'required'],
			[['catalog_id'], 'safe'],
                        //[['image'], 'file', 'extensions'=>'jpg, gif, png', 'skipOnEmpty'=>true],
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
		return parent::beforeSave($insert);
	}
        
        public function beforeDelete() {
            return parent::beforeDelete();
        }
        
        
        
       
      
	

}
