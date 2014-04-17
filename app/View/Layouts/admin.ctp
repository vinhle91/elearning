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

<body class="page-header-fixed">
	<!--<?php echo $this->element('sql_dump'); ?>-->
		<!--Start header-->
		<div class="header navbar navbar-inverse navbar-fixed-top">
			<?php echo $this->element('admin' .DS . 'layouts' . DS . 'admin_header');?>
		</div>
		<!--End	header-->
		<div class="page-container">
			<!-- Start sidebar -->
			<?php  echo $this->element('admin' .DS . 'layouts' . DS . 'admin_sidebar') ?>
			<!-- End sidebar -->
		</div>
		<!--Start container-->		
		<div class="page-content">
		    <?php echo $content_for_layout ?>
		    
		    <!-- <div class="modal fade" id="portlet-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
							<h4 class="modal-title">Notice!</h4>
						</div>
						<div class="modal-body">
							this function is not supported now.
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div> -->
		</div>
		<!--End	container-->
		<!--Start footer-->
		<?php echo $this->element('admin' .DS . 'layouts' . DS . 'admin_footer');?>
		<!--End	footer-->
	<!--End	body-->
</body>
	<script>
		jQuery(document).ready(function() {       
		   App.init();
		});

		$(document).ready(function(){
			$(".page-sidebar-menu>li").removeClass("active open");
			$(".page-sidebar-menu>li>ul>li").removeClass("active open");
			<?php if (isset($sidebar)) { ?>
				$(".page-sidebar-menu .<?php echo $sidebar[0]?>").addClass("active open");
				<?php if (isset($sidebar[1])) { ?>
				$(".page-sidebar-menu .<?php echo $sidebar[0]?>>ul>li.<?php echo $sidebar[1]?>").addClass("active");
				<?php } ?>
			<?php } ?>
		});
			
		
	</script>
</html>

