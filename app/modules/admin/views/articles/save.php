<?
$this->title = 'Добавить статью';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1>Добавить статью</h1>
<?= $this->render('_form',['model'=>$model]) ?>