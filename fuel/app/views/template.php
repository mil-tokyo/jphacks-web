<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Insight</title>
	<?php if (isset($css)): ?>
	<?php echo \Asset::css($css); ?>
	<?php else: ?>
	<?php echo Asset::css('bootstrap.css'); ?>
	<?php endif; ?>
	<style>
		body { margin: 50px; }
	</style>
	<?php echo Asset::js(array(
		'http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js',
//		'bootstrap.js'
	)); ?>
</head>
<body>

	<div class="navbar navbar-inverse navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a href="#"><?php echo \Asset::img('insight_logo.png', array('height'=> '45')); ?></a>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav pull-right">
					<li><a href="#">About Us</a></li>
					<li><a href="#">Tutorial</a></li>
					<li><a href="#">Community</a></li>
					<li><a href="#">Settings</a></li>
					<?php if ($current_user): ?>
					<li class="dropdown">
						<a data-toggle="dropdown" class="dropdown-toggle" href="#"><?php echo $current_user->username ?> <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><?php echo Html::anchor('main/logout', 'Logout') ?></li>
						</ul>
					</li>
					<?php else: ?>
					<li><?php echo \Html::anchor('main/login', 'Log in'); ?></li>
					<?php endif; ?>
				</ul>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-md-12">
<?php if (Session::get_flash('success')): ?>
				<div class="alert alert-success alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<p>
					<?php echo implode('</p><p>', (array) Session::get_flash('success')); ?>
					</p>
				</div>
<?php endif; ?>
<?php if (Session::get_flash('error')): ?>
				<div class="alert alert-danger alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<p>
					<?php echo implode('</p><p>', (array) Session::get_flash('error')); ?>
					</p>
				</div>
<?php endif; ?>
			</div>
			<div class="col-md-12">
<?php echo $content; ?>
			</div>
		</div>
		<hr/>
		<footer>
			<p class="pull-right"></p>
			<p>
				
			</p>
		</footer>
	</div>

	<?php if(isset($js)): ?>
	<?php echo \Asset::js($js); ?>
	<?php endif; ?>

</body>
</html>
