<?php echo Form::open(array("class"=>"form-horizontal")); ?>

	<fieldset>
		<div class="form-group">
			<?php echo Form::label('User id', 'user_id', array('class'=>'control-label')); ?>

				<?php echo Form::input('user_id', Input::post('user_id', isset($queue) ? $queue->user_id : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'User id')); ?>

		</div>
		<div class="form-group">
			<?php echo Form::label('State', 'state', array('class'=>'control-label')); ?>

				<?php echo Form::input('state', Input::post('state', isset($queue) ? $queue->state : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'State')); ?>

		</div>
		<div class="form-group">
			<?php echo Form::label('Started at', 'started_at', array('class'=>'control-label')); ?>

				<?php echo Form::input('started_at', Input::post('started_at', isset($queue) ? $queue->started_at : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'Started at')); ?>

		</div>
		<div class="form-group">
			<label class='control-label'>&nbsp;</label>
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>		</div>
	</fieldset>
<?php echo Form::close(); ?>