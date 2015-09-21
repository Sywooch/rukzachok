<?php

class viewLangUrl extends CWidget
{
    public function run()
    {	
		$url = str_replace(Yii::app()->request->baseUrl,'', Yii::app()->request->requestUri);
		
		$languages = array();
		foreach(Yii::app()->urlManager->languages as $lang){
			$languages[] = '/'.$lang;
		}
		$url = str_replace($languages,'', $url);
		
		$url_arr = explode('?',$url);

		echo CHtml::link('<span class="ru">по-русски</span>',Yii::app()->request->baseUrl . $url,array(
                    'class'=>((Yii::app()->language=='ru') ? 'action':''),
                ));
        echo CHtml::link('<span class="ua">украiнською</span>',Yii::app()->request->baseUrl .'/uk'. $url,array(
                    'class'=>((Yii::app()->language=='uk') ? 'action':''),
                ));
    }
}