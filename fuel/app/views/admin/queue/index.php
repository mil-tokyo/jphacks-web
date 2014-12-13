<h2>Listing Queues</h2>
<br>
<?php if ($queues): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>User id</th>
			<th>State</th>
			<th>Started at</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($queues as $item): ?>		<tr>

			<td><?php echo $item->user_id; ?></td>
			<td><?php echo $item->state; ?></td>
			<td><?php echo $item->started_at; ?></td>
			<td>
				<?php echo Html::anchor('admin/queue/view/'.$item->id, 'View'); ?> |
				<?php echo Html::anchor('admin/queue/edit/'.$item->id, 'Edit'); ?> |
				<?php echo Html::anchor('admin/queue/delete/'.$item->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Queues.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('admin/queue/create', 'Add new Queue', array('class' => 'btn btn-success')); ?>

</p>
