<h2>Viewing #<?php echo $structure->id; ?></h2>

<p>
	<strong>Queue id:</strong>
	<?php echo $structure->queue_id; ?></p>
<p>
	<strong>Json:</strong>
	<?php echo $structure->json; ?></p>

<?php echo Html::anchor('admin/structure/edit/'.$structure->id, 'Edit'); ?> |
<?php echo Html::anchor('admin/structure', 'Back'); ?>