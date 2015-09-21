<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use app\modules\admin\models\Products;

class Export extends Model
{
    
    
    public function saveCsv($fname){
        $handle = fopen($fname, "w");
        $products = Products::find()->select(['products.*','c.name as catalog','c.image as catalog_image','b.name as brend_name']);
        $products->leftJoin('catalog c', 'c.id = products.catalog_id');
        $products->leftJoin('catalog_brends b', 'b.id = products.brend_id');

        
        //print_R($products);exit;
        foreach ($products->all() as $product){
            
            $mods = [];
            foreach($product->mods as $m){
               $mods[] = $m->art.'='.$m->size.'='.$m->color.'='.$m->image;
            }
            
            $fotos = [];
            foreach($product->fotos as $f){
               $fotos[] = $f->image; 
            }
            
            $filters = [];
            foreach($product->filters as $f){
                $filters[$f->parent_id][] = $f->name;
            } 
            

            
            $list = [
                     $product->catalog,
                     $product->brend_name,
                     $product->name,
                ((!empty($product->body_uk))?$product->body_uk:''),
                ((!empty($product->body_ru))?$product->body_ru:''),
                    ((!empty($filters[23]))?implode(',',$filters[23]):''),
                     ((!empty($filters[27]))?implode(',',$filters[27]):''),
                ((!empty($filters[35]))?implode(',',$filters[35]):''),
                    ((!empty($filters[34]))?implode(',',$filters[34]):''),

                     $product->old_cost,
                     $product->cost1,
                     $product->akciya,
                    '',
                     $product->new,
                     $product->top,
                    $product->params,
                    $product->video,
                    implode(',',$fotos),
                    ];
            //print_r($list);
            fputcsv($handle,array_merge ($list, $mods),';');
        }
        fclose($handle);
    }
    
}