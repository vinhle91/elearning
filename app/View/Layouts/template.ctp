<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Content-Type"	content="text/html; charset=utf-8" />
	<title><?php echo isset($pageTitle) ? $pageTitle : null; ?></title>
	<?php 
		// css file
		echo $this->Html->css(array(
			'reset',
			'common',
		));

		// Js file
		echo $this->Html->script(array(
			'jquery-1.9.0.min',
			'main',
			'select2/select2',
		)); 
	?>
	<link rel="stylesheet" type="text/css" href="/elearning/js/select2/select2.css">
	<script type="text/javascript"> 
	 	function disableContextMenu()
	   	{
	     	window.frames["fraDisabled"].document.oncontextmenu = function(){alert("No way!"); return false;};   
		}
	</script>
	<style type="text/css"> @media print { body { display:none } } </style>
</head>
<body onload="disableContextMenu()" >
<!-- <?php echo $this->element('sql_dump'); ?>  -->
	<div id="body">
		<!--Start header-->
		<?php echo $this->Element('header');?>
		<!--End	header-->		
		<!--Start container-->		
		<div id="container">
		    <!-- Start wrapper-->		
			<div id="wrapper" class="clearfix">
		    	<?php echo $content_for_layout ?>
			</div>
			<!-- End wrapper-->
		</div>
		<!--End	container-->
		<!--Start footer-->
		<?php echo $this->Element('footer');?>
		<!--End	footer-->
	</div>
	<!--End	body-->
</body>
</html>
