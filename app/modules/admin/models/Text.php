<?php

namespace app\modules\admin\models;
use app\components\Translite;

class Text extends \yii\db\ActiveRecord
{
	
	public static function tableName()
    {
        return 'text';
    }
	
	public function rules()
	{
		return [
			[['title'], 'required'],
			[['body','translit','meta_title','meta_keywords','meta_description'], 'safe'],
		];
	}	
	
	public function attributeLabels()
	{
		return [
			'title'=>'Название',
			'body'=>'Описание',
			'sort'=>'Сорт.',
		];
	}
        
	public function beforeSave($insert) {
		if (!$this->translit)
			$this->translit = Translite::rusencode($this->title);

		return parent::beforeSave($insert);
	}        
	

}

