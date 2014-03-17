<?php 
	// css file
	echo $this->Html->css(array(
		'reset',
		'common',
		'fancybox/jquery.fancybox.css?v=2.1.5'
	));
	// Js file
	echo $this->Html->script(array(
		'jquery-1.9.0.min',
		'main',
		'jquery.fancybox.js?v=2.1.5'
	)); 
?>
<?php echo $content_for_layout ?>
