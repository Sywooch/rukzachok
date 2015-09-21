<?php
//error_reporting (0);
set_time_limit(0);
//print dirname ( __FILE__ )."/mysql.class.php";
@include_once(dirname ( __FILE__ )."/mysql.class.php");
define ("DBHOST", "localhost");
define ("DBNAME", "rukzachok");
define ("DBUSER", "rukzachok");
define ("DBPASS", "3Y8j3Y9r");
$db = new db;
@$db->query("UPDATE `mod` SET `active`=1");
/*
if(is_file(dirname( __FILE__ )."/../upload/oldfile_1.csv")){

    $db->query('update catalogs_config set value=value+1 where id=5');
    $status = @$db->super_query('select value from catalogs_config where id=6',$db);

    if($status[0]['value'] ==1){
        exit;
    } else {
        $db->query('update catalogs_config set value=1 where id=6');
        sleep(300);
    }
    $d1 = @$db->super_query('select value from catalogs_config where id=5',$db);
    $num = $d1[0]['value'];

} else{
    exit;
}
*/
$num = 1;
$_SERVER['DOCUMENT_ROOT'] = realpath(dirname(__FILE__));
$tmpfname = $_SERVER['DOCUMENT_ROOT'] . "/../upload/file_1_duble.csv";
$handle24 = fopen($tmpfname, "w");


//unlink($_SERVER['DOCUMENT_ROOT'] . "/tmp/noDB_mod.csv");

//$link = mysql_connect(DBHOST,DBNAME,DBPASS);
//if(@$link) echo "ok";
//else echo "not";


//$fg = @fopen(dirname( __FILE__ )."/cron/oldfile_1.csv","r");
//if(!@$fg) exit;
//@fclose($fg);
//exit;

$rrrrrrrrrrrr = array();

$last_pid = "";

$ma = array();


$su = 0;
$su2 = 0;

$yy = @fopen(dirname ( __FILE__ )."/counter.txt","r+");
$su = trim(fread($yy,128));
fclose($yy);







$fg = fopen(dirname( __FILE__ )."/../upload/file_1.csv","r");
if(@$fg){
    $cot = "";
    while(!feof($fg))
        $cot = $cot.fread($fg,512);
    @fclose($fg);
}
$cot = explode("\n",$cot);

//print_r($cot);
if(trim($su)<=0 && count($cot)>2){
    $fg = @fopen(dirname ( __FILE__ )."/../upload/noDB_mod.csv","w+");
    fclose($fg);
}

