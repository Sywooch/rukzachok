<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
?>
<?
$this->title = 'Импорт';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1>Импорт</h1>

    <?php $form = ActiveForm::begin([
        'id' => 'form',
        'options' => ['enctype' => 'multipart/form-data'],

    ]); ?>


<?= $form->field($model, 'type')->inline()->radioList(['products.csv' => 'Загразка товаров', 'file_1.csv' => 'Обновление цен'], ['separator' => '', 'tabindex' => 3]); ?>
       
      <?= $form->field($model, 'file')->fileInput() ?>

    


    <?= Html::submitButton('Загрузить', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>



    <?php ActiveForm::end(); ?>

