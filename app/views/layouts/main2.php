<?php $this->beginContent('@app/views/layouts/layout.php'); ?>

<!---slider top-->
<div class="slider">
	<img src="img/slider.jpg" width="960" height="360" border="0" />
</div>
<div class="ten"></div>
<!---end slider-->


<div class="content">
<?= $content ?>
</div>


<?php $this->endContent(); ?>
