<?php

namespace app\modules\admin\models;
use Yii;
use app\components\Translite;
use app\components\resize;
use yii\web\UploadedFile;

class Filters extends \yii\db\ActiveRecord
{
    
    public static function tableName()
    {
        return 'catalog_filters';
    }
	
	public function rules()
	{
		return [
			[['name'], 'required'],
			[['catalog_id','parent_id'], 'safe'],
                        //[['image'], 'file', 'extensions'=>'jpg, gif, png', 'skipOnEmpty'=>true],
                    ];
	}	
	
	public function attributeLabels()
	{
		return [
			'name'=>'Название',
			'cost'=>'Цена',
			'parent_id'=>'Группа',
                        'image'=>'Изображения',
		];
	}
        
	public function beforeSave($insert) {
            if(empty($this->parent_id))$this->parent_id = 0;
            
            return parent::beforeSave($insert);
	}
        
        public function beforeDelete() {
            return parent::beforeDelete();
        }
        
        public function getChilds()
        {
            return $this->hasMany(self::className(), ['parent_id' => 'id']);
        }        
        
       
      
	

}
