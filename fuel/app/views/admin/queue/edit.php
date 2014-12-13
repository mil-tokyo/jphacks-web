<h2>Editing Queue</h2>
<br>

<?php echo render('admin/queue/_form'); ?>
<p>
	<?php echo Html::anchor('admin/queue/view/'.$queue->id, 'View'); ?> |
	<?php echo Html::anchor('admin/queue', 'Back'); ?></p>
