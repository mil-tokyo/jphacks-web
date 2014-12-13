<h2>Editing Structure</h2>
<br>

<?php echo render('admin/structure/_form'); ?>
<p>
	<?php echo Html::anchor('admin/structure/view/'.$structure->id, 'View'); ?> |
	<?php echo Html::anchor('admin/structure', 'Back'); ?></p>
