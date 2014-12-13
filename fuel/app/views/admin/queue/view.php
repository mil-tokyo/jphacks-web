<h2>Viewing #<?php echo $queue->id; ?></h2>

<p>
	<strong>User id:</strong>
	<?php echo $queue->user_id; ?></p>
<p>
	<strong>State:</strong>
	<?php echo $queue->state; ?></p>
<p>
	<strong>Started at:</strong>
	<?php echo $queue->started_at; ?></p>

<?php echo Html::anchor('admin/queue/edit/'.$queue->id, 'Edit'); ?> |
<?php echo Html::anchor('admin/queue', 'Back'); ?>