<h2>Listing Results</h2>
<br>
<?php if ($results): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Queue id</th>
			<th>Json</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($results as $item): ?>		<tr>

			<td><?php echo $item->queue_id; ?></td>
			<td><?php echo $item->json; ?></td>
			<td>
				<?php echo Html::anchor('admin/result/view/'.$item->id, 'View'); ?> |
				<?php echo Html::anchor('admin/result/edit/'.$item->id, 'Edit'); ?> |
				<?php echo Html::anchor('admin/result/delete/'.$item->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Results.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('admin/result/create', 'Add new Result', array('class' => 'btn btn-success')); ?>

</p>