for($i=$su;$i<count($cot)-1;$i++){



    $get_out = 0;

    print $cot[$i]."++++<br />";
    $line = explode(";",$cot[$i]);

print_r($line);
    if(trim($line[3])>0){
//$db->query("UPDATE `catalogs_modifications` SET `active` = '1' WHERE `code` = '".trim($line[0])."';");
    }


///////////////////////////////////////////// ����� ������. ���� ���, �� ������� ���.
    $row_city = @$db->super_query("SELECT * FROM `catalogs_cities` WHERE `name`='".trim($line[4])."' LIMIT 1;");
    if(!@$row_city['id']){
        @$db->query("INSERT INTO `catalogs_cities` (`name`) VALUES ('".trim($line[4])."');");
        $row_city['id'] = $db->insert_id();
    }
    echo "�����:".$row_city['id']."<br/>";


///////////////////////////////////////////// �������� �������� � �������
    $protect = @$db->super_query("SELECT * FROM catalogs_keys_products_cities WHERE mod_code='".trim($line[0])."' LIMIT 1;");
    $pr = @$db->super_query("SELECT * FROM `mod` WHERE `art` = '".trim($line[0])."' LIMIT 1;");


///////////////////////////////////////////// �������� ���-�� � �������
    /*
    if($last_pid!=trim($pr['product_id'])){
    $last_pid = trim($pr['product_id']);
    if(trim($pr['product_id'])!='')
    $db->query("DELETE FROM `catalogs_keys_products_cities` WHERE `product_id` = '".trim($pr['product_id'])."';");
    }
    */

    if($last_pid!=trim($line[0])){
        $last_pid = trim($line[0]);
		if(trim($line[0])!='')$db->query("DELETE FROM `catalogs_keys_products_cities` WHERE `mod_code` = '".trim($line[0])."';");
    }



/////////////////////////////////////////////


    if(!@$protect['product_id'] && @$pr['product_id']){
        @$db->query("INSERT INTO `catalogs_keys_products_cities` (`product_id`,`mod_code`,`count`,`mktime`,`city_id`) VALUES ('".@$pr['product_id']."','".trim($line[0])."','".trim($line[3])."','".time()."','".$row_city['id']."');");
    }
    echo "������� ID:".$pr['product_id']."<br/>";
/////////////////////////////////////////////

///////////////////////////////////////////// �������� ������ �� ������������� � ���������� � ������.
    $no_DB = 0;
    /*
    $product = $db->super_query("SELECT f1.product_id as in_city, f2.product_id as in_modification, f2.product_id as in_modification FROM catalogs_keys_products_cities f1 LEFT JOIN catalogs_modifications f2 ON f2.code='".trim($line[0])."' WHERE f1.mod_code='".trim($line[0])."' AND f1.city_id='".$row_city['id']."' LIMIT 1;");
    */

    $product = $db->super_query("SELECT product_id AS in_modification
FROM  `mod` 
WHERE  `art` = '".trim($line[0])."' LIMIT 1");
print "SELECT product_id AS in_modification
FROM  `mod` 
WHERE  `art` = '".trim($line[0])."' LIMIT 1";
print_r($product);print"<br>";
print "SELECT f1.product_id FROM catalogs_keys_products_cities f1 WHERE f1.product_id='".@$product['in_modification']."' and f1.mod_code='".trim($line[0])."' AND f1.city_id='".$row_city['id']."' LIMIT 1;";
    $catalogs_keys_products_cities = $db->super_query("SELECT f1.product_id FROM catalogs_keys_products_cities f1 WHERE f1.product_id='".@$product['in_modification']."' and f1.mod_code='".trim($line[0])."' AND f1.city_id='".$row_city['id']."' LIMIT 1;");
    if(!@$catalogs_keys_products_cities['product_id']){print'not city v keys<br/>';
        $db->query("INSERT INTO `catalogs_keys_products_cities` (`product_id`,`mod_code`,`count`,`mktime`,`city_id`) VALUES ('".@$pr['product_id']."','".trim($line[0])."','".trim($line[3])."','".time()."','".$row_city['id']."');");
        print "INSERT INTO `catalogs_keys_products_cities` (`product_id`,`mod_code`,`count`,`mktime`,`city_id`) VALUES ('".@$pr['product_id']."','".trim($line[0])."','".trim($line[3])."','".time()."','".$row_city['id']."');<br>";
    }









//$product = $db->super_query("SELECT f2.product_id as in_modification, f2.product_id as in_modification FROM catalogs_modifications f2 //WHERE f2.code='".trim($line[0])."' LIMIT 1;");


    echo "��� 3:".$product['in_modification']."<br/>";

//if(@$product['in_modification'] && !@$product['in_city'] && trim($line[3])>0){
////////$db->query("INSERT INTO `catalogs_keys_products_cities` (`product_id`,`mod_code`,`count`,`mktime`,`city_id`) VALUES ///////('".@$product['in_modification']."','".trim($line[0])."','".trim($line[3])."','".time()."','".$row_city['id']."');");
//}else
    if(@$product['in_modification']){
        $db->query("UPDATE `catalogs_keys_products_cities` SET `count`='".trim($line[3])."' WHERE `product_id`='".@$product['in_modification']."' AND `mod_code`='".trim($line[0])."' AND `city_id`=".trim($row_city['id']).";");
        print "UPDATE `catalogs_keys_products_cities` SET `count`='".trim($line[3])."' WHERE `product_id`='".@$product['in_modification']."' AND `mod_code`='".trim($line[0])."' AND `city_id`=".trim($row_city['id']).";<br>";
    }elseif(!@$product['in_modification']) $no_DB = 1;
/////////////////////////////////////////////
///////////////////////////////////////////// ������ � �������������
    if(@$product['in_modification'] && trim($line[0])!='')
        $row2 = $db->super_query("SELECT COUNT(*) as count FROM `catalogs_keys_products_cities` WHERE `count`>0 AND `product_id`='".@$product['in_modification']."' AND `mod_code` = '".trim($line[0])."';");

    echo "��� 4:".$row2['count']."<br/>";

    if(trim($line[2])>0){$cine = trim($line[2]);$cine_last = trim($line[1]);$sale[] = 1;}
    else{$cine = trim($line[1]);$cine_last = 0;$sale[] = 0;}


 //   if(trim($line[3])<=0 && trim($line[0])!='' && $row2['count']<=0){
 //       $db->query("UPDATE `mod` SET `active` = '1', `cost`=".$cine.", `old_cost`=".$cine_last." WHERE `art` = '".trim($line[0])."';");
 //   }else if(trim($line[3])>0) {$db->query("UPDATE `mod` SET `active` = '0',`cost`=".$cine.", `old_cost`=".$cine_last." WHERE `art` = '".trim($line[0])."';");}


    if($row2['count']>0)$db->query("UPDATE `mod` SET `active` = '0',`cost`=".$cine.", `old_cost`=".$cine_last." WHERE `art` = '".trim($line[0])."';");
    else $db->query("UPDATE `mod` SET `active` = '1',`cost`=".$cine.", `old_cost`=".$cine_last." WHERE `art` = '".trim($line[0])."';");



print "select COUNT(*) as count from mod where  product_id='".$product['in_modification']."' and old_cost>0 GROUP BY cost";
    $p = $db->super_query("select COUNT(*) as count from `mod` where `active`=0 and  product_id='".$product['in_modification']."' and old_cost>0 GROUP BY cost");
    $p2 = $db->super_query("select COUNT(*) as count from `mod` where `active`=0 and product_id='".$product['in_modification']."'");

    print "<b>".$p['count'].'</b>';
    $sale = ($p['count']>0 && $p['count']<$p2['count']) ? 1 : 0;
    $res1 = $db->query("UPDATE `products` SET `sale`='".$sale."' WHERE `id`=".trim(@$product['in_modification'])." LIMIT 1;");
/////////////////////////////////////////////
///////////////////////////////////////////// ��������� � ���������� �������� � ������� ��� �����������.
    if(@$product['in_modification']){
        $row2 = $db->super_query("SELECT COUNT(*) as count FROM `mod` WHERE `active`=0 and `product_id`=".@$product['in_modification'].";");
        if(trim($row2['count']) <= 0)
            $db->query("UPDATE `products` SET `count_modifications` = 0 WHERE `id` = '".@$product['in_modification']."';");
//else $db->query("UPDATE `catalogs_products` SET `count_modifications` = '".trim($row2['count'])."',`active` = '1' WHERE `id` = '".@$product['in_modification']."';");
        else $db->query("UPDATE `products` SET `count_modifications` = '".trim($row2['count'])."' WHERE `id` = '".@$product['in_modification']."';");

    }
/////////////////////////////////////////////
///////////////////////////////////////////// ���������� ����.
    $row_6 = $db->super_query("SELECT COUNT(*) as count FROM `mod` WHERE `active`=0 and `product_id`='".@$product['in_modification']."'");
    $row_7 = $db->super_query("SELECT COUNT(*) as count FROM `mod` WHERE `active`=0 and `product_id`='".@$product['in_modification']."' Group by cost");
    print'('.$row_7['count'].')';
    if($row_7['count']==$row_6['count']){

    }else{
        $row_8 = $db->super_query("SELECT cost,old_cost FROM `mod` WHERE `active`=0 and old_cost>0 AND `product_id`='".@$product['in_modification']."' Order by cost desc");
        $line[1] = 0;//$row_8['cine_last'];
        $line[2] = $cine;
        print'['.$line[2].']';
    }

    if(trim($line[3])>0){
        if(trim($line[2])!="0.00" && @$product['in_modification'] && trim($line[1]) != "" && trim($line[2])!=''){
            $res = $db->query("UPDATE `products` SET `old_cost`=".trim($line[1]).", `cost1`=".trim($line[2])." WHERE `id`=".trim(@$product['in_modification'])." LIMIT 1;");

        }
        elseif(trim($line[1]) != "" && @$product['in_modification']) $res = $db->query("UPDATE `products` SET `old_cost`='0' ,`cost1`=".trim($line[1])." WHERE `id`=".trim(@$product['in_modification'])." LIMIT 1;");
        if(@$res) echo "������ �� ���������� ��� ��������. ���: ".@$product['in_modification']."<br/>";
    }else echo "�� ����������, ����������� �����: ".@$product['in_modification']."<br/>";
/////////////////////////////////////////////
    fwrite($handle24,$cot[$i]."\r\n");
    $product = array();
    if($no_DB == 1){



        if(!@$ma[trim($line[0])]){
            $ma[trim($line[0])]="1";
            $fg2 = @fopen(dirname ( __FILE__ )."/../upload/noDB_mod.csv","a");
            fputs($fg2,implode(";",$line));
            fclose($fg2);
        }
    }

//if($su2>=1000) exit;

    $yy = @fopen(dirname ( __FILE__ )."/counter.txt","w+");
    fputs($yy,$su);
    fclose($yy);
    $su++;
    $su2++;
}


$yy = @fopen(dirname ( __FILE__ )."/counter.txt","w+");
fputs($yy,"0");
fclose($yy);

if($su==(count($cot)-1)){
   // @unlink(dirname( __FILE__ )."/../upload/file_1.csv");
    print "delete file";
}





fclose($handle24);
$db->query('update catalogs_config set value=0 where id=6');

?>