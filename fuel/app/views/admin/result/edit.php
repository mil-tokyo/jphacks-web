<h2>Editing Result</h2>
<br>

<?php echo render('admin/result/_form'); ?>
<p>
	<?php echo Html::anchor('admin/result/view/'.$result->id, 'View'); ?> |
	<?php echo Html::anchor('admin/result', 'Back'); ?></p>
