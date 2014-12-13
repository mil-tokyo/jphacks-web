<h2>Viewing #<?php echo $result->id; ?></h2>

<p>
	<strong>Queue id:</strong>
	<?php echo $result->queue_id; ?></p>
<p>
	<strong>Json:</strong>
	<?php echo $result->json; ?></p>

<?php echo Html::anchor('admin/result/edit/'.$result->id, 'Edit'); ?> |
<?php echo Html::anchor('admin/result', 'Back'); ?>