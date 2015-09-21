<?php

class getLangUrl extends CWidget
{   public $lang = 'ru';
    public function run()
    {	
		$url = str_replace(Yii::app()->request->baseUrl,'', Yii::app()->request->requestUri);
		
		$languages = array();
		foreach(Yii::app()->urlManager->languages as $lang){
			$languages[] = '/'.$lang;
		}
		$url = str_replace($languages,'', $url);
		
		$url_arr = explode('?',$url);


				echo Yii::app()->request->baseUrl .'/'.$this->lang. $url;
    }
}