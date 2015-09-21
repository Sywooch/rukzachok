<?php
namespace app\models;

use Yii;

class Order extends \yii\db\ActiveRecord
{
    
    public static function tableName()
    {
        return 'orders';
    }    
    
    public function rules()
    {
        return [
            [['name', 'phone'], 'required','whenClient' => true],
            //['email', 'email'],
            [['total','body','patronymic','surname','email','phone2','delivery','payment'], 'safe'],
            [['email'],'email'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
            'phone'=>'Телефон',
            'phone2'=>'Дополнительный телефон',
            'body'=>'Сообщение',
            'adress'=>'Адрес',
            'city'=>'Город',
            'patronymic'=>'Отчество',
            'surname'=>'Фамилия',
            'email'=>'E-mail',
            'date_time'=>'Дата',
            'total'=>'Сума',
            'status'=>'Статус',
            'delivery'=>'Вариант доставки',
            'payment'=>'Способы оплаты',
        ];
    }
    
	public function beforeSave($insert) {
            $this->user_id = Yii::$app->user->id;
            $this->date_time = new \yii\db\Expression('NOW()');
            return parent::beforeSave($insert);
	}
        
        public function beforeDelete() {
            return parent::beforeDelete();
        }    
    
    public function contact($email,$body)
    {
        if ($this->validate()) {
                        $body .= 'Вся сумма: '.$this->total;
                        $body .= "\n\r";            
                        $body .= 'Имя: '.$this->name;
                        $body .= "\n\r";
                        $body .= 'Фамилия: '.$this->surname;
                        $body .= "\n\r";
                        $body .= 'Отчество: '.$this->patronymic;
                        $body .= "\n\r";
                        $body .= 'E-mail: '.$this->email;
                        $body .= "\n\r";                        
                        $body .= 'Телефон: '.$this->phone;
                        $body .= "\n\r";
                        $body .= 'Адрес: '.$this->adress;
                        $body .= "\n\r";
                        $body .= 'Сообщение: '.$this->body;
                        $body .= "\n\r"; 
                        
            Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom(['send@artweb.ua' => 'send'])
                ->setSubject('Заказ на сайте Рюкзаки')
                ->setTextBody($body)
                ->send();
            return true;
        } else {
            return false;
        }
    }
    
        public function getUser()
        { 
          return $this->hasOne(User::className(), ['id' => 'user_id']);
        }
        public function getProducts()
        {
            return $this->hasMany(OrdersProducts::className(), ['order_id' => 'id']);
        }
}    