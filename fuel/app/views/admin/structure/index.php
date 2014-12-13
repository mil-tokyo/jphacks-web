<h2>Listing Structures</h2>
<br>
<?php if ($structures): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Queue id</th>
			<th>Json</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($structures as $item): ?>		<tr>

			<td><?php echo $item->queue_id; ?></td>
			<td><?php echo $item->json; ?></td>
			<td>
				<?php echo Html::anchor('admin/structure/view/'.$item->id, 'View'); ?> |
				<?php echo Html::anchor('admin/structure/edit/'.$item->id, 'Edit'); ?> |
				<?php echo Html::anchor('admin/structure/delete/'.$item->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Structures.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('admin/structure/create', 'Add new Structure', array('class' => 'btn btn-success')); ?>

</p>
