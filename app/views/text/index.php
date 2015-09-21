<?
use yii\widgets\Breadcrumbs;
?>
<?
$this->title = $text->meta_title;
$this->registerMetaTag(['name' => 'description', 'content' => $text->meta_description]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $text->meta_keywords]);
?>
            <nav class="bread-crumbs">
            <?= Breadcrumbs::widget([
                'links' => [$text->title],
            ]) ?>
                            <div class="both"></div>
            </nav>

<h1><?=$text->title;?></h1>
<div class="content">
<?=$text->body;?>
</div>