<?
$this->title = 'Добавить меню';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1>Добавить меню</h1>
<?= $this->render('_form',['model'=>$model]) ?>