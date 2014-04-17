<?php
$error = $this->Session->flash();
if (!empty($error)):
    ?>
    <div class="error">
        <?php echo $error; ?>
    </div>
<?php endif; ?>
    <h2>報告内容</h2>

<?php

echo $this->Form->create("Report");
//$opt = array('Copyright 違反','運用規約等に違反','タイトルが不適です');
//echo $this->Form->radio("報告.内容", $opt);
echo $this->Form->input('Content', array(
    'div' => false,
    'label' => true,
    'type' => 'radio',
    'legend' => false,
    'options' => array('Copyright 違反' => 'Copyright 違反<br> ', '運用規約等に違反' => '運用規約等に違反<br>', 'タイトルが不適です' => 'タイトルが不適です<br>')
));
echo $this->Form->hidden('UserId', array('value' => $userId));
echo $this->Form->hidden('LessonId', array('value' => $lessonId));
echo $this->Form->hidden('IsDeleted', array('value' => 1));
echo $this->Form->end('報告');
?>