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
	)); 
?>
<?php echo $content_for_layout ?>
