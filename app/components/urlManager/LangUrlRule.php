<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LangUrlManager
 *
 * @author Ekstazi
 * @ver 1.2
 */
namespace app\components\urlManager; 
use yii\rest\UrlRule;
use Yii; 
class LangUrlRule extends UrlRule{
    public $languages=array('en');
	public $lang='ru';
    public $langParam='language';

    /*public function parsePathInfo($pathInfo)
    {
        parent::parsePathInfo($pathInfo);
        
        $userLang=Yii::app()->getRequest()->getPreferredLanguage();
        //if language pass via url use it
        if(isset($_GET[$this->langParam])&&in_array($_GET[$this->langParam],$this->languages)){
            Yii::app()->language=$_GET[$this->langParam];
        //else if preffered language is allowed
        }elseif(in_array($userLang,$this->languages)) {
            Yii::app()->language=$userLang;
        //else use the first language from the list
        }else Yii::app()->language=$this->lang;

    }*/
    //put your code here
	
	public function init(){
	print '==';
	print Yii::$app->getRequest()->getQueryParam('language');
	return parent::init();
	}
    public function createUrl($params=array()){
        $userLang=Yii::$app->getRequest()->getPreferredLanguage();
        //if language pass via url use it
        if(isset($_GET[$this->langParam])&&in_array($_GET[$this->langParam],$this->languages)){
            Yii::$app->language=$_GET[$this->langParam];
        //else if preffered language is allowed
        }elseif(in_array($userLang,$this->languages)) {
            Yii::$app->language=$userLang;
        //else use the first language from the list
        }else Yii::$app->language=$this->lang;
		
	//print_r($_GET);
        if(!isset($params[$this->langParam])){ if(Yii::$app->language != $this->lang)$params[$this->langParam]=Yii::$app->language;}
		else if($params[$this->langParam] == $this->lang)unset($params[$this->langParam]);
		//print_r($params);
        return parent::createUrl($params);
    }
    //put your code here
}