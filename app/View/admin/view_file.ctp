<?php 
	// css file
	echo $this->Html->css(array(
		'font-awesome.min',
		'bootstrap/bootstrap',
		'uniform.default',
		'style-conquer',
		'style-responsive',
		'app',
		'jquery.fancybox'
	));
	// Js file
	echo $this->Html->script(array(
		'jquery-1.9.0.min',
		'jquery-migrate-1.2.1.min',
		'bootstrap',
		'jquery.blockui.min',
		'jquery.cookie.min',
		'jquery-ui.min.js',
		'jquery.metadata',
		'jquery.tablesorter',
		'jquery.tablesorter.min',
		'jquery.slimscroll.min',
		'bootstrap-typeahead',
		'jquery.validate.min',
		'jquery.fancybox',
		'jquery.fancybox.pack'
	)); 
?>
<div id="contents">
    <div id="content">
        <?php 
            $error = $this->Session->flash();
            if(!empty($error)):
        ?>
        <div class="error">
            <?php echo $error; ?>
        </div>
        <?php endif;?>
        <div class="box1">
            <div class="view_lesson"> 
                <div class="light_player">                       
                    <div style="width: 100%;">
                        <?php if($file['File']['Extension'] == 'pdf'):?>
                        <div class="file_l">
                            <iframe width='900' height='500' src="<?php echo '/elearning'.$file['File']['FileLink']?>"></iframe>
                        </div>
                        <?php endif;?>
                        <?php if ($file['File']['Extension'] == 'gif'|| $file['File']['Extension'] == 'jpg'||$file['File']['Extension'] == 'png'): ?>
                            <div class="file_l">
                                <?php echo $this->Html->image($file['File']['FileLink'], array('style' => 'display: block; margin-left: auto; margin-right: auto')); ?>
                            </div>
                        <?php endif; ?>
                        <?php if($file['File']['Extension'] == 'mp4'):?>
                        <div class="file_l" >
                            <video width="900" height="500" controls>
                            <source src="<?php echo '/elearning'.$file['File']['FileLink']?>" type="video/mp4">
                            お使いのブラウザはvideoタグをサポートしていません。
                            </video>
                        </div>
                        <?php endif;?>
                        <?php if($file['File']['Extension'] == 'mp3' || $file['File']['Extension'] == 'wav'):?>
                        <div class="file_l"style="margin:50px" >
                            <audio controls width='900' height='100'>
                              <source src="<?php echo '/elearning'.$file['File']['FileLink']?>" type="video/mp4" type="audio/mpeg">
                             お使いのブラウザはaudioタグをサポートしていません。
                            </audio>
                        </div>
                        <?php endif;?>
                    </div>                     
                </div>
            </div>
        </div>
    </div>
</div>