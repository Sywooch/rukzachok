<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

use app\modules\admin\models\UserGroup;
?>

    <?php $form = ActiveForm::begin([
        'id' => 'form',
        'options' => ['class' => 'form-vertical'],

    ]); ?>

    <?= $form->field($model, 'username') ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

	<?= $form->field($model, 'password_repeat')->passwordInput(['value'=>$model->password]) ?>

    <?=$form->field($model, 'group_id')
     ->dropDownList(
            ArrayHelper::map(UserGroup::find()->all(), 'id', 'name'), ['prompt'=>'-без группы-']
            )?>    


    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>



    <?php ActiveForm::end(); ?>

