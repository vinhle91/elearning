<?php 
	echo $this->Html->script(array('jquery.colorbox'));
	echo $this->Html->css(array('colorbox/colorbox'))

?>
<div class="background" style="background-image: url('../img/new5.jpg'); width: 100%; height: 90vh">
<a href="javascript:void(0);" data-placement="right" class="report">CLICK HERE</a>
</div>
<div style="display: none">
	<div id="report" class="userreport-wrapper dialog" style="background: #ffffff;width: 460px;text-align: center;padding: 20px;">
		<div class="text">
			<?php 
				echo __('Reason for reporting');
				//å ±å‘Šã�™ã‚‹ç�†ç”± / Reason for report
			?>
		</div>
		<textarea class="report-reason" style="resize: none;"></textarea>
		<div class="button">
			<a href="javascript:void(0)" class="dialog-btn cancel-button">
				<?php echo __('Cancel')?>
			</a>
			<a href="javascript:void(0)" class="dialog-btn report-send">
				<?php echo __('Send')?>
			</a>
		</div>
	</div>
</div>
<script>
	$('.report').live('click', function(){
		$.colorbox({
			marginTop: '120',
			inline: true,
			href: '.userreport-wrapper',
			close: '',
			width: '1000px',
			height: '500px',
		});
	});


</script>
