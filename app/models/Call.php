<?php
namespace app\models;

use Yii;
use yii\base\Model;


class Call extends Model
{
    public $name;
    public $phone;
    public $body;
    
    public function rules()
    {
        return [
            [['name', 'phone'], 'required','whenClient' => true],
            //['email', 'email'],
            [['body'], 'safe'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
            'phone'=>'Телефон',
            'body'=>'Сообщение',
        ];
    }
    
    public function contact($email)
    {
        if ($this->validate()) {
                        $body = '';
                        $body .= 'Имя: '.$this->name;
                        $body .= "\n\r";
                        $body .= 'Телефон: '.$this->phone;
                        $body .= "\n\r";
                        $body .= 'Сообщение: '.$this->body;
                        $body .= "\n\r"; 
                        
            Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom(['send@artweb.ua' => 'send'])
                ->setSubject('ОБРАТНЫЙ ЗВОНОК на сайте Бубочка')
                ->setTextBody($body)
                ->send();
            return true;
        } else {
            return false;
        }
    }    
    
} 