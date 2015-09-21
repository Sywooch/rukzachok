<?php

namespace app\modules\admin\models;


class Menu extends \yii\db\ActiveRecord
{
	
	public static function tableName()
    {
        return 'menu';
    }
	
	public function rules()
	{
		return [
			[['url', 'name'], 'required'],
			[['sort'], 'safe'],
		];
	}	
	
	public function attributeLabels()
	{
		return [
			'url'=>'Url',
			'name'=>'Название',
			'sort'=>'Сорт.',
		];
	}
	

}
