<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type"	content="text/html; charset=utf-8" />
	<title><?php echo isset($pageTitle) ? $pageTitle : null; ?></title>
	<link rel="shortcut icon" href="<?php echo $this->Html->url('/img/no-avatar.jpg') ?>" type="image/x-icon">
	<?php 
		// css file
		echo $this->Html->css(array(
			'font-awesome.min',
			'bootstrap/bootstrap',
			'uniform.default',

			'style-conquer',
			'style-default',
			'style-responsive',
			'default-theme',
			'app',
		));
		// Js file
		echo $this->Html->script(array(
			'jquery-1.9.0.min',
			'jquery-migrate-1.2.1.min',
			'bootstrap',
			'jquery.blockui.min',
			'jquery.cookie.min',
			'admin-layout',
			'jquery-ui.min.js',
			'jquery.metadata',
			'jquery.tablesorter',
			'jquery.tablesorter.min',
			'jquery.slimscroll.min'
		)); 
	?>
</head>

<body class="login" style="">
	<div id="StayFocusd-infobar" style="display:none;">
    <span id="StayFocusd-infobar-msg"></span>
    <span id="StayFocusd-infobar-links">
        <a href="#" id="StayFocusd-infobar-never-show">hide forever</a>&nbsp;&nbsp;|&nbsp;&nbsp;
        <a href="#" id="StayFocusd-infobar-hide">hide once</a>
    </span>
	</div>

	<div class="content">
		<!-- BEGIN LOGIN FORM -->
			<h3 class="form-title">Login to your account</h3>
			<div class="alert alert-error display-hide">
				<button class="close" data-close="alert"></button>
				<span>
					 Enter any username and password.
				</span>
			</div>
            <?php echo $this->Form->create('User'); ?>
			<div class="form-group">
				<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
				<label class="control-label visible-ie8 visible-ie9">Username</label>
				<div class="input-icon">
					<i class="fa fa-user"></i>
                    <?php echo $this->Form->input('Username', array('class'=>'form-control placeholder-no-fix','type'=>'text','label'=>false, 'placeholder' => 'Username'));?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label visible-ie8 visible-ie9">Password</label>
				<div class="input-icon">
					<i class="fa fa-lock"></i>
                    <?php echo $this->Form->input('Password', array('class'=>'form-control placeholder-no-fix','type'=>'password','label'=>false, 'placeholder' => 'Password'));?>
				</div>
			</div>
			<div class="form-actions">
				<button type="submit" class="btn btn-info pull-right">Login </button>
			</div>
            <?php echo $this->Form->end(); ?>
            <?php 
                $error = $this->Session->flash();
                if(!empty($error)):
            ?>
            <div class="error">
                <?php echo $error; ?>
            </div>
            	<?php endif;?>
	</div>

	<script>
		jQuery(document).ready(function() {       
		   App.init();
		});
	</script>
</body></html>