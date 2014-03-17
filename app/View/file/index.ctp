<h2>Upload files</h2>

<?php echo $this->Form->create('File', array('type' => 'file')); ?>

<?php echo $this->Form->input('image', array('type' => 'file')); ?>
<?php echo $this->Form->end('Submit'); ?>