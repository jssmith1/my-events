<?php echo Form::open(array("class"=>"form-horizontal")); ?>

	<fieldset>
		<div class="control-group">
			<?php echo Form::label('First', 'first', array('class'=>'control-label')); ?>

			<div class="controls">
				<?php echo Form::input('first', Input::post('first', isset($employee) ? $employee->first : ''), array('class' => 'span4', 'placeholder'=>'First')); ?>

			</div>
		</div>
		<div class="control-group">
			<?php echo Form::label('Last', 'last', array('class'=>'control-label')); ?>

			<div class="controls">
				<?php echo Form::input('last', Input::post('last', isset($employee) ? $employee->last : ''), array('class' => 'span4', 'placeholder'=>'Last')); ?>

			</div>
		</div>
		<div class="control-group">
			<label class='control-label'>&nbsp;</label>
			<div class='controls'>
				<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>			</div>
		</div>
	</fieldset>
<?php echo Form::close(); ?>