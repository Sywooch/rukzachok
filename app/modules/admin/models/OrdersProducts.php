<?php

namespace app\modules\admin\models;
use Yii;

class OrdersProducts extends \yii\db\ActiveRecord
{
    
    public static function tableName()
    {
        return 'orders_products';
    }
    
	public function rules()
	{
		return [
			[['art','count','order_id'], 'required'],
                    ];
	}    
    
	public function attributeLabels()
	{
		return [
			'product_name'=>'Продукт',
			'name'=>'Вид',
                        'art'=>'Артикул',
                        'cost'=>'Цена за один',
			'count'=>'Кол.',
                        'sum_cost'=>'Сумма',
		];
	}    
}    