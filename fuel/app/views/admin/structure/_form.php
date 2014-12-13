<?php echo Form::open(array("class"=>"form-horizontal")); ?>

	<fieldset>
		<div class="form-group">
			<?php echo Form::label('Queue id', 'queue_id', array('class'=>'control-label')); ?>

				<?php echo Form::input('queue_id', Input::post('queue_id', isset($structure) ? $structure->queue_id : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'Queue id')); ?>

		</div>
		<div class="form-group">
			<?php echo Form::label('Json', 'json', array('class'=>'control-label')); ?>

				<?php echo Form::textarea('json', Input::post('json', isset($structure) ? $structure->json : ''), array('class' => 'col-md-8 form-control', 'rows' => 8, 'placeholder'=>'Json')); ?>

		</div>
		<div class="form-group">
			<label class='control-label'>&nbsp;</label>
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>		</div>
	</fieldset>
<?php echo Form::close(); ?>